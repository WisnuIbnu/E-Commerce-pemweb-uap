<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Customer\ProductReviewController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route produk customer
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Route store customer
Route::get('/store/{id}', [StoreController::class, 'show'])->name('store.show');


// Product Reviews Routes
Route::get('/product/{product}/reviews', [ProductReviewController::class, 'index'])
    ->name('product.reviews.index');

Route::post('/product/{product}/reviews', [ProductReviewController::class, 'store'])
    ->middleware('auth')
    ->name('product.reviews.store');


// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
require __DIR__.'/auth.php';
