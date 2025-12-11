<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminSellerApprovalController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\Admin\AdminDashboardController;


/* PUBLIC ROUTES */

// Landing Page (Marketing Page)
Route::get('/', [HomeController::class, 'landing'])->name('landing');
Route::get('/store/{id}', [StoreController::class, 'showPublic'])->name('store.show');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}/products', [ProductCategoryController::class, 'listProducts'])->name('categories.products');


/* AUTHENTICATED ROUTES (PROFILE) */

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/* DASHBOARD REDIRECT (DYNAMIC ROLE REDIRECT) */

Route::middleware('auth')->get('/dashboard', function () {

    $role = Auth::user()->role;

    return match ($role) {

        'admin'  => redirect()->route('admin.dashboard'),
        'seller' => redirect()->route('seller.dashboard'),

        // Member/customer goes to home (product browsing)
        default  => redirect()->route('landing'),
    };

})->name('dashboard');



/* MEMBER ROUTES (CUSTOMER) */

Route::middleware(['auth', 'role:member'])->group(function () {

    /* CART */
    Route::post('/cart/add/{id}', function (Request $request, $id) {

        $request->validate([
            'qty' => 'nullable|integer|min:1'
        ]);

        $qty = $request->qty ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = ['qty' => $qty];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    })->name('cart.add');

    Route::get('/cart', [CheckoutController::class, 'showCart'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CheckoutController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CheckoutController::class, 'clearCart'])->name('cart.clear');

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // TRANSACTIONS
    Route::get('/transactions', [CheckoutController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [CheckoutController::class, 'show'])->name('transactions.show');
});

Route::middleware(['auth', 'role:member'])
    ->get('/seller/register-store', [StoreController::class, 'register'])
    ->name('seller.store.register-form');

Route::middleware(['auth', 'role:member'])
    ->post('/seller/register-store', [StoreController::class, 'storeRegister'])
    ->name('seller.store.register');

/* SELLER ROUTES */
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

        // PROFIL TOKO
        Route::get('/store/profile', [StoreController::class, 'profilePage'])->name('store.profile');
        Route::put('/store/profile', [StoreController::class, 'update'])->name('store.update');

        // PRODUK
        Route::get('/products', [ProductController::class, 'sellerIndex'])->name('products.index');

        // KATEGORI
        Route::get('/categories', [ProductCategoryController::class, 'sellerIndex'])->name('categories.index');

        // PESANAN
        Route::get('/orders', [TransactionController::class, 'sellerOrders'])->name('orders.index');

        // SALDO TOKO
        Route::get('/balance', [StoreController::class, 'wallet'])->name('balance.index');
        Route::get('/balance/history', [StoreController::class, 'walletHistory'])->name('balance.history');

        // PENARIKAN DANA
        Route::get('/withdraw', [StoreController::class, 'withdrawPage'])->name('withdraw.index');
        Route::post('/withdraw', [StoreController::class, 'withdrawRequest'])->name('withdraw.request');

        // INFORMASI BANK
        Route::get('/bank', [StoreController::class, 'bankPage'])->name('bank.index');
        Route::post('/bank', [StoreController::class, 'bankUpdate'])->name('bank.update');

    });

/* ADMIN ROUTES */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /* DASHBOARD */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /* USER MANAGEMENT */
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        /* STORE MANAGEMENT */
        Route::get('/stores', [AdminStoreController::class, 'index'])->name('stores.index');

        Route::post('/stores/{id}/approve', [AdminStoreController::class, 'approve'])
            ->name('stores.approve');

        Route::post('/stores/{id}/reject', [AdminStoreController::class, 'reject'])
            ->name('stores.reject');

        Route::delete('/stores/{id}', [AdminStoreController::class, 'destroy'])
            ->name('stores.destroy');

        /* Admin edit store info */
        Route::get('/stores/{id}/edit', [AdminSellerApprovalController::class, 'edit'])
            ->name('stores.edit');

        Route::put('/stores/{id}', [AdminSellerApprovalController::class, 'update'])
            ->name('stores.update');


        /* PRODUCT MANAGEMENT (ADMIN) */
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'adminCreate'])->name('products.create');
        Route::post('/products', [ProductController::class, 'adminStore'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'adminEdit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'adminUpdate'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'adminDestroy'])->name('products.destroy');

        /* CATEGORY MANAGEMENT */
        Route::get('/categories', [ProductCategoryController::class, 'adminIndex'])->name('categories.index');
        Route::get('/categories/create', [ProductCategoryController::class, 'adminCreate'])->name('categories.create');
        Route::post('/categories', [ProductCategoryController::class, 'adminStore'])->name('categories.store');
        Route::get('/categories/{id}/edit', [ProductCategoryController::class, 'adminEdit'])->name('categories.edit');
        Route::put('/categories/{id}', [ProductCategoryController::class, 'adminUpdate'])->name('categories.update');
        Route::delete('/categories/{id}', [ProductCategoryController::class, 'adminDestroy'])->name('categories.destroy');
    });
require __DIR__.'/auth.php';