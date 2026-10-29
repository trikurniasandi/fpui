<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminPhotoController extends Controller
{
    public function index(Request $request)
    {
        $photos = Photo::with(['author:id,name'])
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.photo.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.photo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'taken_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = $request->file('image')->store('photos', 'public');

            Photo::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image' => $imagePath,
                'taken_at' => $validated['taken_at'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.photo.index')
                ->with('success', 'Foto berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah foto', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan foto');
        }
    }

    public function edit(Photo $photo)
    {
        return view('admin.photo.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'taken_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = $photo->image;

            if ($request->hasFile('image')) {
                if ($photo->image) {
                    Storage::disk('public')->delete($photo->image);
                }

                $imagePath = $request->file('image')->store('photos', 'public');
            }

            $photo->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image' => $imagePath,
                'taken_at' => $validated['taken_at'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.photo.index')
                ->with('success', 'Foto berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui foto', [
                'photo_id' => $photo->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui foto');
        }
    }

    public function destroy(Photo $photo)
    {
        DB::beginTransaction();

        try {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }

            $photo->delete();

            DB::commit();

            return redirect()
                ->route('admin.photo.index')
                ->with('success', 'Foto berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus foto', [
                'photo_id' => $photo->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus foto');
        }
    }
}
