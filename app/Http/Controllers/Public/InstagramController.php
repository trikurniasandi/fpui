<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InstagramSetting;
use App\Services\InstagramFeedService;
use Illuminate\Http\JsonResponse;

class InstagramController extends Controller
{
    /**
     * Endpoint JSON feed Instagram untuk akun default (kompatibilitas).
     */
    public function feed(InstagramFeedService $instagram): JsonResponse
    {
        $posts = config('instagram.enabled', true)
            ? $instagram->getPosts()
            : [];

        return response()
            ->json([
                'posts' => $posts,
                'profile_url' => $instagram->profileUrl(),
                'username' => $instagram->username(),
            ])
            ->header('Cache-Control', 'no-store');
    }

    /**
     * Endpoint JSON feed Instagram untuk satu akun.
     */
    public function feedAccount(InstagramSetting $instagram): JsonResponse
    {
        if (! config('instagram.enabled', true)
            || ! $instagram->is_active
            || ! $instagram->hasToken()) {
            abort(404);
        }

        $service = InstagramFeedService::for($instagram);

        return response()
            ->json([
                'posts' => $service->getPosts(),
                'profile_url' => $service->profileUrl(),
                'username' => $service->username(),
            ])
            ->header('Cache-Control', 'no-store');
    }
}
