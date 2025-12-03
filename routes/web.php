<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manage Users
        Route::get('/users', [AdminController::class, 'users'])->name('users');

        // Manage Sellers
        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers');

        // Manage Products
        Route::get('/products', [ProductController::class, 'index'])->name('products');

        // Manage Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
