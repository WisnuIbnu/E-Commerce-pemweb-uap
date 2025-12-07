<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Seller\SellerController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES (guest & semua user)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// DASHBOARD BUYER
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->middleware('role:buyer, seller')
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CART
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
});

// ROUTES ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('users', AdminUserController::class);

        // Tambahan untuk STORE (verifikasi / reject)
        Route::post('/stores/{store}/verify', [AdminStoreController::class, 'verify'])
            ->name('stores.verify');

        Route::post('/stores/{store}/reject', [AdminStoreController::class, 'reject'])
            ->name('stores.reject');

        // CRUD utama store
        Route::resource('stores', AdminStoreController::class);

        Route::resource('transactions', AdminTransactionController::class)->only(['index','show']);
        Route::resource('withdrawals', AdminWithdrawalController::class)->only(['index','show','update']);
});

// ROUTES SELLER
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/form', [SellerController::class, 'create'])->name('form');
        Route::post('/form', [SellerController::class, 'store'])->name('store');
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    });

require __DIR__.'/auth.php';
