<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\ReviewController;

use App\Http\Controllers\Store\StoreRegistrationController;
use App\Http\Controllers\Store\DashboardController as StoreDashboard;
use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\BalanceController;
use App\Http\Controllers\Store\WithdrawalController;
use App\Http\Controllers\Store\StoreProfileController;
use App\Http\Controllers\Store\ProductManagementController;
use App\Http\Controllers\Store\CategoryManagementController;
use App\Http\Controllers\Store\ProductImageController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StoreManagementController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/seller-guide', 'pages.seller-guide')->name('seller.guide');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'customer'])->group(function () {
    
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [TransactionController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create/{transactionId}/{productId}', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth', 'seller'])->prefix('store')->name('store.')->group(function () {

    Route::get('/register', [StoreRegistrationController::class, 'create'])->name('register');
    Route::post('/register', [StoreRegistrationController::class, 'store'])->name('register.submit');
    Route::get('/pending', [StoreRegistrationController::class, 'pending'])->name('pending');

    Route::middleware('store.verified')->group(function () {
        Route::get('/dashboard', [StoreDashboard::class, 'index'])->name('dashboard');

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{id}/tracking', [OrderController::class, 'updateTracking'])->name('update-tracking');
        });

        Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
        Route::prefix('withdrawal')->name('withdrawal.')->group(function () {
            Route::get('/', [WithdrawalController::class, 'index'])->name('index');
            Route::post('/request', [WithdrawalController::class, 'store'])->name('request');
            Route::patch('/bank-account', [WithdrawalController::class, 'updateBankAccount'])->name('update-bank');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', [StoreProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [StoreProfileController::class, 'update'])->name('update');
            Route::delete('/delete', [StoreProfileController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductManagementController::class, 'index'])->name('index');
            Route::get('/create', [ProductManagementController::class, 'create'])->name('create');
            Route::post('/', [ProductManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductManagementController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [ProductManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductManagementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryManagementController::class, 'index'])->name('index');
            Route::get('/create', [CategoryManagementController::class, 'create'])->name('create');
            Route::post('/', [CategoryManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryManagementController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [CategoryManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryManagementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products/{productId}/images')->name('product-images.')->group(function () {
            Route::get('/', [ProductImageController::class, 'index'])->name('index');
            Route::post('/', [ProductImageController::class, 'store'])->name('store');
            Route::patch('/{id}/thumbnail', [ProductImageController::class, 'setThumbnail'])->name('set-thumbnail');
            Route::delete('/{id}', [ProductImageController::class, 'destroy'])->name('destroy');
        });
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('store-verification')->name('store-verification.')->group(function () {
        Route::get('/', [StoreVerificationController::class, 'index'])->name('index');
        Route::get('/{id}', [StoreVerificationController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [StoreVerificationController::class, 'verify'])->name('verify');
        Route::post('/{id}/reject', [StoreVerificationController::class, 'reject'])->name('reject');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/', [StoreManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [StoreManagementController::class, 'show'])->name('show');
        Route::post('/{id}/suspend', [StoreManagementController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/activate', [StoreManagementController::class, 'activate'])->name('activate');
        Route::delete('/{id}', [StoreManagementController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';