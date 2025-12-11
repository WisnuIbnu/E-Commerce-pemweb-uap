<?php

use Illuminate\Support\Facades\Route;

// FRONT CONTROLLERS
use App\Http\Controllers\Front\HomeController; 
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\CheckoutController; 
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductReviewController;

// SELLER CONTROLLERS
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Seller\SellerWithdrawController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\StoreAdminController;
use App\Http\Controllers\Admin\AdminUserStoreController;


// MIDDLEWARES
use App\Http\Middleware\SellerMiddleware;

// =========================
//        PUBLIC ROUTES
// =========================

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail produk
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.detail');


// =========================
//       AUTH ROUTES
// =========================

Route::middleware('auth')->group(function () {

    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Review produk
    Route::post('/product/{slug}/review', [ProductReviewController::class, 'store'])
        ->name('product.review.store');

    // Checkout
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])
        ->name('front.checkout');
    Route::post('/checkout/{slug}', [CheckoutController::class, 'store'])
        ->name('front.checkout.store');

    // Keranjang
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts/{slug}', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{code}', [TransactionController::class, 'show'])->name('transactions.details');

    // Pembayaran
    Route::get('/payment/{code}', [PaymentController::class, 'index'])->name('front.payment');
    Route::post('/payment/{code}', [PaymentController::class, 'update'])->name('front.payment.update');

    // Buka toko (buyer)
    Route::get('/open-store', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/open-store', [StoreController::class, 'store'])->name('stores.store');


    // =========================
    //      SELLER ROUTES
    // =========================

    Route::middleware([SellerMiddleware::class])
        ->prefix('seller')
        ->name('seller.')
        ->group(function () {

            // Produk
            Route::resource('products', SellerProductController::class);

            // Pesanan
            Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{id}', [SellerOrderController::class, 'update'])->name('orders.update');

            // Pengaturan toko
            Route::get('/store-settings', [SellerStoreController::class, 'edit'])->name('store.edit');
            Route::put('/store-settings', [SellerStoreController::class, 'update'])->name('store.update');
            Route::delete('/store-settings', [SellerStoreController::class, 'destroy'])->name('store.destroy');

            // Saldo & Penarikan
            Route::get('/balance', function () { return "Halaman Saldo (Segera Hadir)"; })
                ->name('balance.index');

            Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
            Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
            Route::put('/withdraw/bank', [SellerWithdrawController::class, 'updateBank'])->name('withdraw.updateBank');
        });
});


// =========================
//       ADMIN ROUTES
// =========================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Verifikasi Toko
        Route::get('/store-verification', [StoreAdminController::class, 'index'])
            ->name('store.verification');

        Route::post('/store-verification/{id}/approve', [StoreAdminController::class, 'approve'])
            ->name('store.verify');

        Route::post('/store-verification/{id}/reject', [StoreAdminController::class, 'reject'])
            ->name('store.reject');

        // Manajemen User & Toko
        Route::get('/user-store-management', [AdminUserStoreController::class, 'index'])
            ->name('management');

        Route::get('/user-management/{id}/edit', [AdminUserStoreController::class, 'edit'])
            ->name('user.edit');

        // Route baru untuk update user
        Route::put('/user-management/{id}', [AdminUserStoreController::class, 'update'])
            ->name('user.update');
    });



// AUTH ROUTES (Laravel Breeze)
require __DIR__ . '/auth.php';
