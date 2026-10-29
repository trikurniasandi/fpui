<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Listing publikasi berdasarkan tipe (article, news, best_practice, ...).
     */
    public function index(Request $request)
    {
        $type = $request->route('type');
        $meta = config("publications.{$type}");

        abort_unless($meta, 404);

        $publications = Publication::with(['category:id,name'])
            ->published()
            ->ofType($type)
            ->latest()
            ->paginate($meta['per_page'])
            ->withQueryString();

        return view('public.publication.index', [
            'type' => $type,
            'meta' => $meta,
            'publications' => $publications,
        ]);
    }

    /**
     * Detail publikasi. Hanya tersedia untuk tipe dengan has_detail = true.
     */
    public function show(Request $request, string $slug)
    {
        $type = $request->route('type');
        $meta = config("publications.{$type}");

        abort_unless($meta && $meta['has_detail'], 404);

        $publication = Publication::with(['category:id,name', 'author:id,name'])
            ->published()
            ->ofType($type)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.publication.show', [
            'type' => $type,
            'meta' => $meta,
            'publication' => $publication,
        ]);
    }
}
