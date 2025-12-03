<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\ProductController;

Route::prefix('buyer')->middleware(['auth', 'role:buyer'])->group(function () {

    Route::get('/home', [BuyerController::class, 'home'])->name('buyer.home');

    Route::get('/products', [BuyerController::class, 'products'])->name('buyer.products');

    Route::get('/product/{id}', [BuyerController::class, 'productDetail'])->name('buyer.product.detail');

    Route::post('/cart/add/{id}', [BuyerController::class, 'addToCart'])->name('buyer.cart.add');

    Route::get('/cart', [BuyerController::class, 'cart'])->name('buyer.cart');

    Route::get('/checkout', [BuyerController::class, 'checkout'])->name('buyer.checkout');
    Route::post('/checkout/process', [BuyerController::class, 'processCheckout'])->name('buyer.checkout.process');

    Route::get('/order-success', [BuyerController::class, 'orderSuccess'])->name('buyer.order.success');

    Route::get('/profile', [BuyerController::class, 'profile'])->name('buyer.profile');
});