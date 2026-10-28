<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InstagramSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'username',
        'user_id',
        'access_token',
        'token_expires_at',
        'account_type',
        'is_active',
        'sort_order',
        'last_refreshed_at',
        'last_error',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'access_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'access_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'last_refreshed_at' => 'datetime',
    ];

    /**
     * Batasi query ke akun yang aktif ditampilkan.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Urutkan akun sesuai posisi tampil di beranda.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get the default settings row used by the application.
     */
    public static function current(): ?self
    {
        return static::query()->oldest('id')->first();
    }

    /**
     * Akun aktif pertama yang siap dipakai sebagai fallback.
     */
    public static function defaultAccount(): ?self
    {
        return static::query()->active()->ordered()->first()
            ?? static::query()->ordered()->first();
    }

    /**
     * Apakah access token tersedia dan dapat didekripsi.
     */
    public function hasToken(): bool
    {
        try {
            return filled($this->access_token);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Label akun untuk tab dan daftar admin.
     */
    public function displayName(): string
    {
        if (filled($this->label)) {
            return (string) $this->label;
        }

        return '@'.ltrim((string) $this->username, '@');
    }

    /**
     * URL profil Instagram akun ini.
     */
    public function profileUrl(): string
    {
        if (filled($this->username)) {
            return 'https://www.instagram.com/'.ltrim((string) $this->username, '@');
        }

        return (string) config('instagram.profile_url', 'https://www.instagram.com/fpui.official');
    }

    /**
     * Apakah token sudah kedaluwarsa.
     */
    public function tokenExpired(): bool
    {
        return $this->token_expires_at !== null && $this->token_expires_at->isPast();
    }
}
