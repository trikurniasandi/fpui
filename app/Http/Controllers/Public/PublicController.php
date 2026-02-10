<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $publications = Publication::with(['category:id,name'])
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        return view('public.home', compact('publications'));    
    }

    public function about()
    {
        return view('public.about');
    }
}
