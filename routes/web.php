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

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// PUBLIC ROUTES
Route::get('/products', [ProductController::class, 'index'])->name('products'); // All products
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show'); // Product detail
Route::get('/category/{id}', [ProductController::class, 'category'])->name('product.category'); // Products by category

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// CUSTOMER ROUTES
Route::middleware(['auth', 'role:customer'])->group(function () {

    // Checkout page
    Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{id}', [CheckoutController::class, 'process'])->name('checkout.process');

    // Transaction history
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.history');
    Route::get('/transactions/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
});

// SELLER ROUTES
Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {

    // Store management
    Route::get('/store', [StoreController::class, 'index'])->name('seller.store');
    Route::post('/store', [StoreController::class, 'store'])->name('seller.store.create');
    Route::put('/store/{id}', [StoreController::class, 'update'])->name('seller.store.update');
    Route::delete('/store/{id}', [StoreController::class, 'destroy'])->name('seller.store.delete');

    // Product CRUD
    Route::resource('/products', ProductSellerController::class);

    // Category CRUD
    Route::resource('/categories', CategorySellerController::class);

    // Orders
    Route::get('/orders', [OrderSellerController::class, 'index'])->name('seller.orders');
    Route::put('/orders/{id}', [OrderSellerController::class, 'update'])->name('seller.orders.update');

    // Balance + Withdraw
    Route::get('/balance', [BalanceController::class, 'index'])->name('seller.balance');
    Route::post('/withdraw', [BalanceController::class, 'withdraw'])->name('seller.withdraw');
});

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Store verification
    Route::get('/stores', [StoreVerificationController::class, 'index'])->name('admin.stores');
    Route::put('/stores/{id}/verify', [StoreVerificationController::class, 'verify'])->name('admin.stores.verify');
    Route::put('/stores/{id}/reject', [StoreVerificationController::class, 'reject'])->name('admin.stores.reject');

    // User & Store management
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.delete');
});

require __DIR__.'/auth.php';
