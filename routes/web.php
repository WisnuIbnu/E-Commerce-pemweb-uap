<?php

use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
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

    // ✅ Katalog produk (ini bikin route('products') jadi ada)
    Route::get('/products', [UserProductController::class, 'index'])
        ->name('products');

    // ✅ History transaksi (ini bikin route('history') jadi ada)
    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history');

    // // PROFILE (Breeze)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ tombol "Daftar jadi seller"
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])
        ->name('profile.becomeSeller');

     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])->name('profile.becomeSeller');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ================= AUTH PAGES CUSTOM VIEW =================

// Paksa GET /login dan /register pakai view figma-auth
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.figma-auth');
    })->name('login');

    Route::get('/register', function () {  
        return view('auth.figma-auth');
    })->name('register');
});


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
    });