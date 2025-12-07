<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerDashboardController;
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
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreApprovalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Seller (member dengan toko verified)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();
        
        if ($store) {
            return redirect()->route('seller.dashboard');
        }
        
        // Default: Buyer
        return redirect()->route('buyer.dashboard');
    })->name('dashboard');

// ============================================
// BUYER ROUTES
// ============================================

Route::middleware(['auth', 'verified', 'role:member'])->group(function () {
    
    // Dashboard/Homepage Buyer
    Route::get('/buyer/dashboard', [BuyerDashboardController::class, 'index'])->name('buyer.dashboard');
    
    // Alias untuk home
    Route::get('/home', [BuyerDashboardController::class, 'index'])->name('home');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}/delete', [CartController::class, 'delete'])->name('cart.delete');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/confirm-received', [OrderController::class, 'confirmReceived'])->name('orders.confirm');
    
    // Profile
    Route::get('/profile', function() {
        return view('buyer.profile.index');
    })->name('profile.index');
    
});

// Store Application (bisa diakses tanpa login atau dengan login)
Route::get('/store/apply', function() {
    return view('store.apply');
})->name('store.apply');

// Store Dashboard (untuk seller)
Route::middleware(['auth', 'verified', 'role:seller'])->group(function () {
    Route::get('/store/dashboard', function() {
        return redirect()->route('store.dashboard');
    })->name('store.dashboard');
});


    // ============================================
    // SELLER ROUTES
    // ============================================
    Route::prefix('seller')->name('seller.')->middleware(['role:seller'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::resource('products', SellerProductController::class);
        
        // Orders
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Balance & Withdraw
        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    });

    // ============================================
    // ADMIN ROUTES
    // ============================================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Store Approvals
        Route::get('/stores', [AdminStoreApprovalController::class, 'index'])->name('stores.index');
        Route::get('/stores/{id}', [AdminStoreApprovalController::class, 'show'])->name('stores.show');
        Route::post('/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve'])->name('stores.approve');
        Route::post('/stores/{id}/reject', [AdminStoreApprovalController::class, 'reject'])->name('stores.reject');
        
        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        
        // Products
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });
});

// Auth routes
require __DIR__.'/auth.php';
