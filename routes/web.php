<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Buyer\BuyerHomeController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerCartController;
use App\Http\Controllers\Buyer\BuyerCheckoutController;
use App\Http\Controllers\Buyer\BuyerOrderController;
use App\Http\Controllers\Buyer\BuyerProfileController;
use App\Http\Controllers\Buyer\BuyerStoreController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreApprovalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminTransactionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ============================================
// BUYER ROUTES (PUBLIC & AUTHENTICATED)
// ============================================

// Halaman utama - Home untuk semua user (public)
Route::get('/', [BuyerHomeController::class, 'index'])->name('home');

// Produk - dapat diakses tanpa login
Route::get('/products', [BuyerProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [BuyerProductController::class, 'show'])->name('product.detail');

// Auth routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Dashboard - redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()) {
        $user = auth()->user();
        
        // Check if admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Check if seller (member with approved store)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();
        
        if ($store) {
            return redirect()->route('seller.dashboard');
        }
        
        // Default: member/buyer
        return redirect()->route('buyer.home');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================
// BUYER AUTHENTICATED ROUTES (role: member)
// ============================================

Route::middleware(['auth', 'role:member'])->prefix('buyer')->name('buyer.')->group(function () {
    // Home & Browse
    Route::get('/', [BuyerHomeController::class, 'index'])->name('home');
    
    // Cart
    Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [BuyerCartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [BuyerCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [BuyerCartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout
    Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [BuyerCheckoutController::class, 'process'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [BuyerOrderController::class, 'show'])->name('order.show');
    
    // Profile
    Route::get('/profile', [BuyerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [BuyerProfileController::class, 'update'])->name('profile.update');
    
    // Apply for Store
    Route::get('/apply-store', [BuyerStoreController::class, 'create'])->name('store.apply');
    Route::post('/apply-store', [BuyerStoreController::class, 'store'])->name('store.submit');
    Route::get('/store-status', [BuyerStoreController::class, 'status'])->name('store.status');
});

// ============================================
// SELLER ROUTES (member with approved store)
// ============================================

Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    
    // Products Management
    Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{id}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders Management
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Balance & Withdraw
    Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
    Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    Route::patch('/withdraw/bank-account', [SellerWithdrawController::class, 'updateBankAccount'])->name('withdraw.update-bank');
    
    // Store Management
    Route::get('/store', [SellerStoreController::class, 'edit'])->name('store.edit');
    Route::patch('/store', [SellerStoreController::class, 'update'])->name('store.update');
});

// ============================================
// ADMIN ROUTES (role: admin)
// ============================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Store Approval
    Route::get('/stores', [AdminStoreApprovalController::class, 'index'])->name('stores.index');
    Route::get('/stores/{id}', [AdminStoreApprovalController::class, 'show'])->name('stores.show');
    Route::post('/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve'])->name('stores.approve');
    Route::post('/stores/{id}/reject', [AdminStoreApprovalController::class, 'reject'])->name('stores.reject');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Products Management
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Transactions
    Route::get('/transactions', [AdminTransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [AdminTransactionsController::class, 'show'])->name('transactions.show');
});

// Profile routes untuk semua authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';