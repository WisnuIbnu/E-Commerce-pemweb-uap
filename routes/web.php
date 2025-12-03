<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manage Users
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Store Verification
        Route::get('/stores', [StoreVerificationController::class, 'index'])->name('store-verification');
        Route::post('/stores/{store}/verify', [StoreVerificationController::class, 'verify'])->name('stores.verify');
        Route::get('/stores/{store}', [StoreVerificationController::class, 'show'])->name('stores.show');
        Route::delete('/stores/{store}', [StoreVerificationController::class, 'destroy'])->name('stores.delete');

        // Withdrawal Management
Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals');
Route::post('/withdrawals/{withdrawal}/status', [\App\Http\Controllers\Admin\WithdrawalController::class, 'updateStatus'])->name('withdrawals.update-status');
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
