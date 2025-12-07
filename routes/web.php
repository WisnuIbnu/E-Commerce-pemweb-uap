<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminSellerApprovalController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


// PUBLIC
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [ProductCategoryController::class, 'index']);
Route::get('/categories/{id}/products', [ProductCategoryController::class, 'listProducts']);


// AUTH
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MEMBER
    Route::middleware('role:member')->group(function () {

        Route::post('/checkout', [CheckoutController::class, 'checkout']);

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    });


    // SELLER (HARUS PAKAI middleware seller)
    Route::middleware('seller')->group(function () {

        Route::get('/store/profile', [StoreController::class, 'profile']);
        Route::put('/store/profile', [StoreController::class, 'update']);

        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::post('/products/{id}/images', [ProductImageController::class, 'store']);
        Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy']);

        Route::post('/categories', [ProductCategoryController::class, 'store']);
        Route::put('/categories/{id}', [ProductCategoryController::class, 'update']);
        Route::delete('/categories/{id}', [ProductCategoryController::class, 'destroy']);

        Route::get('/store/orders', [TransactionController::class, 'sellerOrders']);
        Route::put('/store/orders/{id}/ship', [TransactionController::class, 'shipOrder']);
    });


    // ADMIN
    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/stores', [AdminSellerApprovalController::class, 'listStores']);

        Route::post('/admin/store/approve/{storeId}', [AdminSellerApprovalController::class, 'approve']);
        Route::post('/admin/store/reject/{storeId}', [AdminSellerApprovalController::class, 'reject']);

        Route::get('/admin/users', [AdminUserController::class, 'index']);
        Route::get('/admin/users/{id}', [AdminUserController::class, 'show']);
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy']);
    });

});

require __DIR__.'/auth.php';
