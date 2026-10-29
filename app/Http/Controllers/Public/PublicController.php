<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\InstagramSetting;
use App\Models\OrganizationProfile;
use App\Models\Publication;

class PublicController extends Controller
{
    public function index()
    {
        $featured = Publication::where('status', 'published')
            ->where('show_on_banner', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            })
            ->select('id', 'title', 'type', 'slug', 'content', 'thumbnail')
            ->latest()
            ->get();

        $publications = Publication::with(['category:id,name'])
            ->where('status', 'published')
            ->latest()
            ->select('id', 'title', 'slug', 'type', 'content', 'created_at')
            ->paginate(6);

        $organization = OrganizationProfile::first();

        $banner = Banner::where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            })
            ->select('id', 'title', 'description', 'thumbnail', 'created_at')
            ->latest()
            ->get();

        $featured->each(function ($item) {
            $item->source = 'publication';
        });

        $banner->each(function ($item) {
            $item->source = 'banner';
        });

        $heroItems = $banner
            ->concat($featured)
            ->sortByDesc('created_at')
            ->values();

        $instagramAccounts = InstagramSetting::query()
            ->active()
            ->ordered()
            ->get()
            ->filter(fn (InstagramSetting $account) => $account->hasToken())
            ->values()
            ->map(fn (InstagramSetting $account) => [
                'id' => (string) $account->id,
                'label' => $account->displayName(),
                'username' => ltrim((string) $account->username, '@'),
                'profile_url' => $account->profileUrl(),
                'endpoint' => route('instagram.feed.account', $account),
            ]);

        return view('public.home', compact(
            'heroItems',
            'publications',
            'organization',
            'instagramAccounts'
        ));
    }

}
