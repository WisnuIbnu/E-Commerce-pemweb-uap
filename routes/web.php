<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\CheckoutController; 
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Front\PaymentController;

// halaman beranda (daftar produk)
Route::get('/', [HomeController::class, 'index'])->name('home');

// halaman detail produk (berdasarkan slug)
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.detail');

// authentication dari Laravel Breeze
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // review produk
    Route::post('/product/review/{slug}', [ProductReviewController::class, 'store'])->name('product.review.store');

    // checkout
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('front.checkout');
    Route::post('/checkout/{slug}', [CheckoutController::class, 'store'])->name('front.checkout.store');

    // keranjang belanja
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts/{slug}', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // ROUTE RIWAYAT TRANSAKSI
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{code}', [TransactionController::class, 'show'])->name('transactions.details');

    // Route Pembayaran
    Route::get('/payment/{code}', [PaymentController::class, 'index'])->name('front.payment');
    Route::post('/payment/{code}', [PaymentController::class, 'update'])->name('front.payment.update');
});

require __DIR__.'/auth.php';