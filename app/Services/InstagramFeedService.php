<?php

namespace App\Services;

use App\Models\InstagramSetting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InstagramFeedService
{
    /**
     * Baris pengaturan akun yang dipakai service ini.
     */
    protected ?InstagramSetting $setting = null;

    /**
     * Penanda apakah baris pengaturan sudah dicoba dimuat.
     */
    protected bool $settingLoaded = false;

    /**
     * Apakah token dari file .env boleh dipakai sebagai fallback.
     */
    protected bool $configFallback = true;

    /**
     * Service memakai akun default kecuali diikat lewat for().
     */
    public function __construct() {}

    /**
     * Buat service yang terikat ke satu akun Instagram.
     */
    public static function for(InstagramSetting $account): self
    {
        $service = new self;

        $service->setting = $account;
        $service->settingLoaded = true;
        $service->configFallback = false;

        return $service;
    }

    /**
     * Ambil daftar postingan terbaru dari Instagram API.
     *
     * Hasil sukses disimpan di cache selama beberapa menit karena URL media
     * Instagram CDN memiliki masa berlaku. Kegagalan tidak di-cache agar
     * permintaan berikutnya bisa mencoba lagi.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPosts(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        $cacheKey = $this->cacheKey('feed');

        $cached = Cache::get($cacheKey);

        if (is_array($cached)) {
            return $cached;
        }

        try {
            $response = $this->request()->get($this->endpoint($this->mediaPath()), [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,username,children{id,media_type,media_url,thumbnail_url}',
                'limit' => max(1, (int) config('instagram.limit', 8)),
                'access_token' => $this->accessToken(),
            ]);

            if ($response->failed()) {
                throw new \RuntimeException($this->failureMessage($response));
            }

            $posts = collect($response->json('data', []))
                ->filter(fn ($post) => is_array($post))
                ->map(fn (array $post) => $this->mapPost($post))
                ->filter()
                ->take(max(1, (int) config('instagram.limit', 8)))
                ->values()
                ->all();

            Cache::put(
                $cacheKey,
                $posts,
                now()->addSeconds(max(60, (int) config('instagram.cache_ttl', 1800)))
            );

            $this->clearError();

            return $posts;
        } catch (\Throwable $e) {
            $this->recordError($e->getMessage());

            Log::error('Gagal mengambil feed Instagram', [
                'account' => $this->username(),
                'error' => $this->redact($e->getMessage()),
            ]);

            return [];
        }
    }

    /**
     * Ambil profil akun Instagram yang terhubung.
     *
     * @return array<string, mixed>|null
     */
    public function getProfile(bool $fresh = false): ?array
    {
        if (blank($this->accessToken())) {
            return null;
        }

        $cacheKey = $this->cacheKey('profile');

        if (! $fresh) {
            $cached = Cache::get($cacheKey);

            if (is_array($cached)) {
                return $cached;
            }
        }

        try {
            $response = $this->request()->get($this->endpoint('me'), [
                'fields' => 'id,username,account_type,media_count',
                'access_token' => $this->accessToken(),
            ]);

            if ($response->failed()) {
                throw new \RuntimeException($this->failureMessage($response));
            }

            $data = $response->json();

            if (! is_array($data) || empty($data['id'])) {
                throw new \RuntimeException('Respons profil Instagram tidak valid.');
            }

            $profile = [
                'id' => (string) $data['id'],
                'username' => $data['username'] ?? $this->username(),
                'account_type' => $data['account_type'] ?? null,
                'media_count' => isset($data['media_count']) ? (int) $data['media_count'] : null,
            ];

            Cache::put(
                $cacheKey,
                $profile,
                now()->addSeconds(max(60, (int) config('instagram.profile_cache_ttl', 3600)))
            );

            $this->clearError();

            return $profile;
        } catch (\Throwable $e) {
            $this->recordError($e->getMessage());

            Log::error('Gagal mengambil profil Instagram', [
                'account' => $this->username(),
                'error' => $this->redact($e->getMessage()),
            ]);

            return null;
        }
    }

    /**
     * Uji koneksi ke Instagram API memakai token yang tersimpan.
     *
     * @return array{success: bool, message: string, profile?: array<string, mixed>}
     */
    public function testConnection(): array
    {
        if (blank($this->accessToken())) {
            return [
                'success' => false,
                'message' => 'Token akses Instagram belum diisi.',
            ];
        }

        $profile = $this->getProfile(true);

        if (! $profile) {
            $setting = $this->getSetting();
            $detail = $setting?->last_error
                ? Str::limit($setting->last_error, 180)
                : 'Periksa token, izin aplikasi Meta, dan koneksi server.';

            return [
                'success' => false,
                'message' => 'Koneksi ke Instagram gagal. '.$detail,
            ];
        }

        $setting = $this->getSetting();

        if ($setting) {
            $setting->forceFill([
                'username' => $setting->username ?: $profile['username'],
                'account_type' => $profile['account_type'],
                'last_error' => null,
            ])->saveQuietly();
        }

        $accountType = $profile['account_type'] ?: 'tipe akun tidak diketahui';
        $mediaCount = isset($profile['media_count']) ? ', '.$profile['media_count'].' media' : '';

        return [
            'success' => true,
            'message' => 'Koneksi berhasil. Akun @'.$profile['username'].' ('.$accountType.$mediaCount.').',
            'profile' => $profile,
        ];
    }

    /**
     * Perbarui long-lived access token.
     *
     * @return array{success: bool, skipped: bool, message: string}
     */
    public function refreshToken(bool $force = false): array
    {
        $setting = $this->getSetting();

        if (! $setting || ! $setting->hasToken()) {
            if ($this->configFallback && filled(config('instagram.access_token'))) {
                return [
                    'success' => false,
                    'skipped' => true,
                    'message' => 'Token Instagram berasal dari file .env. Perbarui nilainya secara manual.',
                ];
            }

            return [
                'success' => false,
                'skipped' => true,
                'message' => 'Token Instagram belum diatur.',
            ];
        }

        if (! $force && ! $this->shouldRefresh($setting)) {
            return [
                'success' => true,
                'skipped' => true,
                'message' => 'Token Instagram masih berlaku, tidak perlu diperbarui.',
            ];
        }

        try {
            $response = Http::timeout(max(5, (int) config('instagram.timeout', 10)))
                ->retry(2, 250, throw: false)
                ->acceptJson()
                ->get($this->baseUrl().'/refresh_access_token', [
                    'grant_type' => 'ig_refresh_token',
                    'access_token' => $setting->access_token,
                ]);

            if ($response->failed()) {
                throw new \RuntimeException($this->failureMessage($response));
            }

            $data = $response->json();

            if (! is_array($data) || empty($data['access_token'])) {
                throw new \RuntimeException('Respons refresh token Instagram tidak valid.');
            }

            $expiresIn = (int) ($data['expires_in'] ?? (config('instagram.token_lifetime_days', 60) * 86400));

            $setting->forceFill([
                'access_token' => $data['access_token'],
                'token_expires_at' => now()->addSeconds(max(3600, $expiresIn)),
                'last_refreshed_at' => now(),
                'last_error' => null,
            ])->save();

            $this->clearCache();

            return [
                'success' => true,
                'skipped' => false,
                'message' => 'Token Instagram berhasil diperbarui. Berlaku hingga '
                    .$setting->token_expires_at->translatedFormat('d F Y H:i').'.',
            ];
        } catch (\Throwable $e) {
            $this->recordError($e->getMessage());

            Log::error('Gagal memperbarui token Instagram', [
                'account' => $this->username(),
                'error' => $this->redact($e->getMessage()),
            ]);

            return [
                'success' => false,
                'skipped' => false,
                'message' => 'Gagal memperbarui token Instagram. '.Str::limit($this->redact($e->getMessage()), 180),
            ];
        }
    }

    /**
     * Hapus cache feed dan profil akun ini.
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey('feed'));
        Cache::forget($this->cacheKey('profile'));
    }

    /**
     * Hapus cache semua akun Instagram.
     */
    public static function clearAllCaches(): void
    {
        InstagramSetting::query()->get()->each(
            fn (InstagramSetting $account) => self::for($account)->clearCache()
        );
    }

    /**
     * Apakah feed Instagram siap ditampilkan.
     */
    public function isConfigured(): bool
    {
        if (! config('instagram.enabled', true)) {
            return false;
        }

        if (blank($this->accessToken())) {
            return false;
        }

        $setting = $this->getSetting();

        if ($setting) {
            return (bool) $setting->is_active;
        }

        return $this->configFallback;
    }

    /**
     * Username akun Instagram yang dipakai.
     */
    public function username(): string
    {
        $username = $this->getSetting()?->username
            ?: config('instagram.username')
            ?: 'fpui.official';

        return ltrim((string) $username, '@');
    }

    /**
     * URL profil Instagram yang dipakai.
     */
    public function profileUrl(): string
    {
        $setting = $this->getSetting();

        if ($setting && filled($setting->username)) {
            return 'https://www.instagram.com/'.ltrim($setting->username, '@');
        }

        return (string) config('instagram.profile_url', 'https://www.instagram.com/fpui.official');
    }

    /**
     * Ambil baris pengaturan Instagram.
     */
    public function getSetting(): ?InstagramSetting
    {
        if (! $this->settingLoaded) {
            $this->setting = InstagramSetting::defaultAccount();
            $this->settingLoaded = true;
        }

        return $this->setting;
    }

    /**
     * Apakah token sudah waktunya diperbarui.
     */
    protected function shouldRefresh(InstagramSetting $setting): bool
    {
        if (! $setting->token_expires_at) {
            return true;
        }

        $threshold = max(1, (int) config('instagram.refresh_threshold_days', 30));

        return $setting->token_expires_at->lte(now()->addDays($threshold));
    }

    /**
     * Token akses aktif (DB lebih diutamakan daripada .env).
     */
    protected function accessToken(): ?string
    {
        try {
            $token = $this->getSetting()?->access_token;
        } catch (\Throwable $e) {
            Log::error('Gagal membaca token Instagram dari database', [
                'error' => $e->getMessage(),
            ]);

            $token = null;
        }

        if (filled($token)) {
            return (string) $token;
        }

        if (! $this->configFallback) {
            return null;
        }

        $fallback = config('instagram.access_token');

        return filled($fallback) ? (string) $fallback : null;
    }

    /**
     * Path endpoint media.
     */
    protected function mediaPath(): string
    {
        $userId = $this->getSetting()?->user_id
            ?: ($this->configFallback ? config('instagram.user_id') : null);

        return filled($userId) ? trim((string) $userId).'/media' : 'me/media';
    }

    /**
     * Bangun URL endpoint API yang sudah memakai versi.
     */
    protected function endpoint(string $path): string
    {
        $version = trim((string) config('instagram.api_version', 'v23.0'), '/');

        return $this->baseUrl().'/'.$version.'/'.ltrim($path, '/');
    }

    /**
     * Base URL Instagram Graph API.
     */
    protected function baseUrl(): string
    {
        return rtrim((string) config('instagram.base_url', 'https://graph.instagram.com'), '/');
    }

    /**
     * HTTP client dasar untuk Instagram API.
     */
    protected function request(): PendingRequest
    {
        return Http::timeout(max(5, (int) config('instagram.timeout', 10)))
            ->retry(2, 250, throw: false)
            ->acceptJson();
    }

    /**
     * Ubah satu item media menjadi payload siap tampil.
     *
     * @param  array<string, mixed>  $post
     * @return array<string, mixed>|null
     */
    protected function mapPost(array $post): ?array
    {
        $image = $this->resolveImage($post);

        if (! $image) {
            return null;
        }

        $caption = $this->cleanCaption($post['caption'] ?? '');
        $username = ltrim((string) ($post['username'] ?? $this->username()), '@');
        $timestamp = isset($post['timestamp']) ? Carbon::parse($post['timestamp']) : null;
        $mediaType = $post['media_type'] ?? 'IMAGE';

        return [
            'id' => (string) ($post['id'] ?? ''),
            'caption' => $caption,
            'image' => $image,
            'permalink' => $this->safePermalink($post['permalink'] ?? null),
            'date' => $timestamp?->translatedFormat('d F Y'),
            'relative_date' => $timestamp?->diffForHumans(),
            'username' => $username,
            'is_video' => $mediaType === 'VIDEO',
            'is_carousel' => $mediaType === 'CAROUSEL_ALBUM',
            'alt' => Str::limit($caption ?: 'Postingan Instagram @'.$username, 100),
        ];
    }

    /**
     * Tentukan gambar terbaik dari sebuah media.
     *
     * @param  array<string, mixed>  $post
     */
    protected function resolveImage(array $post): ?string
    {
        $mediaType = $post['media_type'] ?? 'IMAGE';

        if ($mediaType === 'CAROUSEL_ALBUM') {
            foreach ($post['children']['data'] ?? [] as $child) {
                if (! is_array($child)) {
                    continue;
                }

                $image = $this->resolveImage($child);

                if ($image) {
                    return $image;
                }
            }
        }

        if ($mediaType === 'VIDEO') {
            return $this->validUrl($post['thumbnail_url'] ?? null)
                ?: $this->validUrl($post['media_url'] ?? null);
        }

        return $this->validUrl($post['media_url'] ?? null)
            ?: $this->validUrl($post['thumbnail_url'] ?? null);
    }

    /**
     * Bersihkan caption dari HTML dan rapikan whitespace.
     */
    protected function cleanCaption(?string $caption): string
    {
        $caption = html_entity_decode(strip_tags((string) $caption), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $caption = preg_replace('/\s+/u', ' ', $caption) ?? '';

        return Str::limit(trim($caption), 300);
    }

    /**
     * Pastikan permalink mengarah ke Instagram.
     */
    protected function safePermalink(?string $permalink): string
    {
        $permalink = (string) $permalink;

        if (str_starts_with($permalink, 'https://www.instagram.com/')
            || str_starts_with($permalink, 'https://instagram.com/')) {
            return $permalink;
        }

        return $this->profileUrl();
    }

    /**
     * Validasi URL gambar.
     */
    protected function validUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return str_starts_with($url, 'https://') ? $url : null;
    }

    /**
     * Pesan kegagalan dari respons API.
     */
    protected function failureMessage(Response $response): string
    {
        $message = $response->json('error.message')
            ?: $response->json('error.error_user_msg')
            ?: Str::limit(strip_tags($response->body()), 300);

        return 'Instagram API error ('.$response->status().'): '.($message ?: 'tanpa pesan');
    }

    /**
     * Simpan pesan error terakhir (tanpa membocorkan token).
     */
    protected function recordError(string $message): void
    {
        $setting = $this->getSetting();

        if (! $setting) {
            return;
        }

        try {
            $setting->forceFill([
                'last_error' => Str::limit($this->redact($message), 900),
            ])->saveQuietly();
        } catch (\Throwable) {
            // Kegagalan menyimpan diagnostik tidak boleh menghentikan request.
        }
    }

    /**
     * Hapus pesan error terakhir setelah request berhasil.
     */
    protected function clearError(): void
    {
        $setting = $this->getSetting();

        if (! $setting || $setting->last_error === null) {
            return;
        }

        try {
            $setting->forceFill(['last_error' => null])->saveQuietly();
        } catch (\Throwable) {
            // Abaikan.
        }
    }

    /**
     * Sensor token pada pesan yang akan disimpan/di-log.
     */
    protected function redact(string $message): string
    {
        $token = $this->accessToken();

        if (filled($token)) {
            $message = str_replace($token, '[redacted]', $message);
        }

        return preg_replace('/(access_token=)[^&\s"\']+/i', '$1[redacted]', $message) ?? $message;
    }

    /**
     * Cache key yang ikut berubah saat akun/token berubah.
     */
    protected function cacheKey(string $suffix): string
    {
        $setting = $this->getSetting();

        $identity = implode('|', [
            $setting?->id ?? 'config',
            $this->username(),
            md5((string) $this->accessToken()),
        ]);

        return 'instagram:'.$suffix.':'.md5($identity);
    }
}
