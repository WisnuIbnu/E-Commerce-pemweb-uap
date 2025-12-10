<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// E-Commerce Customer
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\CartController;

// Seller
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductSellerController;
use App\Http\Controllers\Seller\CategorySellerController;
use App\Http\Controllers\Seller\OrderSellerController;
use App\Http\Controllers\Seller\BalanceController;

// Admin
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================
// PUBLIC PRODUCT ROUTES
// =============================
// Keep both names so blades that use either 'products' or 'products.index' won't break.
// NOTE: this duplicates the route URI but provides both route names (minimal change).
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/category/{id}', [ProductController::class, 'category'])->name('product.category');

// =============================
// CART
// =============================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// =============================
// CUSTOMER
// =============================
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.history');
    Route::get('/transactions/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
});

// =============================
// SELLER
// =============================
Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {

    // IMPORTANT: remove any manual /seller/products route that could conflict with resource.
    // Use resource routes below (they create seller.products.index, seller.products.create, etc.)
    // If any blade expects a different seller route name, adjust the blade to use seller.products.index.
    // (I left a harmless alias route at /seller/products-list to avoid changing too much if needed.)
    Route::get('/products-list', [ProductSellerController::class, 'index'])->name('seller.products.alias');

    Route::get('/store', [StoreController::class, 'index'])->name('seller.store');
    Route::post('/store', [StoreController::class, 'store'])->name('seller.store.create');
    Route::put('/store/{id}', [StoreController::class, 'update'])->name('seller.store.update');
    Route::delete('/store/{id}', [StoreController::class, 'destroy'])->name('seller.store.delete');

    // Resource product seller — keeps names like seller.products.index etc.
    Route::resource('/products', ProductSellerController::class, [
        'as' => 'seller'
    ]);

    // Resource category seller
    Route::resource('/categories', CategorySellerController::class);

    Route::get('/orders', [OrderSellerController::class, 'index'])->name('seller.orders');
    Route::put('/orders/{id}', [OrderSellerController::class, 'update'])->name('seller.orders.update');

    Route::get('/balance', [BalanceController::class, 'index'])->name('seller.balance');
    Route::post('/withdraw', [BalanceController::class, 'withdraw'])->name('seller.withdraw');
});

// =============================
// ADMIN
// =============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/stores', [StoreVerificationController::class, 'index'])->name('admin.stores');
    Route::put('/stores/{id}/verify', [StoreVerificationController::class, 'verify'])->name('admin.stores.verify');
    Route::put('/stores/{id}/reject', [StoreVerificationController::class, 'reject'])->name('admin.stores.reject');

    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.delete');
});

require __DIR__.'/auth.php';
