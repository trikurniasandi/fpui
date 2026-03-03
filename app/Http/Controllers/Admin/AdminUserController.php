<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->paginate(10);
        
        return view('admin.setting.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.setting.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
        ]);

        DB::beginTransaction();

        try {

        $defaultPassword = 'password123';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $defaultPassword,
            'must_change_password' => true,
        ]);

        DB::commit();
        return redirect()->route('admin.settings.user.index')->with('success', 'Pengguna berhasil dibuat. Password default: ' . $defaultPassword);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan pengguna', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengguna');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.setting.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,user',
        ]);

        DB::beginTransaction();

        try {

            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'role'  => $validated['role'],
            ]);

            DB::commit();
            return redirect()->route('admin.settings.user.index')->with('success', 'User berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui pengguna', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengguna');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()
                ->route('admin.settings.user.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        DB::beginTransaction();

        try {

            $user->delete();

            DB::commit();
            return redirect()->route('admin.settings.user.index')->with('success', 'Pengguna berhasil dihapus.');
       
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus pengguna', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus pengguna');
        }
    }
}
