<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\BalanceController;
use App\Http\Controllers\Seller\WithdrawalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Buyer Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
    
    // Checkout (Buyer only)
    Route::middleware('role:buyer')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index']);
        Route::post('/checkout/process', [CheckoutController::class, 'process']);
        
        // Transactions
        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::post('/transactions/{id}/review', [TransactionController::class, 'review']);
    });
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SellerDashboardController::class, 'index']);
    
    // Store Registration & Management
    Route::get('/store/register', [StoreController::class, 'showRegisterForm']);
    Route::post('/store/register', [StoreController::class, 'register']);
    Route::get('/store/edit', [StoreController::class, 'edit']);
    Route::put('/store', [StoreController::class, 'update']);
    
    // Product Management
    Route::get('/products', [SellerProductController::class, 'index']);
    Route::get('/products/create', [SellerProductController::class, 'create']);
    Route::post('/products', [SellerProductController::class, 'store']);
    Route::get('/products/{id}/edit', [SellerProductController::class, 'edit']);
    Route::put('/products/{id}', [SellerProductController::class, 'update']);
    Route::delete('/products/{id}', [SellerProductController::class, 'destroy']);
    
    // Category Management
    Route::get('/categories', [SellerProductController::class, 'categories']);
    Route::post('/categories', [SellerProductController::class, 'storeCategory']);
    Route::put('/categories/{id}', [SellerProductController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [SellerProductController::class, 'destroyCategory']);
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus']);
    Route::post('/orders/{id}/shipping', [OrderController::class, 'updateShipping']);
    
    // Balance & Withdrawal
    Route::get('/balance', [BalanceController::class, 'index']);
    Route::get('/withdrawals', [WithdrawalController::class, 'index']);
    Route::post('/withdrawals', [WithdrawalController::class, 'store']);
    Route::put('/withdrawals/bank', [WithdrawalController::class, 'updateBank']);
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    
    // Store Verification
    Route::get('/stores/verification', [StoreVerificationController::class, 'index']);
    Route::post('/stores/{id}/verify', [StoreVerificationController::class, 'verify']);
    Route::post('/stores/{id}/reject', [StoreVerificationController::class, 'reject']);
    
    // User & Store Management
    Route::get('/users', [UserManagementController::class, 'users']);
    Route::get('/stores', [UserManagementController::class, 'stores']);
    Route::delete('/users/{id}', [UserManagementController::class, 'deleteUser']);
    Route::delete('/stores/{id}', [UserManagementController::class, 'deleteStore']);
});