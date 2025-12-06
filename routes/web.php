<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;

// Seller Controllers
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\ProductImageController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\BalanceController;
use App\Http\Controllers\Seller\WithdrawalController;

// Admin Controllers
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StoreManagementController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Checkout & Transactions
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
    
    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    
    // Store Registration (accessible to all authenticated users)
    Route::get('/register', [SellerStoreController::class, 'create'])->name('register');
    Route::post('/register', [SellerStoreController::class, 'store'])->name('register.store');
    
    // Seller Dashboard & Management (only for approved sellers)
    Route::middleware(['seller'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        
        // Store Profile
        Route::get('/store/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::put('/store', [SellerStoreController::class, 'update'])->name('store.update');
        
        // Product Management
        Route::resource('products', SellerProductController::class);
        
        // Product Images
        Route::post('/products/{product}/images', [ProductImageController::class, 'store'])->name('products.images.store');
        Route::delete('/products/images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
        
        // Order Management
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{transaction}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{transaction}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        
        // Balance & Withdrawals
        Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
        Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $totalStores = \App\Models\Store::where('status', 'approved')->count();
        $totalProducts = \App\Models\Product::count();
        $totalRevenue = \App\Models\Transaction::where('status', 'completed')->sum('total');
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $recentStores = \App\Models\Store::with('buyer')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores', 
            'totalProducts',
            'totalRevenue',
            'recentUsers',
            'recentStores'
        ));
    })->name('dashboard');
    
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    
    // Store Management
    Route::get('/stores', [StoreManagementController::class, 'index'])->name('stores.index');
    Route::get('/stores/{store}', [StoreManagementController::class, 'show'])->name('stores.show');
    Route::put('/stores/{store}', [StoreManagementController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreManagementController::class, 'destroy'])->name('stores.destroy');
    
    // Store Verification
    Route::get('/stores/pending', [StoreVerificationController::class, 'index'])->name('stores.pending');
    Route::get('/stores/{store}/verify', [StoreVerificationController::class, 'show'])->name('stores.verify');
    Route::post('/stores/{store}/approve', [StoreVerificationController::class, 'approve'])->name('stores.approve');
    Route::post('/stores/{store}/reject', [StoreVerificationController::class, 'reject'])->name('stores.reject');
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Withdrawal Management
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
});