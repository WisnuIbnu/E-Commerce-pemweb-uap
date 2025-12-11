<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\TransactionController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
| Semua route customer (role:user). 
| Akses: Setelah login dengan role user.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard User
    Route::get('/user/dashboard', [HomeController::class, 'index'])
        ->name('user.dashboard');

    // Homepage (list semua produk + kategori)
    Route::get('/products', [ProductController::class, 'index'])
        ->name('user.products');

    // Detail produk
    Route::get('/products/{slug}', [ProductController::class, 'show'])
        ->name('user.product.detail');

    // Checkout
    Route::get('/checkout/{product_id}', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/process', [CheckoutController::class, 'store'])
        ->name('checkout.process');

    // Riwayat Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transaction.history');

    Route::get('/transactions/{id}', [TransactionController::class, 'show'])
        ->name('transaction.detail');
});
