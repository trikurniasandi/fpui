<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminOrganizationController;
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

Route::prefix('article')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('article.show');
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('news.show');
});

Route::middleware(['auth', 'verified', 'admin'])
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
            Route::get('/{id}/edit', [AdminOrganizationController::class, 'edit'])->name('organization.edit');
            Route::put('/{id}', [AdminOrganizationController::class, 'update'])->name('organization.update');
            Route::delete('/{id}', [AdminOrganizationController::class, 'destroy'])->name('organization.destroy');
        });
    });

});


require __DIR__ . '/auth.php';
