<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\InfografisManagementController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\TutorialManagementController;
use Illuminate\Support\Facades\Route;

// ================================
// Halaman Publik
// ================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/umkm/{slug}', [HomeController::class, 'showUmkm'])->name('public.umkm.show');
Route::get('/infografis', [InfografisController::class, 'index'])->name('public.infografis.index');
Route::get('/tutorials', [TutorialController::class, 'index'])->name('public.tutorials.index');
Route::get('/tutorials/{tutorial}', [TutorialController::class, 'show'])->name('public.tutorials.show');

// ================================
// Authenticated Routes
// ================================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================================
    // Routes Butuh Persetujuan Admin
    // ================================
    Route::middleware('active')->group(function () {
        // Manajemen UMKM
        Route::resource('manage/umkm', UmkmController::class)->names('umkm');
        Route::post('manage/umkm/{umkm}/photos', [UmkmController::class, 'uploadPhotos'])->name('umkm.photos.store');
        Route::delete('manage/umkm/{umkm}/photos/{photo}', [UmkmController::class, 'deletePhoto'])->name('umkm.photos.destroy');

        // Manajemen Produk (nested under UMKM)
        Route::get('manage/umkm/{umkm}/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('manage/umkm/{umkm}/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('manage/umkm/{umkm}/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('manage/umkm/{umkm}/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('manage/umkm/{umkm}/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('manage/umkm/{umkm}/products/{product}/toggle-star', [ProductController::class, 'toggleStar'])->name('products.toggle-star');

        // Kategori API (AJAX)
        Route::get('/api/categories', [CategoryController::class, 'index']);
        Route::post('/api/categories', [CategoryController::class, 'store']);
    });

    // ================================
    // Admin Only
    // ================================
    Route::middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::patch('manage/users/{user}/toggle-active', [UserManagementController::class, 'toggleActive'])->name('users.toggle-active');
        Route::resource('manage/users', UserManagementController::class)->names('users');
        Route::resource('manage/infografis', InfografisManagementController::class)->names('manage.infografis');
        Route::post('manage/tutorials/upload-image', [TutorialManagementController::class, 'uploadImage'])->name('manage.tutorials.upload-image');
        Route::resource('manage/tutorials', TutorialManagementController::class)->names('manage.tutorials');
    });
});

require __DIR__.'/auth.php';
