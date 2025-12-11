<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWithdrawalController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\UserTransactionController;

use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Seller\SellerWithdrawalController;
use App\Http\Controllers\Seller\SellerCategoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:buyer'])->group(function () {

    // Dashboard buyer
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Pesanan aktif (tracking)
    Route::get('/orders', [UserTransactionController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}/track', [UserTransactionController::class, 'track'])->name('orders.track');

    // Transaksi user (riwayat + detail + konfirmasi bayar)
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [UserTransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{id}/pay', [UserTransactionController::class, 'pay'])->name('transactions.pay');

    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])
    ->middleware('auth')
    ->name('products.reviews.store');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('users', AdminUserController::class);

        // Store verifikasi / reject
        Route::post('/stores/{store}/verify', [AdminStoreController::class, 'verify'])
            ->name('stores.verify');

        Route::post('/stores/{store}/reject', [AdminStoreController::class, 'reject'])
            ->name('stores.reject');

        Route::resource('stores', AdminStoreController::class);

        Route::resource('transactions', AdminTransactionController::class)
            ->only(['index', 'show', 'update']);

        Route::resource('withdrawals', AdminWithdrawalController::class)
            ->only(['index', 'show', 'update']);
    });

Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // 1. Form data toko + dashboard
        Route::get('/form', [SellerController::class, 'create'])->name('form');
        Route::post('/form', [SellerController::class, 'store'])->name('store');
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');

        // 2. Product Management
        Route::resource('products', SellerProductController::class)
            ->names('products');

        // 3. Order Management Page
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::match(['put', 'patch'], '/orders/{order}', [SellerOrderController::class, 'update'])
            ->name('orders.update');

        // 4. Store Balance Page
        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');

        // 5. Withdrawal Page (SELLER)
        Route::get('/withdrawals', [SellerWithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals', [SellerWithdrawalController::class, 'store'])->name('withdrawals.store');

        // 6. Seller Store Page (profil toko + bank)
        Route::get('/store', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::put('/store', [SellerStoreController::class, 'update'])->name('store.update');

        // 7. Seller Categories
        Route::resource('categories', SellerCategoryController::class)
            ->except(['show']);
    });

// debug route (optional, boleh dihapus kalau nggak dipakai)
Route::get('/public-path', function () {
    return public_path();
});

require __DIR__ . '/auth.php';
