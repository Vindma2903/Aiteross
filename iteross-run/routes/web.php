<?php

use App\Modules\Admin\Http\Controllers\AdminCatalogController;
use App\Modules\Admin\Http\Controllers\AdminDashboardController;
use App\Modules\Admin\Http\Controllers\AdminPageController;
use App\Modules\Admin\Http\Controllers\AdminProductController;
use App\Modules\Catalog\Http\Controllers\CatalogController;
use App\Modules\Catalog\Http\Controllers\HomeController;
use App\Modules\Favorites\Http\Controllers\FavoriteController;
use App\Modules\Identity\Http\Controllers\AccountController;
use App\Modules\Identity\Http\Controllers\AdminLoginController;
use App\Modules\Identity\Http\Controllers\LoginController;
use App\Modules\Identity\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);
Route::get('/catalog/{categorySlug?}', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/account', AccountController::class)->name('account');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/pages/{page}', [AdminPageController::class, 'editor'])->name('admin.pages.editor');
    Route::post('/admin/pages/{page}', [AdminPageController::class, 'update'])
        ->where('page', 'home')
        ->name('admin.pages.update');
    Route::post('/admin/catalog/categories', [AdminCatalogController::class, 'updateCategories'])->name('admin.catalog.categories.update');
    Route::post('/admin/catalog/filters', [AdminCatalogController::class, 'updateFilters'])->name('admin.catalog.filters.update');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/legacy-products', [AdminPageController::class, 'legacyProducts'])->name('admin.legacy.products');
    Route::get('/admin/static-preview/{page}', [AdminPageController::class, 'preview'])->name('admin.static.preview');
    Route::get('/admin/legacy-editor/{page}', [AdminPageController::class, 'legacyEditor'])->name('admin.legacy.editor');
    Route::get('/admin/static-resource/{path}', [AdminPageController::class, 'resource'])
        ->where('path', '.*')
        ->name('admin.static.resource');
});
