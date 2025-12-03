<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerHomeController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerStoreController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreApprovalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

// Setelah login, arahkan ke halaman sesuai role
Route::get('/home', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin');  // Admin langsung ke dashboard admin
    }

    if (auth()->user()->role === 'member') {
        // Cek apakah member sudah menjadi seller (tokonya sudah disetujui)
        if (\App\Models\Store::where('user_id', auth()->id())->where('status', 'approved')->exists()) {
            return redirect('/seller');  // Seller langsung ke dashboard seller
        }
        return redirect('/');  // Buyer ke halaman utama
    }
})->middleware(['auth'])->name('home');

// Routes untuk Buyer (Role: member)
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/', [BuyerHomeController::class, 'index']);  // Halaman home untuk Buyer
    Route::get('/products', [BuyerProductController::class, 'index']);  // Daftar produk
    Route::get('/product/{id}', [BuyerProductController::class, 'show']);  // Halaman detail produk
    Route::get('/cart', [BuyerCartController::class, 'index']);  // Keranjang belanja
    Route::get('/checkout', [BuyerCheckoutController::class, 'index']);  // Halaman checkout
    Route::get('/orders', [BuyerOrderController::class, 'index']);  // Daftar pesanan
    Route::get('/profile', [BuyerProfileController::class, 'index']);  // Halaman profil
    Route::get('/apply-store', [BuyerStoreController::class, 'apply']);  // Halaman pengajuan toko
});

// Routes untuk Seller (Role: member dengan toko disetujui)
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/seller', [SellerDashboardController::class, 'index']);  // Halaman dashboard seller
    Route::resource('/seller/products', SellerProductController::class);  // Pengelolaan produk
    Route::get('/seller/balance', [SellerBalanceController::class, 'index']);  // Saldo toko
});

// Routes untuk Admin (Role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index']);  // Halaman dashboard admin
    Route::get('/admin/stores', [AdminStoreApprovalController::class, 'index']);  // Daftar toko yang perlu disetujui
    Route::post('/admin/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve']);  // Proses persetujuan toko
    Route::get('/admin/stores', [StoreVerificationController::class, 'index'])->name('store-verification');
    Route::post('/admin/stores/{store}/verify', [StoreVerificationController::class, 'verify'])->name('stores.verify');
    Route::get('/admin/stores/{store}', [StoreVerificationController::class, 'show'])->name('stores.show');
    Route::delete('/admin/stores/{store}', [StoreVerificationController::class, 'destroy'])->name('stores.delete');
    Route::get('/admin/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/admin/withdrawals/{withdrawal}/status', [WithdrawalController::class, 'updateStatus'])->name('withdrawals.update-status');
});
