<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\ForcePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/organization-structure', [PublicController::class, 'organization_structure'])->name('structure');
    Route::get('/history', [PublicController::class, 'history'])->name('history');
});

Route::prefix('article')->name('article.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('show');
});

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

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

    Route::prefix('article')->group(function () {
        Route::get('/', [AdminArticleController::class, 'index'])->name('article.index');
        Route::get('/create', [AdminArticleController::class, 'create'])->name('article.create');
        Route::post('/', [AdminArticleController::class, 'store'])->name('article.store');
        Route::get('/{id}/edit', [AdminArticleController::class, 'edit'])->name('article.edit');
        Route::put('/{id}', [AdminArticleController::class, 'update'])->name('article.update');
        Route::delete('/{id}', [AdminArticleController::class, 'destroy'])->name('article.destroy');
    });

    Route::prefix('news')->group(function () {
        Route::get('/', [AdminNewsController::class, 'index'])->name('news.index');
        Route::get('/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::post('/', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('/{id}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('/{id}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::delete('/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
    });

    Route::middleware(['role:admin'])->group(function () {
        
        Route::prefix('banner')->group( function(){
            Route::get('/', [AdminBannerController::class, 'index'])->name('banner.index');
            Route::get('/create', [AdminBannerController::class, 'create'])->name('banner.create');
            Route::post('/', [AdminBannerController::class, 'store'])->name('banner.store');
            Route::get('/{id}/edit', [AdminBannerController::class, 'edit'])->name('banner.edit');
            Route::put('/{id}', [AdminBannerController::class, 'update'])->name('banner.update');
            Route::delete('{id}', [AdminBannerController::class, 'destroy'])->name('banner.destroy');
        });

        Route::prefix('settings')
        ->name('settings.')
        ->group(function (){
            Route::prefix('category')->group(function (){
                Route::get('/', [AdminCategoryController::class, 'index'])->name('category.index');
                Route::get('/create', [AdminCategoryController::class, 'create'])->name('category.create');
                Route::post('/', [AdminCategoryController::class, 'store'])->name('category.store');
                Route::get('/{id}/edit', [AdminCategoryController::class, 'edit'])->name('category.edit');
                Route::put('/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
                Route::delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');
            });

            Route::prefix('organization')->group(function (){
                Route::get('/', [AdminOrganizationController::class, 'index'])->name('organization.index');
                Route::get('/create', [AdminOrganizationController::class, 'create'])->name('organization.create');
                Route::post('/', [AdminOrganizationController::class, 'store'])->name('organization.store');
                Route::get('/{organization}/edit', [AdminOrganizationController::class, 'edit'])->name('organization.edit');
                Route::put('/{organization}', [AdminOrganizationController::class, 'update'])->name('organization.update');
            });

            Route::prefix('user')->group(function (){
                Route::get('/', [AdminUserController::class, 'index'])->name('user.index');
                Route::get('/create', [AdminUserController::class, 'create'])->name('user.create');
                Route::post('/', [AdminUserController::class, 'store'])->name('user.store');
                Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('user.edit');
                Route::put('/{id}', [AdminUserController::class, 'update'])->name('user.update');
                Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');
            });
        });
    });

});

require __DIR__ . '/auth.php';
