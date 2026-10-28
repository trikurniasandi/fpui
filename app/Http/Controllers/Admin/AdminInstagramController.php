<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramSetting;
use App\Services\InstagramFeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminInstagramController extends Controller
{
    /**
     * Tampilkan daftar akun Instagram.
     */
    public function index()
    {
        $accounts = InstagramSetting::query()->ordered()->get();

        return view('admin.setting.instagram.index', [
            'accounts' => $accounts,
            'statuses' => $accounts->mapWithKeys(
                fn (InstagramSetting $account) => [$account->id => $this->resolveStatus($account)]
            ),
            'apiVersion' => config('instagram.api_version'),
            'cacheTtl' => (int) config('instagram.cache_ttl', 1800),
            'refreshThreshold' => (int) config('instagram.refresh_threshold_days', 30),
        ]);
    }

    /**
     * Tampilkan form tambah akun.
     */
    public function create()
    {
        return view('admin.setting.instagram.create', [
            'account' => new InstagramSetting([
                'is_active' => true,
                'sort_order' => (int) InstagramSetting::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    /**
     * Simpan akun Instagram baru.
     */
    public function store(Request $request)
    {
        $request->merge([
            'username' => ltrim((string) $request->input('username'), '@'),
        ]);

        $validated = $request->validate($this->rules(), $this->messages());

        DB::beginTransaction();

        try {
            $account = new InstagramSetting;

            $account->label = filled($validated['label'] ?? null) ? $validated['label'] : null;
            $account->username = $validated['username'];
            $account->user_id = filled($validated['user_id'] ?? null) ? $validated['user_id'] : null;
            $account->is_active = $request->boolean('is_active');
            $account->sort_order = (int) ($validated['sort_order'] ?? 0);
            $account->access_token = $validated['access_token'];
            $account->token_expires_at = filled($validated['token_expires_at'] ?? null)
                ? $validated['token_expires_at']
                : now()->addDays((int) config('instagram.token_lifetime_days', 60));
            $account->last_refreshed_at = now();
            $account->last_error = null;

            $account->save();

            DB::commit();

            return redirect()
                ->route('admin.settings.instagram.index')
                ->with('success', 'Akun Instagram @'.$account->username.' berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan akun Instagram', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan akun Instagram.');
        }
    }

    /**
     * Tampilkan form edit akun.
     */
    public function edit(InstagramSetting $instagram)
    {
        return view('admin.setting.instagram.edit', [
            'account' => $instagram,
        ]);
    }

    /**
     * Perbarui akun Instagram.
     */
    public function update(Request $request, InstagramSetting $instagram)
    {
        $request->merge([
            'username' => ltrim((string) $request->input('username'), '@'),
        ]);

        $validated = $request->validate(
            $this->rules($instagram),
            $this->messages()
        );

        $original = clone $instagram;

        DB::beginTransaction();

        try {
            $instagram->label = filled($validated['label'] ?? null) ? $validated['label'] : null;
            $instagram->username = $validated['username'];
            $instagram->user_id = filled($validated['user_id'] ?? null) ? $validated['user_id'] : null;
            $instagram->is_active = $request->boolean('is_active');
            $instagram->sort_order = (int) ($validated['sort_order'] ?? 0);

            if (filled($validated['access_token'] ?? null)) {
                $instagram->access_token = $validated['access_token'];
                $instagram->token_expires_at = filled($validated['token_expires_at'] ?? null)
                    ? $validated['token_expires_at']
                    : now()->addDays((int) config('instagram.token_lifetime_days', 60));
                $instagram->last_refreshed_at = now();
                $instagram->last_error = null;
            } elseif (filled($validated['token_expires_at'] ?? null)) {
                $instagram->token_expires_at = $validated['token_expires_at'];
            }

            $instagram->save();

            // Bersihkan cache untuk identitas lama dan baru.
            InstagramFeedService::for($original)->clearCache();
            InstagramFeedService::for($instagram)->clearCache();

            DB::commit();

            return redirect()
                ->route('admin.settings.instagram.index')
                ->with('success', 'Akun Instagram @'.$instagram->username.' berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui akun Instagram', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui akun Instagram.');
        }
    }

    /**
     * Hapus akun Instagram.
     */
    public function destroy(InstagramSetting $instagram)
    {
        DB::beginTransaction();

        try {
            InstagramFeedService::for($instagram)->clearCache();

            $username = $instagram->username;
            $instagram->delete();

            DB::commit();

            return redirect()
                ->route('admin.settings.instagram.index')
                ->with('success', 'Akun Instagram @'.$username.' berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menghapus akun Instagram', ['error' => $e->getMessage()]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus akun Instagram.');
        }
    }

    /**
     * Uji koneksi ke Instagram API untuk satu akun.
     */
    public function test(InstagramSetting $instagram)
    {
        $result = InstagramFeedService::for($instagram)->testConnection();

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Perbarui token satu akun secara manual.
     */
    public function refresh(InstagramSetting $instagram)
    {
        $result = InstagramFeedService::for($instagram)->refreshToken(force: true);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Bersihkan cache feed satu akun.
     */
    public function clearCache(InstagramSetting $instagram)
    {
        InstagramFeedService::for($instagram)->clearCache();

        return back()->with('success', 'Cache feed @'.$instagram->username.' berhasil dibersihkan.');
    }

    /**
     * Aturan validasi form akun.
     *
     * @return array<string, mixed>
     */
    protected function rules(?InstagramSetting $account = null): array
    {
        return [
            'label' => ['nullable', 'string', 'max:60'],
            'username' => [
                'required',
                'string',
                'max:30',
                'regex:/^[A-Za-z0-9._]+$/',
                Rule::unique('instagram_settings', 'username')->ignore($account?->id),
            ],
            'user_id' => ['nullable', 'string', 'max:100'],
            'access_token' => [$account ? 'nullable' : 'required', 'string', 'max:2000'],
            'token_expires_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * Pesan validasi berbahasa Indonesia.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'label.max' => 'Label akun maksimal 60 karakter.',
            'username.required' => 'Username Instagram wajib diisi.',
            'username.regex' => 'Username Instagram hanya boleh berisi huruf, angka, titik, dan garis bawah.',
            'username.max' => 'Username Instagram maksimal 30 karakter.',
            'username.unique' => 'Username Instagram sudah dipakai akun lain.',
            'access_token.required' => 'Access token wajib diisi untuk akun baru.',
            'token_expires_at.date' => 'Tanggal kedaluwarsa token tidak valid.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
            'sort_order.min' => 'Urutan tampil minimal 0.',
            'sort_order.max' => 'Urutan tampil maksimal 9999.',
        ];
    }

    /**
     * Tentukan status koneksi untuk ditampilkan di halaman admin.
     *
     * @return array{key: string, label: string, description: string}
     */
    protected function resolveStatus(InstagramSetting $setting): array
    {
        if (! $setting->hasToken()) {
            return [
                'key' => 'not_configured',
                'label' => 'Belum dikonfigurasi',
                'description' => 'Tambahkan access token Instagram agar feed dapat ditampilkan di beranda.',
            ];
        }

        if (! $setting->is_active) {
            return [
                'key' => 'inactive',
                'label' => 'Nonaktif',
                'description' => 'Token tersimpan, tetapi feed sedang dinonaktifkan.',
            ];
        }

        if ($setting->tokenExpired()) {
            return [
                'key' => 'expired',
                'label' => 'Token kedaluwarsa',
                'description' => 'Token sudah kedaluwarsa. Perbarui token atau gunakan tombol Refresh Token.',
            ];
        }

        if ($setting->token_expires_at?->lte(now()->addDays(7))) {
            return [
                'key' => 'expiring',
                'label' => 'Segera kedaluwarsa',
                'description' => 'Token akan kedaluwarsa dalam waktu dekat. Refresh token disarankan.',
            ];
        }

        return [
            'key' => 'active',
            'label' => 'Aktif',
            'description' => 'Feed Instagram siap ditampilkan di beranda.',
        ];
    }
}
