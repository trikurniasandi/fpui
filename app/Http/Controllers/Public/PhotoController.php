<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::published()
            ->orderByRaw('taken_at IS NULL')
            ->orderByDesc('taken_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('public.photo.index', compact('photos'));
    }
}
