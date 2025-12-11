<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\StoreBalanceController;
use App\Http\Controllers\StoreBalanceHistoryController;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth')->group(function () {
    Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.store');
    Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::patch('/store/edit', [StoreController::class, 'update'])->name('store.update');
    Route::delete('/store/{store}', [StoreController::class, 'destroy'])->name('store.destroy');

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::patch('/product/edit/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/category/create', [ProductCategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [ProductCategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{category}/edit', [ProductCategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/category/{category}', [ProductCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [ProductCategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/withdrawal/create', [WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal/store', [WithdrawalController::class, 'store'])->name('withdrawal.store');
    Route::get('/withdrawal/{withdrawal}/edit', [WithdrawalController::class, 'edit'])->name('withdrawal.edit');
    Route::patch('/withdrawal/edit', [WithdrawalController::class, 'update'])->name('withdrawal.update');

    Route::get('/store/balance/history', [StoreBalanceHistoryController::class, 'view'])->name('balance.history');
});

require __DIR__.'/auth.php';
