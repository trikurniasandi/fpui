<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;

class PageController extends Controller
{
    /**
     * Menampilkan halaman statis yang terdaftar pada config/public_pages.php.
     */
    public function show(string $page)
    {
        $pages = config('public_pages', []);

        abort_unless(array_key_exists($page, $pages), 404);

        $pageConfig = $pages[$page];
        $contentKey = $pageConfig['content'] ?? null;

        return view($pageConfig['view'] ?? 'public.pages.generic', [
            'pageConfig' => $pageConfig,
            'content' => $contentKey ? config('public_content.' . $contentKey, []) : [],
            'organization' => OrganizationProfile::first(),
        ]);
    }

    /**
     * Detail departemen, datanya diambil dari config/public_content.php.
     */
    public function department(string $departemen)
    {
        $departments = config('public_content.departemen_items', []);

        abort_unless(array_key_exists($departemen, $departments), 404);

        $department = $departments[$departemen];

        return view('public.pages.departemen-show', [
            'departemen' => $departemen,
            'department' => $department,
            'departments' => $departments,
        ]);
    }
}
