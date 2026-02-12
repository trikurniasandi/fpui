<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name', 'slug', 'created_at')
            ->when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->paginate(10);
    
        return view('admin.setting.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.setting.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
          
            $slug = Str::slug($validated['name']);

            $count = Category::where('slug', 'LIKE', "{$slug}%")->count();
            $finalSlug = $count ? "{$slug}-" . ($count + 1) : $slug;
            
            Category::create([
                'name' => $validated['name'],
                'slug' => $finalSlug,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.category.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah kategori', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan kategori');
        }
    }

   public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.setting.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            if ($category->name !== $validated['name']) {
                while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }
            } else {
                $slug = $category->slug;
            }

            $category->update([
                'name' => $validated['name'],
                'slug' => $slug,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.category.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui kategori', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui kategori');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $category->delete();

            DB::commit();
            return redirect()->route('admin.settings.category.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus kategori', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus kategori');
        }
    }
}
