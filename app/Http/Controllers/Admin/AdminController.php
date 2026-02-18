<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrganizationProfile;
use App\Models\Publication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalArticles = Publication::where('type', 'article')
        ->count();

        $totalNews = Publication::where('type', 'news')
        ->count();

        $totalPublished = Publication::where('status', 'published')
        ->count();

        $totalDraft = Publication::where('status', 'draft')
        ->count();

        $totalCategories = Category::count();

        $organization = OrganizationProfile::first();

        return view('admin.dashboard', compact(
            'totalArticles',
            'totalNews',
            'totalPublished',
            'totalDraft',
            'totalCategories',
            'organization'
        ));
    }
}
