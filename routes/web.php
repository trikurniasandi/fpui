<?php

use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\AdminInstagramController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminPhotoController;
use App\Http\Controllers\Admin\AdminPublicationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\ForcePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\DocumentController;
use App\Http\Controllers\Public\InstagramController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PhotoController;
use App\Http\Controllers\Public\PublicationController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Halaman publik, autentikasi, dan dashboard admin.
|
*/

Route::get('/', [PublicController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Halaman statis (config/public_pages.php)
|--------------------------------------------------------------------------
*/
foreach (config('public_pages') as $key => $page) {
    Route::get($page['path'], [PageController::class, 'show'])
        ->defaults('page', $key)
        ->name($key);
}

Route::get('organisasi/departemen/{departemen}', [PageController::class, 'department'])
    ->name('organisasi.departemen.show');

/*
|--------------------------------------------------------------------------
| Publikasi (config/publications.php)
|--------------------------------------------------------------------------
*/
foreach (config('publications') as $type => $meta) {
    Route::prefix($meta['public_path'])
        ->name($meta['route_name'] . '.')
        ->group(function () use ($type, $meta) {
            Route::get('/', [PublicationController::class, 'index'])
                ->defaults('type', $type)
                ->name('index');

            if ($meta['has_detail']) {
                Route::get('/{slug}', [PublicationController::class, 'show'])
                    ->defaults('type', $type)
                    ->name('show');
            }
        });
}

Route::get('publikasi/galeri-foto', [PhotoController::class, 'index'])->name('photo.index');

/*
|--------------------------------------------------------------------------
| Informasi / dokumen (config/documents.php)
|--------------------------------------------------------------------------
*/
foreach (config('documents') as $type => $meta) {
    Route::get($meta['path'], [DocumentController::class, 'index'])
        ->defaults('type', $type)
        ->name($meta['route_name']);
}

Route::get('/instagram/feed', [InstagramController::class, 'feed'])
    ->middleware('throttle:60,1')
    ->name('instagram.feed');

Route::get('/instagram/feed/{instagram}', [InstagramController::class, 'feedAccount'])
    ->middleware('throttle:60,1')
    ->name('instagram.feed.account');

/*
|--------------------------------------------------------------------------
| Redirect URL lama (301)
|--------------------------------------------------------------------------
*/
Route::redirect('/about', '/tentang/profil', 301);
Route::redirect('/organisasi/sekretariat', '/kontak/sekretariat', 301);
Route::redirect('/profile/history', '/tentang/sejarah', 301);
Route::redirect('/profile/organization-structure', '/tentang/struktur-organisasi', 301);
Route::redirect('/program', '/program/program-kerja', 301);
Route::redirect('/article', '/publikasi/artikel', 301);
Route::redirect('/news', '/publikasi/berita', 301);

Route::get('/article/{slug}', fn (string $slug) => redirect()->route('article.show', ['slug' => $slug], 301));
Route::get('/news/{slug}', fn (string $slug) => redirect()->route('news.show', ['slug' => $slug], 301));

Route::middleware('auth')->group(function () {

    Route::get('/force-change-password', [ForcePasswordController::class, 'edit'])
        ->name('password.force.change');

    Route::post('/force-change-password', [ForcePasswordController::class, 'update'])
        ->name('password.force.update');
});

Route::middleware(['auth', 'verified', 'role:admin,user', 'force.password'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        /*
        |------------------------------------------------------------------
        | Publikasi (semua tipe memakai AdminPublicationController)
        |------------------------------------------------------------------
        */
        foreach (config('publications') as $type => $meta) {
            $routeBase = Str::after($meta['admin_route'], 'admin.');

            Route::prefix($meta['admin_path'])->group(function () use ($type, $routeBase) {
                Route::get('/', [AdminPublicationController::class, 'index'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.index');

                Route::get('/create', [AdminPublicationController::class, 'create'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.create');

                Route::post('/', [AdminPublicationController::class, 'store'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.store');

                Route::get('/{id}/edit', [AdminPublicationController::class, 'edit'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.edit');

                Route::put('/{id}', [AdminPublicationController::class, 'update'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.update');

                Route::delete('/{id}', [AdminPublicationController::class, 'destroy'])
                    ->defaults('type', $type)
                    ->name($routeBase . '.destroy');
            });
        }

        Route::middleware(['role:admin'])->group(function () {

            Route::prefix('banner')->group(function () {
                Route::get('/', [AdminBannerController::class, 'index'])->name('banner.index');
                Route::get('/create', [AdminBannerController::class, 'create'])->name('banner.create');
                Route::post('/', [AdminBannerController::class, 'store'])->name('banner.store');
                Route::get('/{id}/edit', [AdminBannerController::class, 'edit'])->name('banner.edit');
                Route::put('/{id}', [AdminBannerController::class, 'update'])->name('banner.update');
                Route::delete('{id}', [AdminBannerController::class, 'destroy'])->name('banner.destroy');
            });

            Route::resource('document', AdminDocumentController::class)->except(['show']);
            Route::resource('photo', AdminPhotoController::class)->except(['show']);

            Route::prefix('settings')
                ->name('settings.')
                ->group(function () {
                    Route::prefix('category')->group(function () {
                        Route::get('/', [AdminCategoryController::class, 'index'])->name('category.index');
                        Route::get('/create', [AdminCategoryController::class, 'create'])->name('category.create');
                        Route::post('/', [AdminCategoryController::class, 'store'])->name('category.store');
                        Route::get('/{id}/edit', [AdminCategoryController::class, 'edit'])->name('category.edit');
                        Route::put('/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
                        Route::delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');
                    });

                    Route::prefix('organization')->group(function () {
                        Route::get('/', [AdminOrganizationController::class, 'index'])->name('organization.index');
                        Route::get('/create', [AdminOrganizationController::class, 'create'])->name('organization.create');
                        Route::post('/', [AdminOrganizationController::class, 'store'])->name('organization.store');
                        Route::get('/{organization}/edit', [AdminOrganizationController::class, 'edit'])->name('organization.edit');
                        Route::put('/{organization}', [AdminOrganizationController::class, 'update'])->name('organization.update');
                    });

                    Route::prefix('user')->group(function () {
                        Route::get('/', [AdminUserController::class, 'index'])->name('user.index');
                        Route::get('/create', [AdminUserController::class, 'create'])->name('user.create');
                        Route::post('/', [AdminUserController::class, 'store'])->name('user.store');
                        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('user.edit');
                        Route::put('/{id}', [AdminUserController::class, 'update'])->name('user.update');
                        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');
                    });

                    Route::prefix('instagram')->name('instagram.')->group(function () {
                        Route::get('/', [AdminInstagramController::class, 'index'])->name('index');
                        Route::get('/create', [AdminInstagramController::class, 'create'])->name('create');
                        Route::post('/', [AdminInstagramController::class, 'store'])->name('store');
                        Route::get('/{instagram}/edit', [AdminInstagramController::class, 'edit'])->name('edit');
                        Route::put('/{instagram}', [AdminInstagramController::class, 'update'])->name('update');
                        Route::delete('/{instagram}', [AdminInstagramController::class, 'destroy'])->name('destroy');
                        Route::post('/{instagram}/test', [AdminInstagramController::class, 'test'])->name('test');
                        Route::post('/{instagram}/refresh', [AdminInstagramController::class, 'refresh'])->name('refresh');
                        Route::post('/{instagram}/clear-cache', [AdminInstagramController::class, 'clearCache'])->name('clear-cache');
                    });
                });
        });

    });

require __DIR__.'/auth.php';
