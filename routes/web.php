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


    /* CHECKOUT */
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');


    /* TRANSACTIONS (Riwayat Belanja) */
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

});

/* SELLER ROUTES */

Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

        // Store profile
        Route::get('/store', [StoreController::class, 'profile'])->name('store.profile');
        Route::put('/store', [StoreController::class, 'update'])->name('store.update');


        /* PRODUCT MANAGEMENT */
        Route::get('/products', [ProductController::class, 'sellerIndex'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Product Images
        Route::post('/products/{id}/images', [ProductImageController::class, 'store'])->name('product.images.store');
        Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy'])->name('product.images.delete');


        /* CATEGORY MANAGEMENT (SELLER) */
        Route::get('/categories', [ProductCategoryController::class, 'sellerIndex'])->name('categories.index');
        Route::post('/categories', [ProductCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [ProductCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');


        /* ORDERS FOR SELLER */
        Route::get('/orders', [TransactionController::class, 'sellerOrders'])->name('orders.index');
        Route::put('/orders/{id}/ship', [TransactionController::class, 'shipOrder'])->name('orders.ship');
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
