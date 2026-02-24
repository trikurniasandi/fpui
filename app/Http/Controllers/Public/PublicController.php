<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\OrganizationProfile;
use App\Models\Publication;
use Illuminate\Http\Request;

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

        return view('public.home', compact('heroItems', 'publications', 'organization'));
    }

    public function about()
    {
        $organization = OrganizationProfile::first();

        return view('public.about', compact('organization'));
    }

    public function organization_structure()
    {
        return view('public.structure');
    }

    public function history()
    {
        return view('public.history');
    }
}
