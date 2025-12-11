<?php

use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\BalanceController as SellerBalanceController;
use App\Http\Controllers\Seller\WithdrawalController as SellerWithdrawalController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\CategoryController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return redirect()->route('login');
});
 
// ================= USER SIDE (WAJIB LOGIN) =================

Route::middleware('auth')->group(function () {
    // Home / Dashboard
    Route::get('/home', function () {
        $newArrivals = App\Models\Product::with('productImages')->latest()->take(4)->get();
        return view('user.home.dashboard', compact('newArrivals'));
    })->name('home');

    Route::get('/dashboard', function () {
        $newArrivals = App\Models\Product::with('productImages')->latest()->take(4)->get();
        return view('user.home.dashboard', compact('newArrivals'));
    })->name('dashboard');

    // ✅ Katalog produk
    Route::get('/products', [UserProductController::class, 'index'])
        ->name('products');
    
    // ✅ Detail Produk
    Route::get('/products/{product:slug}', [UserProductController::class, 'show'])
        ->name('products.show');

    // ✅ History transaksi
    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history');

    // Profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daftar jadi seller
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])
        ->name('profile.becomeSeller');

    // Cart
    Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update'); // Add update route
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/buy/{product}', [CartController::class, 'buyNow'])->name('cart.buy');

    // Checkout
    Route::get('/checkout', [\App\Http\Controllers\User\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\User\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/payment', [\App\Http\Controllers\User\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/pay', [\App\Http\Controllers\User\CheckoutController::class, 'processPayment'])->name('checkout.pay');
});

require __DIR__.'/auth.php';

// ================= SELLER SIDE =================
Route::middleware(['auth', 'role:seller', 'store.verified'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        // Dashboard Seller
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Produk
        Route::resource('/products', SellerProductController::class);

        // Pesanan Masuk (Untuk melihat pesanan yang diterima oleh seller)
        Route::resource('/orders', SellerOrderController::class);

        // Saldo Toko (Untuk melihat saldo toko dan history saldo)
        Route::resource('/balance', SellerBalanceController::class);

        // Penarikan Dana (Untuk meminta penarikan dana oleh seller)
        Route::resource('/withdrawals', SellerWithdrawalController::class);

        // Profil Toko (Untuk mengedit dan melihat profil toko)
        Route::get('/store', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store', [SellerStoreController::class, 'update'])->name('store.update');

        // Kategori Produk
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    });

    // ================= ADMIN SIDE =================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Store Verification
        Route::get('/store-verification', [AdminController::class, 'storeVerification'])->name('storeVerification');
        Route::post('/store/{storeId}/verify', [AdminController::class, 'verifyStore'])->name('store.verify');
        Route::post('/store/{storeId}/reject', [AdminController::class, 'rejectStore'])->name('store.reject');

        // Manage Users and Stores
        Route::get('/users-and-stores', [AdminController::class, 'manageUsersAndStores'])->name('usersAndStores');
        Route::delete('/user/{userId}', [AdminController::class, 'deleteUser'])->name('user.delete');
        Route::delete('/store/{storeId}', [AdminController::class, 'deleteStore'])->name('store.delete');

        // Withdrawal Management
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals/{id}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{id}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    });
