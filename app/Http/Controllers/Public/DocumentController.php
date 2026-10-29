<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Listing dokumen berdasarkan jenis (regulasi, pedoman, modul, ...).
     */
    public function index(Request $request)
    {
        $type = $request->route('type');
        $meta = config("documents.{$type}");

        abort_unless($meta, 404);

        $documents = Document::published()
            ->ofType($type)
            ->orderByRaw('published_at IS NULL')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('public.informasi.index', [
            'type' => $type,
            'meta' => $meta,
            'documents' => $documents,
        ]);
    }
}
