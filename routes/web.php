<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\{
    BuyerDashboardController,
    BuyerProductController,
    BuyerCartController,
    BuyerCheckoutController,
    BuyerOrderController,
    BuyerProfileController,
    BuyerStoreController
};
use App\Http\Controllers\Seller\{
    SellerDashboardController,
    SellerProductController,
    SellerOrderController,
    SellerBalanceController,
    SellerWithdrawController
};
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminStoreApprovalController,
    AdminUserController,
    AdminProductController
};

// ============================================
// ROOT REDIRECT
// ============================================
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// ============================================
// DASHBOARD - WAJIB LOGIN
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();

        if ($store) {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('buyer.dashboard');
    })->name('dashboard');

    // ===========================================
    // BUYER ROUTES
    // ===========================================
Route::middleware(['role:member'])->prefix('buyer')->name('buyer.')->group(function () {

    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

    // HOME
    Route::get('/home', function () {
        return redirect()->route('buyer.dashboard');
    })->name('home');

    // Products
    Route::get('/products', [BuyerProductController::class, 'index'])->name('products');
    Route::get('/product/{id}', [BuyerProductController::class, 'show'])->name('product.show');

    // Cart
    Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart');

    // Profile
    Route::get('/profile', [BuyerProfileController::class, 'edit'])->name('profile');
    Route::post('/profile/update', [BuyerProfileController::class, 'update'])->name('profile.update');

    // Checkout
    Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [BuyerCheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [BuyerOrderController::class, 'show'])->name('order.show');

    // Transactions
    Route::get('/transactions', [BuyerOrderController::class, 'index'])->name('transactions');

    // Apply Store
    Route::get('/apply-store', [BuyerStoreController::class, 'create'])->name('store.apply');
    Route::post('/apply-store', [BuyerStoreController::class, 'store'])->name('store.submit');
    Route::get('/store-status', [BuyerStoreController::class, 'status'])->name('store.status');

});


    // ===========================================
    // SELLER ROUTES
    // ===========================================
    Route::middleware(['role:seller'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', SellerProductController::class);
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    });

    // ===========================================
    // ADMIN ROUTES
    // ===========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/stores', [AdminStoreApprovalController::class, 'index'])->name('stores.index');
        Route::get('/stores/{id}', [AdminStoreApprovalController::class, 'show'])->name('stores.show');
        Route::post('/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve'])->name('stores.approve');
        Route::post('/stores/{id}/reject', [AdminStoreApprovalController::class, 'reject'])->name('stores.reject');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    });

});

// Auth routes
require __DIR__ . '/auth.php';
