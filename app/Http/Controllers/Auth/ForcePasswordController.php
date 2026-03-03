<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForcePasswordController extends Controller
{
    public function edit()
    {
        return view('auth.force-change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = $request->password;
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Password berhasil diperbarui.');
    }
}