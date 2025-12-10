<?php

use Illuminate\Support\Facades\Route;

// BUYER
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerCartController;
use App\Http\Controllers\Buyer\BuyerCheckoutController;
use App\Http\Controllers\Buyer\BuyerOrderController;
use App\Http\Controllers\Buyer\BuyerProfileController;
use App\Http\Controllers\Buyer\BuyerStoreController;
use App\Http\Controllers\Buyer\BuyerReviewController;

// SELLER
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerImageController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminWithdrawalController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::middleware(['auth', 'verified'])->group(function () {

    // ROLE REDIRECT
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();

        if ($store) {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('buyer.dashboard');
    })->name('dashboard');


    // ============================================
    // BUYER ROUTES
    // ============================================
    Route::prefix('buyer')->name('buyer.')->group(function () {

        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/products', [BuyerProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [BuyerProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [BuyerCartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{id}/update', [BuyerCartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}', [BuyerCartController::class, 'delete'])->name('cart.destroy');

        Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [BuyerCheckoutController::class, 'placeOrder'])->name('checkout.process');

        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [BuyerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/cancel', [BuyerOrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/orders/{id}/confirm', [BuyerOrderController::class, 'confirmReceived'])->name('orders.confirm');
        Route::match(['get', 'post'], '/orders/{id}/payment', [BuyerOrderController::class, 'payment'])->name('orders.payment');

        Route::get('/profile/edit', [BuyerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [BuyerProfileController::class, 'update'])->name('profile.update');

        Route::get('/store/create', [BuyerStoreController::class, 'create'])->name('store.create');
        Route::post('/store', [BuyerStoreController::class, 'store'])->name('store.store');
        Route::get('/store/status', [BuyerStoreController::class, 'status'])->name('store.status');

        // REVIEW ROUTES
        Route::prefix('review')->name('review.')->group(function () {
            Route::get('/create/{transactionId}', [BuyerReviewController::class, 'create'])->name('create');
            Route::post('/{transactionId}', [BuyerReviewController::class, 'store'])->name('store');
            Route::delete('/{reviewId}', [BuyerReviewController::class, 'destroy'])->name('destroy');
            Route::get('/product/{productId}', [BuyerReviewController::class, 'productReviews'])->name('product-reviews');
        });
    });


    // ============================================
    // SELLER ROUTES
    // ============================================
    Route::prefix('seller')->name('seller.')->middleware(['verified_store'])->group(function () {

        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', SellerProductController::class);
        Route::resource('categories', SellerCategoryController::class);
        Route::resource('images', SellerImageController::class);

        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    });


    // ============================================
    // ADMIN ROUTES
    // ============================================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // STORES
        Route::get('/stores', [AdminStoreController::class, 'index'])->name('stores.index');
        Route::get('/stores/{id}', [AdminStoreController::class, 'show'])->name('stores.show');
        Route::post('/stores/{id}/approve', [AdminStoreController::class, 'approve'])->name('stores.approve');
        Route::post('/stores/{id}/verify', [AdminStoreController::class, 'verify'])->name('stores.verify');
        Route::post('/stores/{id}/reject', [AdminStoreController::class, 'reject'])->name('stores.reject');
        Route::post('/stores/{id}/restore', [AdminStoreController::class, 'restore'])->name('stores.restore');
        Route::delete('/stores/{id}', [AdminStoreController::class, 'destroy'])->name('stores.destroy');

        // USERS
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // ORDERS
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/verify-payment', [AdminOrderController::class, 'verifyPayment'])->name('orders.verify-payment');

        // WITHDRAWALS
        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
    });
});


require __DIR__ . '/auth.php';