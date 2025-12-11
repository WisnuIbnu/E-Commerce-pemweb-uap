<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Customer\ProductReviewController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route produk customer
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Route store customer
Route::get('/store/{id}', [StoreController::class, 'show'])->name('store.show');

// Product Reviews Routes
Route::get('/product/{product}/reviews', [ProductReviewController::class, 'index'])
    ->name('product.reviews.index');

Route::post('/product/{product}/reviews', [ProductReviewController::class, 'store'])
    ->middleware('auth')
    ->name('product.reviews.store');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Admin Routes - Gunakan middleware 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    
    // Users Management
    Route::get('/users', [UserController::class, 'index'])
        ->name('users');
    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])
        ->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('users.destroy');
    
    // Stores Management
    Route::get('/stores', [AdminStoreController::class, 'index'])
        ->name('stores');
    Route::get('/stores/create', [AdminStoreController::class, 'create'])
        ->name('stores.create');
    Route::post('/stores', [AdminStoreController::class, 'store'])
        ->name('stores.store');
    Route::get('/stores/{id}/edit', [AdminStoreController::class, 'edit'])
        ->name('stores.edit');
    Route::put('/stores/{id}', [AdminStoreController::class, 'update'])
        ->name('stores.update');
    Route::delete('/stores/{id}', [AdminStoreController::class, 'destroy'])
        ->name('stores.destroy');
    Route::post('/stores/{id}/toggle-verification', [AdminStoreController::class, 'toggleVerification'])
        ->name('stores.toggle-verification');
    
    // Store Verification
    Route::get('/stores/verification', [StoreVerificationController::class, 'index'])
        ->name('stores.verification');
    Route::post('/stores/{id}/approve', [StoreVerificationController::class, 'approve'])
        ->name('stores.approve');
    Route::post('/stores/{id}/reject', [StoreVerificationController::class, 'reject'])
        ->name('stores.reject');
    Route::get('/stores/{id}/show', [StoreVerificationController::class, 'show'])
        ->name('stores.show');
});

require __DIR__.'/auth.php';