<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\CheckoutController; 
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SellerMiddleware;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerWithdrawController; // <--- Pastikan ini ada

// Halaman Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Detail Produk
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.detail');

// Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('front.checkout');
    Route::post('/checkout/{slug}', [CheckoutController::class, 'store'])->name('front.checkout.store');

    // Keranjang Belanja
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts/{slug}', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{code}', [TransactionController::class, 'show'])->name('transactions.details');

    // Pembayaran
    Route::get('/payment/{code}', [PaymentController::class, 'index'])->name('front.payment');
    Route::post('/payment/{code}', [PaymentController::class, 'update'])->name('front.payment.update');

    // Buka Toko
    Route::get('/open-store', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/open-store', [StoreController::class, 'store'])->name('stores.store');

    // --- GROUP ROUTE KHUSUS SELLER ---
    // --- GROUP ROUTE KHUSUS SELLER ---
    Route::middleware([SellerMiddleware::class]) 
        ->prefix('seller')
        ->name('seller.')
        ->group(function () {

            // 1. Resource Produk (INI YANG BENAR)
            Route::resource('products', App\Http\Controllers\Seller\SellerProductController::class);

            // 2. Route Pesanan
            Route::get('/orders', [App\Http\Controllers\Seller\SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{id}', [App\Http\Controllers\Seller\SellerOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{id}', [App\Http\Controllers\Seller\SellerOrderController::class, 'update'])->name('orders.update');
        
            // 3. HAPUS BAGIAN INI (KARENA MENIMPA ROUTE PRODUK DI ATAS)
            // Route::get('/products', function() { return "Halaman Produk (Segera Hadir)"; })->name('products.index'); <--- HAPUS INI

            // Halaman Edit Toko
            Route::get('/store-settings', [App\Http\Controllers\Seller\SellerStoreController::class, 'edit'])->name('store.edit');
        
            // Proses Update Toko
            Route::put('/store-settings', [App\Http\Controllers\Seller\SellerStoreController::class, 'update'])->name('store.update');
        
            // Proses Hapus Toko
            Route::delete('/store-settings', [App\Http\Controllers\Seller\SellerStoreController::class, 'destroy'])->name('store.destroy');
            
            // Route Placeholder Lainnya (Boleh disimpan atau dihapus jika fitur sudah dibuat)
            Route::get('/balance', function() { return "Halaman Saldo (Segera Hadir)"; })->name('balance.index');
            // Halaman Utama Penarikan & Riwayat
            Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
            
            // Proses Ajukan Penarikan (Tarik Dana)
            Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
            
            // Proses Update Info Rekening Bank
            Route::put('/withdraw/bank', [SellerWithdrawController::class, 'updateBank'])->name('withdraw.updateBank');
    });
});

require __DIR__.'/auth.php';