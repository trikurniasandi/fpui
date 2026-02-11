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

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $news = Publication::with(['author:id,name', 'category:id,name'])
            ->where('type', 'news')

            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })

            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })

            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })

            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $categories = Category::orderBy('name')->get();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        return view('admin.news.create', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'expired_at' => 'nullable|date|after:now',
        ]);

        $request->merge([
            'show_on_banner' => $request->has('show_on_banner'),
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);

            $count = Publication::where('slug', 'LIKE', "{$slug}%")->count();
            $finalSlug = $count ? "{$slug}-" . ($count + 1) : $slug;

            $thumbnailPath = null;
            $attachmentPath = null;

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store('news/thumbnails', 'public');
            }

            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')
                    ->store('news/attachments', 'public');
            }

            Publication::create([
                'title' => $validated['title'],
                'slug' => $finalSlug,
                'content' => $validated['content'],
                'status' => $validated['status'],
                'category_id' => $validated['category_id'],
                'thumbnail' => $thumbnailPath,
                'attachment' => $attachmentPath,
                'type' => 'news',
                'user_id' => Auth::id(),
                'show_on_banner' => $request->show_on_banner,
                'expired_at' => $request->show_on_banner ? $request->expired_at : null,
            ]);

            DB::commit();
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal menambah berita', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan berita');
        }
    }

    public function edit($id)
    {
        $news = Publication::where('type', 'news')
            ->findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $news = Publication::where('type', 'news')
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'expired_at' => 'nullable|date|after:now',
        ]);

        $request->merge([
            'show_on_banner' => $request->has('show_on_banner'),
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);

            if ($slug !== $news->slug) {
                $count = Publication::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $news->id)
                    ->count();

                $slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }

            $thumbnailPath = $news->thumbnail;
            if ($request->hasFile('thumbnail')) {
                if ($news->thumbnail) {
                    Storage::disk('public')->delete($news->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')
                    ->store('news/thumbnails', 'public');
            }

            $attachmentPath = $news->attachment;
            if ($request->hasFile('attachment')) {
                if ($news->attachment) {
                    Storage::disk('public')->delete($news->attachment);
                }

                $attachmentPath = $request->file('attachment')
                    ->store('news/attachments', 'public');
            }

            $news->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'status' => $validated['status'],
                'category_id' => $validated['category_id'],
                'thumbnail' => $thumbnailPath,
                'attachment' => $attachmentPath,
                'show_on_banner' => $request->show_on_banner,
                'expired_at' => $request->show_on_banner ? $request->expired_at : null,
            ]);

            DB::commit();
            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Berita berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal memperbarui berita', [
                'news_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berita');
        }
    }

    public function destroy($id)
    {
        $news = Publication::where('type', 'news')
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }

            if ($news->attachment) {
                Storage::disk('public')->delete($news->attachment);
            }

            $news->delete();

            DB::commit();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Berita berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal menghapus berita', [
                'news_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus berita');
        }
    }
}
