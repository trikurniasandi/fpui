<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $banner = Publication::where('status', 'published')
        ->where('show_on_banner', true)
        ->where(function ($q){
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

        return view('public.home', compact('publications', 'banner', 'organization'));    
    }

    public function about()
    {
        $organization = OrganizationProfile::first();

        return view('public.about', compact('organization'));
    }
}
