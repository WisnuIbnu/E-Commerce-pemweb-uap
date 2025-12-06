<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StoreManagementController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Guest Routes (Authentication)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Email Verification
    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    
    // Checkout & Transactions
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    
    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
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
});

// Seller Routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    // Store Registration
    Route::get('/register', [App\Http\Controllers\Seller\StoreController::class, 'create'])
        ->name('register');
    Route::post('/register', [App\Http\Controllers\Seller\StoreController::class, 'store'])
        ->name('register.store');
    
    // Seller Dashboard & Store Management (only for approved stores)
    Route::middleware(['seller'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Store Profile
        Route::get('/store/edit', [App\Http\Controllers\Seller\StoreController::class, 'edit'])
            ->name('store.edit');
        Route::put('/store', [App\Http\Controllers\Seller\StoreController::class, 'update'])
            ->name('store.update');
        
        // Product Management
        Route::resource('products', App\Http\Controllers\Seller\ProductController::class);
        
        // Product Images
        Route::post('/products/{product}/images', [App\Http\Controllers\Seller\ProductImageController::class, 'store'])
            ->name('products.images.store');
        Route::delete('/products/images/{image}', [App\Http\Controllers\Seller\ProductImageController::class, 'destroy'])
            ->name('products.images.destroy');
        
        // Order Management
        Route::get('/orders', [App\Http\Controllers\Seller\OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/orders/{transaction}', [App\Http\Controllers\Seller\OrderController::class, 'show'])
            ->name('orders.show');
        Route::put('/orders/{transaction}/status', [App\Http\Controllers\Seller\OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        
        // Balance & Withdrawals
        Route::get('/balance', [App\Http\Controllers\Seller\BalanceController::class, 'index'])
            ->name('balance.index');
        Route::get('/withdrawals', [App\Http\Controllers\Seller\WithdrawalController::class, 'index'])
            ->name('withdrawals.index');
        Route::get('/withdrawals/create', [App\Http\Controllers\Seller\WithdrawalController::class, 'create'])
            ->name('withdrawals.create');
        Route::post('/withdrawals', [App\Http\Controllers\Seller\WithdrawalController::class, 'store'])
            ->name('withdrawals.store');
    });
});

// Admin Store Verification Routes (ADD TO EXISTING ADMIN GROUP)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... existing admin routes ...
    
    // Store Verification
    Route::get('/stores/pending', [App\Http\Controllers\Admin\StoreVerificationController::class, 'index'])
        ->name('stores.pending');
    Route::get('/stores/{store}/verify', [App\Http\Controllers\Admin\StoreVerificationController::class, 'show'])
        ->name('stores.verify');
    Route::post('/stores/{store}/approve', [App\Http\Controllers\Admin\StoreVerificationController::class, 'approve'])
        ->name('stores.approve');
    Route::post('/stores/{store}/reject', [App\Http\Controllers\Admin\StoreVerificationController::class, 'reject'])
        ->name('stores.reject');
    
    // Category Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Withdrawal Management
    Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])
        ->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])
        ->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])
        ->name('withdrawals.reject');
});
