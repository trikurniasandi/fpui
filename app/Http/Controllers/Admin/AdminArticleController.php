<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Publication::with(['author:id,name'])
            ->where('type', 'article')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.article.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);

            $count = Publication::where('slug', 'LIKE', "{$slug}%")->count();
            $finalSlug = $count ? "{$slug}-" . ($count + 1) : $slug;

            Publication::create([
                'title' => $validated['title'],
                'slug' => $finalSlug,
                'content' => $validated['content'],
                'status' => $validated['status'],
                'type' => 'article',
                'user_id' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal menambah artikel', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan artikel');
        }
    }

    public function edit($id)
    {
        $article = Publication::where('type', 'article')
            ->findOrFail($id);

        return view('admin.article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Publication::where('type', 'article')
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);

            if ($slug !== $article->slug) {
                $count = Publication::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $article->id)
                    ->count();

                $slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }

            $article->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'status' => $validated['status'],
            ]);

            DB::commit();
            return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal memperbarui artikel', ['article_id' => $id, 'error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui artikel');
        }
    }

    public function destroy($id)
    {
        $article = Publication::where('type', 'article')
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $article->delete();

            DB::commit();

            return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal menghapus artikel', ['article_id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus artikel');
        }
    }
}
