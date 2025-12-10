<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes (Customer Side)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/stores', [StoreController::class, 'browse'])->name('stores.index');
Route::get('/stores/{store}', [StoreController::class, 'showProducts'])->name('stores.products');

// Authenticated Customer Routes
Route::middleware(['auth'])->group(function () {
    // Checkout & Buy Now
    Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('checkout.buyNow');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // My Orders
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // Reviews
    Route::post('/reviews', [ProductReviewController::class, 'store'])->name('reviews.store');
});

// Profile Routes (still need auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Seller Routes
Route::middleware(['auth', 'role:member'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // Store Registration (seller baru)
        Route::get('/register-store', [StoreController::class, 'create'])->name('register');
        Route::post('/register-store', [StoreController::class, 'store'])->name('store');

        // Seller yang sudah punya toko & terverifikasi
        Route::middleware(['has_store'])->group(function () {

            // Seller Dashboard
            Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

            // Orders
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{id}/update-shipping', [OrderController::class, 'updateShipping'])->name('orders.updateShipping');

            // Balance & Withdrawals
            Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
            Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
            Route::post('/withdrawals', [WithdrawalController::class, 'request'])->name('withdrawals.request');
            Route::put('/withdrawals/bank-account', [WithdrawalController::class, 'updateBankAccount'])->name('withdrawals.updateBank');

            // Store Profile
            Route::get('/store', [StoreController::class, 'edit'])->name('store.edit');
            Route::put('/store', [StoreController::class, 'update'])->name('store.update');
            Route::delete('/store', [StoreController::class, 'destroy'])->name('store.destroy');

            // Product CRUD
            Route::resource('products', ProductController::class)->except(['index', 'show']);

            // Categories CRUD
            Route::resource('categories', \App\Http\Controllers\CategoryController::class);

            // Product Images
            Route::post('/products/{product}/images', [ProductController::class, 'uploadImage'])->name('products.uploadImage');
            Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
        });
    });

// Admin Routes
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Withdrawal Management
        Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals.index');
        Route::put('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
        Route::put('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');


        // Store Verification
        Route::get('/stores/pending', [AdminController::class, 'pendingStores'])->name('stores.pending');
        Route::put('/stores/{id}/verify', [AdminController::class, 'verifyStore'])->name('stores.verify');
        Route::put('/stores/{id}/reject', [AdminController::class, 'rejectStore'])->name('stores.reject');
        
        // User & Store Management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/stores', [AdminController::class, 'stores'])->name('stores.index');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::delete('/stores/{id}', [AdminController::class, 'deleteStore'])->name('stores.delete');
    });
