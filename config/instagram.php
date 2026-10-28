<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Instagram Feed
    |--------------------------------------------------------------------------
    |
    | Konfigurasi integrasi Instagram API resmi (Instagram Login / Business
    | Login). Token utama disimpan terenkripsi di tabel instagram_settings
    | dan dikelola melalui halaman admin. Nilai di bawah ini hanya fallback
    | dan pengaturan default.
    |
    */

    'enabled' => env('INSTAGRAM_FEED_ENABLED', true),

    'username' => env('INSTAGRAM_USERNAME', 'fpui.official'),

    'user_id' => env('INSTAGRAM_USER_ID'),

    'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),

    'profile_url' => env('INSTAGRAM_PROFILE_URL', 'https://www.instagram.com/fpui.official'),

    'base_url' => env('INSTAGRAM_BASE_URL', 'https://graph.instagram.com'),

    'api_version' => env('INSTAGRAM_API_VERSION', 'v23.0'),

    'limit' => (int) env('INSTAGRAM_FEED_LIMIT', 8),

    'cache_ttl' => (int) env('INSTAGRAM_CACHE_TTL', 1800),

    'profile_cache_ttl' => (int) env('INSTAGRAM_PROFILE_CACHE_TTL', 3600),

    'timeout' => (int) env('INSTAGRAM_TIMEOUT', 10),

    'refresh_threshold_days' => (int) env('INSTAGRAM_REFRESH_THRESHOLD_DAYS', 30),

    'token_lifetime_days' => (int) env('INSTAGRAM_TOKEN_LIFETIME_DAYS', 60),

];
