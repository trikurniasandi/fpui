<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Document;
use App\Models\OrganizationProfile;
use App\Models\Photo;
use App\Models\Publication;

class AdminController extends Controller
{
    public function index()
    {
        $totalBanners = Banner::count();

        $typeCounts = collect(config('publications'))
            ->mapWithKeys(fn ($meta, $type) => [$type => Publication::ofType($type)->count()]);

        $totalPublications = $typeCounts->sum();

        $totalArticles = $typeCounts['article'] ?? 0;

        $totalNews = $typeCounts['news'] ?? 0;

        $totalPublished = Publication::where('status', 'published')
            ->count();

        $totalDraft = Publication::where('status', 'draft')
            ->count();

        $totalDocuments = Document::count();

        $totalPhotos = Photo::count();

        $totalCategories = Category::count();

        $organization = OrganizationProfile::first();

        return view('admin.dashboard', compact(
            'totalBanners',
            'typeCounts',
            'totalPublications',
            'totalArticles',
            'totalNews',
            'totalPublished',
            'totalDraft',
            'totalDocuments',
            'totalPhotos',
            'totalCategories',
            'organization'
        ));
    }
}
