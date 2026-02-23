<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::with(['author:id,name'])
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })
            
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'expired_at' => 'nullable|date|after:now',
        ]);

        DB::beginTransaction();

        try {

            $thumbnailPath = null;

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store('banners/thumbnails', 'public');
            }

            Banner::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'user_id' => Auth::id(),
                'thumbnail' => $thumbnailPath,
                'expired_at' => $validated['expired_at'],
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah banner', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan banner');
        }
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {

        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'expired_at' => 'nullable|date|after:now',
        ]);

        DB::beginTransaction();

        try {
            
            $thumbnailPath = $banner->thumbnail;

            if ($request->hasFile('thumbnail')) {

                if ($banner->thumbnail && Storage::disk('public')->exists($banner->thumbnail)) {
                    Storage::disk('public')->delete($banner->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')
                    ->store('banners/thumbnails', 'public');
            }

            $banner->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'thumbnail' => $thumbnailPath,
                'expired_at' => $validated['expired_at'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')
                ->with('success', 'Banner berhasil diperbarui');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update banner', ['error' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui banner');
        }
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($banner->thumbnail) {
                Storage::disk('public')->delete($banner->thumbnail);
            }

            if ($banner->attachment) {
                Storage::disk('public')->delete($banner->attachment);
            }

            $banner->delete();

            DB::commit();

            return redirect()
                ->route('admin.banner.index')
                ->with('success', 'Banner berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('Gagal menghapus banner', [
                'banner_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus banner');
        }
    }


}
