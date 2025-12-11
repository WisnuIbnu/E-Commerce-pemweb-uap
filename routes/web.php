<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () { 
// return view('welcome'); 
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/{user}/status', [AdminController::class, 'updateStatus'])->name('dashboard.updateStatus');

    Route::get('/admin/stores', [AdminStoreController::class, 'index'])->name('admin.stores');
    Route::post('/admin/stores/{store}/approve', [AdminStoreController::class, 'approve'])->name('admin.stores.approve');
    Route::post('/admin/stores/{store}/reject', [AdminStoreController::class, 'reject'])->name('admin.stores.reject');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class,'process'])->name('checkout.process');

    Route::get('/transactions', [TransactionController::class,'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class,'show'])->name('transactions.show');
});

require __DIR__.'/auth.php';
