<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminOrganizationController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first();

        return view('admin.setting.organization.index', compact('profile'));
    }

    public function create()
    {
        if (OrganizationProfile::exists()) {
            return redirect()
                ->route('admin.settings.organization.index')
                ->with('error', 'Profil organisasi sudah ada');
        }

        return view('admin.setting.organization.create');
    }

    public function store(Request $request)
    {
        if (OrganizationProfile::exists()) {
            return redirect()
                ->route('admin.settings.organization.index')
                ->with('error', 'Profil organisasi sudah ada');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'instagram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
        ]);

        DB::beginTransaction();

        try {

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')
                    ->store('organization', 'public');
            }

            OrganizationProfile::create($validated);

            DB::commit();
            return redirect()->route('admin.settings.organization.index')->with('success', 'Profil organisasi berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambah profil organisasi', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan profil organisasi');
        }
    }

    public function edit(OrganizationProfile $organization)
    {
        return view('admin.setting.organization.edit', [
            'profile' => $organization
        ]);
    }

    public function update(Request $request, OrganizationProfile $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'instagram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('logo')) {
                if ($organization->logo && Storage::disk('public')->exists($organization->logo)) {
                    Storage::disk('public')->delete($organization->logo);
                }

                $validated['logo'] = $request->file('logo')->store('organization', 'public');
            }

            $organization->update($validated);
            DB::commit();

            return redirect()->route('admin.settings.organization.index')
                ->with('success', 'Profil organisasi berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui profil organisasi', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui profil organisasi');
        }
    }

}