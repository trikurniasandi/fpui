<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Publication::where('type', 'article')
            ->orderBy('created_at', 'desc')
            ->where('status', 'published')
            ->paginate(10);

        return view('public.article.index', compact('articles'));    
    }

    public function show($slug)
    {
        $article = Publication::where('type', 'article')
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

        return view('public.article.show', compact('article'));
    }

}
