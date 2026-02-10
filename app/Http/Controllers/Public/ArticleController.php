<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Publication::with(['category:id,name'])
            ->where('type', 'article')
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        return view('public.article.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Publication::with(['category:id,name'])
            ->where('type', 'article')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.article.show', compact('article'));
    }

}
