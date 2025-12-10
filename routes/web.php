<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminSellerApprovalController;
use App\Http\Controllers\AdminUserController;

/*
| PUBLIC ROUTES
*/

// Homepage
Route::get('/', [ProductController::class, 'publicHome'])->name('home');

// Produk publik
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Kategori publik
Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}/products', [ProductCategoryController::class, 'listProducts'])->name('categories.products');


/*
| AUTH ROUTES (PROFILE)
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
| DASHBOARD REDIRECT (DYNAMIC BY ROLE)
*/

Route::middleware('auth')->get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'seller' => redirect()->route('seller.dashboard'),
        default => redirect()->route('home'),
    };
})->name('dashboard');


/*
| MEMBER ROUTES (CUSTOMER)
*/

Route::middleware(['auth', 'role:member'])->group(function () {

    // Add to Cart
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

        return redirect()->back()->with('success', 'Produk ditambahkan ke cart!');
    })->name('cart.add');

    // Cart
    Route::get('/cart', [CheckoutController::class, 'showCart'])->name('cart.index');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Transaction History
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});


/*
| SELLER ROUTES
*/

Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

        // Store Profile
        Route::get('/store', [StoreController::class, 'profile'])->name('store.profile');
        Route::put('/store', [StoreController::class, 'update'])->name('store.update');

        // Products CRUD
        Route::get('/products', [ProductController::class, 'sellerIndex'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Product Images
        Route::post('/products/{id}/images', [ProductImageController::class, 'store'])->name('product.images.store');
        Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy'])->name('product.images.delete');

        // Categories
        Route::get('/categories', [ProductCategoryController::class, 'sellerIndex'])->name('categories.index');
        Route::post('/categories', [ProductCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [ProductCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');

        // Orders
        Route::get('/orders', [TransactionController::class, 'sellerOrders'])->name('orders.index');
        Route::put('/orders/{id}/ship', [TransactionController::class, 'shipOrder'])->name('orders.ship');
    });


/*
| ADMIN ROUTES
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Store Verification
        Route::get('/stores', [AdminSellerApprovalController::class, 'listStores'])
            ->name('stores.index');

        Route::post('/stores/{id}/approve', [AdminSellerApprovalController::class, 'approve'])
            ->name('stores.approve');

        Route::post('/stores/{id}/reject', [AdminSellerApprovalController::class, 'reject'])
            ->name('stores.reject');

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{id}', [AdminUserController::class, 'show'])
            ->name('users.show');

        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');
    });

// Breeze Auth
require __DIR__ . '/auth.php';