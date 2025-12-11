<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// CUSTOMER
use App\Http\Controllers\Customer\ProductCustomerController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\CartController;

// SELLER
use App\Http\Controllers\Sellers\StoreController;
use App\Http\Controllers\Sellers\ProductSellerController;
use App\Http\Controllers\Sellers\CategorySellerController;
use App\Http\Controllers\Sellers\OrderSellerController;
use App\Http\Controllers\Sellers\BalanceController;
use App\Http\Controllers\Sellers\WithdrawalController;

// ADMIN
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


// CUSTOMER PUBLIC PRODUCT ROUTES
Route::get('/products', [ProductCustomerController::class, 'index'])
    ->name('customer.products.index');

// Alias agar route('products') tidak error
Route::get('/products', [ProductCustomerController::class, 'index'])
    ->name('products');

Route::get('/products/{slug}', [ProductCustomerController::class, 'show'])
    ->name('customer.products.show');

Route::get('/products/category/{id}', [ProductCustomerController::class, 'category'])
    ->name('customer.products.category');

// Alias agar route('product.category') tidak error
Route::get('/products/category/{id}', [ProductCustomerController::class, 'category'])
    ->name('product.category');


// =============================
// CART
// =============================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// =============================
// CUSTOMER AUTHENTICATED
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
    // Products
    Route::resource('/products', ProductSellerController::class, ['as' => 'seller']);
    
    // Categories
    Route::resource('/categories', CategorySellerController::class);

    // Store
    Route::get('/store', [StoreController::class, 'index'])->name('seller.store');
    Route::post('/store', [StoreController::class, 'store'])->name('seller.store.create');
    Route::put('/store/{id}', [StoreController::class, 'update'])->name('seller.store.update');
    Route::delete('/store/{id}', [StoreController::class, 'destroy'])->name('seller.store.delete');

    // Orders
    Route::get('/orders', [OrderSellerController::class, 'index'])->name('seller.orders');
    Route::put('/orders/{id}', [OrderSellerController::class, 'update'])->name('seller.orders.update');

    // Balance & Withdraw
    Route::get('/balance', [BalanceController::class, 'index'])->name('seller.balance');
    Route::get('/withdraw', [WithdrawalController::class, 'index'])->name('seller.withdraw');
    Route::post('/withdraw', [WithdrawalController::class, 'requestWithdraw'])->name('seller.withdraw.request');
});

// =============================
// ADMIN
// =============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Store verification
    Route::get('/stores', [StoreVerificationController::class, 'index'])->name('admin.stores');
    Route::put('/stores/{id}/verify', [StoreVerificationController::class, 'verify'])->name('admin.stores.verify');
    Route::put('/stores/{id}/reject', [StoreVerificationController::class, 'reject'])->name('admin.stores.reject');

    // User management
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.delete');
});

require __DIR__.'/auth.php';