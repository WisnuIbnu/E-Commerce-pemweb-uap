<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\{
    BuyerHomeController,
    BuyerProductController,
    BuyerCartController,
    BuyerCheckoutController,
    BuyerOrderController,
    BuyerProfileController,
    BuyerStoreController
};
use App\Http\Controllers\Seller\{
    SellerDashboardController,
    SellerProductController,
    SellerOrderController,
    SellerBalanceController,
    SellerWithdrawController
};
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminStoreApprovalController,
    AdminUserController,
    AdminProductController
};

// ============================================
// ROOT REDIRECT - Langsung ke Dashboard
// ============================================
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// ============================================
// DASHBOARD - WAJIB LOGIN
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Cek apakah user punya toko approved (Seller)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();
        
        if ($store) {
            return redirect()->route('seller.dashboard');
        }
        
        // Default: buyer
        return redirect()->route('buyer.dashboard');
    })->name('dashboard');

    // ===========================================
    // BUYER ROUTES
    // ===========================================
    Route::middleware(['role:member'])->prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/dashboard', [BuyerHomeController::class, 'index'])->name('dashboard');
        Route::get('/products', [BuyerProductController::class, 'index'])->name('products.index');
        Route::get('/product/{id}', [BuyerProductController::class, 'show'])->name('product.show');
        Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart');
        Route::post('/cart/add', [BuyerCartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{id}', [BuyerCartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}', [BuyerCartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/process', [BuyerCheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders');
        Route::get('/order/{id}', [BuyerOrderController::class, 'show'])->name('order.show');
        Route::get('/profile', [BuyerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [BuyerProfileController::class, 'update'])->name('profile.update');
        
        // Store Application
        Route::get('/apply-store', [BuyerStoreController::class, 'create'])->name('store.apply');
        Route::post('/apply-store', [BuyerStoreController::class, 'store'])->name('store.submit');
        Route::get('/store-status', [BuyerStoreController::class, 'status'])->name('store.status');
    });

    // ===========================================
    // SELLER ROUTES
    // ===========================================
    Route::middleware(['role:seller'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', SellerProductController::class);
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    });

    // ===========================================
    // ADMIN ROUTES
    // ===========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/stores', [AdminStoreApprovalController::class, 'index'])->name('stores.index');
        Route::get('/stores/{id}', [AdminStoreApprovalController::class, 'show'])->name('stores.show');
        Route::post('/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve'])->name('stores.approve');
        Route::post('/stores/{id}/reject', [AdminStoreApprovalController::class, 'reject'])->name('stores.reject');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    });
});

// Auth routes
require __DIR__.'/auth.php';
