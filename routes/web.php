<?php

use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawalController;
use App\Http\Controllers\Seller\SellerStoreController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});
 
// ================= USER SIDE (WAJIB LOGIN) =================

Route::middleware('auth')->group(function () {
    // Home / Dashboard
    Route::get('/home', function () {
        return view('user.home.dashboard');
    })->name('home');

    Route::get('/dashboard', function () {
        return view('user.home.dashboard');
    })->name('dashboard');

    // ✅ Katalog produk
    Route::get('/products', [UserProductController::class, 'index'])
        ->name('products');

    // ✅ History transaksi
    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history');

    // Profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daftar jadi seller
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])
        ->name('profile.becomeSeller');
});

require __DIR__.'/auth.php';

// ================= SELLER SIDE =================
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        // Dashboard Seller
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Produk
        Route::resource('/products', SellerProductController::class);

        // Pesanan Masuk (Untuk melihat pesanan yang diterima oleh seller)
        Route::resource('/orders', SellerOrderController::class);

        // Saldo Toko (Untuk melihat saldo toko dan history saldo)
        Route::resource('/balance', SellerBalanceController::class);

        // Penarikan Dana (Untuk meminta penarikan dana oleh seller)
        Route::resource('/withdrawals', SellerWithdrawalController::class);

        // Profil Toko (Untuk mengedit dan melihat profil toko)
        Route::get('/store', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store', [SellerStoreController::class, 'update'])->name('store.update');

        // Kategori Produk
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    });
