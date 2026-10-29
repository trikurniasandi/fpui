<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::with(['author:id,name'])
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.document.index', [
            'documents' => $documents,
            'types' => config('documents'),
        ]);
    }

    public function create()
    {
        return view('admin.document.create', [
            'types' => config('documents'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $filePath = $request->hasFile('file')
            ? $request->file('file')->store('documents', 'public')
            : null;

        if (! $filePath && ! $request->external_url) {
            return back()->withInput()
                ->with('error', 'Unggah berkas atau isi tautan eksternal.');
        }

        DB::beginTransaction();

        try {
            Document::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'title' => $validated['title'],
                'slug' => $this->uniqueSlug($validated['title']),
                'description' => $validated['description'] ?? null,
                'file' => $filePath,
                'external_url' => $validated['external_url'] ?? null,
                'published_at' => $validated['published_at'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.document.index')
                ->with('success', 'Dokumen berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah dokumen', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan dokumen');
        }
    }

    public function edit(Document $document)
    {
        return view('admin.document.edit', [
            'document' => $document,
            'types' => config('documents'),
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate($this->rules());

        $filePath = $document->file;

        if ($request->hasFile('file')) {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }

            $filePath = $request->file('file')->store('documents', 'public');
        }

        if (! $filePath && ! $request->external_url) {
            return back()->withInput()
                ->with('error', 'Unggah berkas atau isi tautan eksternal.');
        }

        DB::beginTransaction();

        try {
            $document->update([
                'type' => $validated['type'],
                'title' => $validated['title'],
                'slug' => $this->uniqueSlug($validated['title'], $document->id, $document->slug),
                'description' => $validated['description'] ?? null,
                'file' => $filePath,
                'external_url' => $validated['external_url'] ?? null,
                'published_at' => $validated['published_at'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.document.index')
                ->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui dokumen', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui dokumen');
        }
    }

    public function destroy(Document $document)
    {
        DB::beginTransaction();

        try {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }

            $document->delete();

            DB::commit();

            return redirect()
                ->route('admin.document.index')
                ->with('success', 'Dokumen berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus dokumen', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus dokumen');
        }
    }

    private function rules(): array
    {
        return [
            'type' => 'required|in:' . implode(',', array_keys(config('documents'))),
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'external_url' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ];
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null, ?string $currentSlug = null): string
    {
        $slug = Str::slug($title);

        if ($currentSlug && $slug === $currentSlug) {
            return $currentSlug;
        }

        $count = Document::where('slug', 'LIKE', "{$slug}%")
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }
}
