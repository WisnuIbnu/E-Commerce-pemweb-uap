<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StoreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Seller\StoreController::class, 'dashboard'])
        ->name('dashboard');

    // ROUTE STORE
    Route::get('/store/create', [\App\Http\Controllers\Seller\StoreController::class, 'create'])
        ->name('store.create');
    Route::post('/store', [\App\Http\Controllers\Seller\StoreController::class, 'store'])
        ->name('store.store');

    Route::get('/store/edit', [\App\Http\Controllers\Seller\StoreController::class, 'edit'])
        ->name('store.edit');
    Route::post('/store/update', [\App\Http\Controllers\Seller\StoreController::class, 'update'])
        ->name('store.update');

         Route::get('/products', function () {
        return "HALAMAN PRODUCT INDEX SEMENTARA";
    })->name('products.index');
});


Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Store Management
        Route::resource('stores', StoreController::class);

        // Route approve harus DI LUAR resource
        Route::get('stores/{store}/approve', [StoreController::class, 'approve'])->name('stores.approve');
});

