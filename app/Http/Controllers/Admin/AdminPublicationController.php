<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPublicationController extends Controller
{
    /**
     * Seluruh tipe publikasi memakai controller ini; tipe ditentukan
     * oleh default parameter route (lihat routes/web.php).
     */
    public function index(Request $request)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        $publications = Publication::with(['author:id,name', 'category:id,name'])
            ->ofType($type)
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })
            ->when($request->category && $meta['has_category'], function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.publication.index', [
            'type' => $type,
            'meta' => $meta,
            'publications' => $publications,
            'categories' => $meta['has_category'] ? Category::orderBy('name')->get() : collect(),
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        return view('admin.publication.create', [
            'type' => $type,
            'meta' => $meta,
            'categories' => $meta['has_category'] ? Category::orderBy('name')->get() : collect(),
        ]);
    }

    public function store(Request $request)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        $validated = $request->validate($this->rules($meta));

        $request->merge([
            'show_on_banner' => $meta['has_banner'] && $request->has('show_on_banner'),
        ]);

        DB::beginTransaction();

        try {
            $thumbnailPath = null;
            $attachmentPath = null;

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store($meta['folder'] . '/thumbnails', 'public');
            }

            if ($meta['has_attachment'] && $request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')
                    ->store($meta['folder'] . '/attachments', 'public');
            }

            Publication::create([
                'title' => $validated['title'],
                'slug' => $this->uniqueSlug($validated['title']),
                'content' => $this->content($request, $meta),
                'status' => $validated['status'],
                'category_id' => $meta['has_category'] ? ($request->category_id ?: null) : null,
                'thumbnail' => $thumbnailPath,
                'attachment' => $attachmentPath,
                'video_url' => $meta['has_video'] ? $request->video_url : null,
                'type' => $type,
                'user_id' => Auth::id(),
                'show_on_banner' => $request->show_on_banner,
                'expired_at' => $request->show_on_banner ? $request->expired_at : null,
            ]);

            DB::commit();

            return redirect()
                ->route($meta['admin_route'] . '.index')
                ->with('success', $meta['label_singular'] . ' berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah publikasi', [
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan ' . strtolower($meta['label_singular']));
        }
    }

    public function edit(Request $request, $id)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        $publication = Publication::ofType($type)->findOrFail($id);

        return view('admin.publication.edit', [
            'type' => $type,
            'meta' => $meta,
            'publication' => $publication,
            'categories' => $meta['has_category'] ? Category::orderBy('name')->get() : collect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        $publication = Publication::ofType($type)->findOrFail($id);

        $validated = $request->validate($this->rules($meta));

        $request->merge([
            'show_on_banner' => $meta['has_banner'] && $request->has('show_on_banner'),
        ]);

        DB::beginTransaction();

        try {
            $slug = $this->uniqueSlug($validated['title'], $publication->id, $publication->slug);

            $thumbnailPath = $publication->thumbnail;
            if ($request->hasFile('thumbnail')) {
                if ($publication->thumbnail) {
                    Storage::disk('public')->delete($publication->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')
                    ->store($meta['folder'] . '/thumbnails', 'public');
            }

            $attachmentPath = $publication->attachment;
            if ($meta['has_attachment'] && $request->hasFile('attachment')) {
                if ($publication->attachment) {
                    Storage::disk('public')->delete($publication->attachment);
                }

                $attachmentPath = $request->file('attachment')
                    ->store($meta['folder'] . '/attachments', 'public');
            }

            $publication->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $this->content($request, $meta),
                'status' => $validated['status'],
                'category_id' => $meta['has_category'] ? ($request->category_id ?: null) : null,
                'thumbnail' => $thumbnailPath,
                'attachment' => $attachmentPath,
                'video_url' => $meta['has_video'] ? $request->video_url : null,
                'show_on_banner' => $request->show_on_banner,
                'expired_at' => $request->show_on_banner ? $request->expired_at : null,
            ]);

            DB::commit();

            return redirect()
                ->route($meta['admin_route'] . '.index')
                ->with('success', $meta['label_singular'] . ' berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui publikasi', [
                'type' => $type,
                'publication_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui ' . strtolower($meta['label_singular']));
        }
    }

    public function destroy(Request $request, $id)
    {
        $type = $request->route('type');
        $meta = $this->meta($type);

        $publication = Publication::ofType($type)->findOrFail($id);

        DB::beginTransaction();

        try {
            if ($publication->thumbnail) {
                Storage::disk('public')->delete($publication->thumbnail);
            }

            if ($publication->attachment) {
                Storage::disk('public')->delete($publication->attachment);
            }

            $publication->delete();

            DB::commit();

            return redirect()
                ->route($meta['admin_route'] . '.index')
                ->with('success', $meta['label_singular'] . ' berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus publikasi', [
                'type' => $type,
                'publication_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus ' . strtolower($meta['label_singular']));
        }
    }

    private function meta(string $type): array
    {
        $meta = config("publications.{$type}");

        abort_unless($meta, 404);

        return $meta;
    }

    private function rules(array $meta): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        if ($meta['has_content']) {
            $rules['content'] = $meta['content_required'] ? 'required' : 'nullable|string';
        }

        if ($meta['has_category']) {
            $rules['category_id'] = $meta['category_required']
                ? 'required|exists:categories,id'
                : 'nullable|exists:categories,id';
        }

        if ($meta['has_attachment']) {
            $rules['attachment'] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120';
        }

        if ($meta['has_video']) {
            $rules['video_url'] = 'required|url|max:255';
        }

        if ($meta['has_banner']) {
            $rules['expired_at'] = 'nullable|date|after:now';
        }

        return $rules;
    }

    private function content(Request $request, array $meta): string
    {
        if (! $meta['has_content']) {
            return '';
        }

        return (string) $request->input('content', '');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null, ?string $currentSlug = null): string
    {
        $slug = Str::slug($title);

        // Judul tidak berubah: pertahankan slug lama agar tautan publik tetap valid.
        if ($currentSlug && $slug === $currentSlug) {
            return $currentSlug;
        }

        $count = Publication::where('slug', 'LIKE', "{$slug}%")
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }
}
