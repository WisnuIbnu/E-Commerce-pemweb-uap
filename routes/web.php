<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});
 
// USER PAGES
Route::get('/home', function () {
    return view('user.home.dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return view('user.home.dashboard');
})->name('dashboard');

Route::get('/products', function () {
    return view('user.home.products');
})->name('products');

Route::get('/history', function () {
    return view('user.home.history');
})->name('history');

// PROFILE (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Paksa GET /login dan /register pakai view figma-auth
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.figma-auth');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.figma-auth');
    })->name('register');
});