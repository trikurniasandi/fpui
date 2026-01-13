<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = Publication::where('type','news')
            ->orderBy('created_at', 'desc')
            ->where('status', 'published')
            ->paginate(10);

        return view('public.news.index', compact('news'));    
    }

    public function show($slug)
    {
        $news = Publication::where('type', 'news')
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

        return view('public.news.show', compact('news'));
    }
}
