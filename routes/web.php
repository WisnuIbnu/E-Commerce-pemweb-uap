<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\ReviewController;

use App\Http\Controllers\Store\StoreRegistrationController;
use App\Http\Controllers\Store\DashboardController as StoreDashboard;
use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\BalanceController;
use App\Http\Controllers\Store\WithdrawalController;
use App\Http\Controllers\Store\StoreProfileController;
use App\Http\Controllers\Store\ProductManagementController;
use App\Http\Controllers\Store\CategoryManagementController;
use App\Http\Controllers\Store\ProductImageController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StoreManagementController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('pages.index');
})->name('home');

Route::view('/marketplace', 'pages.marketplace')->name('marketplace');
Route::view('/how-it-works', 'pages.how')->name('how-it-works');
Route::view('/pricing', 'pages.pricing')->name('pricing');
Route::view('/sell', 'pages.sell')->name('sell');
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/support', 'pages.support')->name('support');
Route::view('/guide', 'pages.guide')->name('guide');
Route::view('/sellerguide', 'pages.sellerguide')->name('sellerguide');
Route::view('/safety', 'pages.safety')->name('safety');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/refund', 'pages.refund')->name('refund');
Route::view('/cookies', 'pages.cookies')->name('cookies');
Route::view('/sitemap', 'pages.sitemap')->name('sitemap');
Route::view('/seller-guide', 'pages.seller-guide')->name('seller.guide');

Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.account.delete');

    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::match(['GET', 'POST'], '/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/{code}', [CheckoutController::class, 'payment'])->name('show');
        Route::post('/{code}/confirm', [CheckoutController::class, 'confirmPayment'])->name('confirm');
    });

    Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');
});

Route::middleware(['auth', 'customer'])->group(function () {
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [TransactionController::class, 'cancel'])->name('cancel');
        Route::post('/{id}/confirm-payment', [TransactionController::class, 'confirmPayment'])->name('confirm-payment');
        Route::post('/{id}/confirm-received', [TransactionController::class, 'confirmReceived'])->name('confirm-received');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create/{transactionId}/{productId}', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth', 'seller'])->prefix('store')->name('store.')->group(function () {
    Route::get('/register', [StoreRegistrationController::class, 'create'])->name('register');
    Route::post('/register', [StoreRegistrationController::class, 'store'])->name('register.submit');
    Route::get('/pending', [StoreRegistrationController::class, 'pending'])->name('pending');

    Route::middleware('store.verified')->group(function () {
        Route::get('/dashboard', [StoreDashboard::class, 'index'])->name('dashboard');

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{id}/tracking', [OrderController::class, 'updateTracking'])->name('update-tracking');
        });

        Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');

        Route::prefix('withdrawal')->name('withdrawal.')->group(function () {
            Route::get('/', [WithdrawalController::class, 'index'])->name('index');
            Route::post('/', [WithdrawalController::class, 'store'])->name('store');
            Route::post('/bank-account', [WithdrawalController::class, 'updateBankAccount'])->name('updateBankAccount');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', [StoreProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [StoreProfileController::class, 'update'])->name('update');
            Route::delete('/delete', [StoreProfileController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductManagementController::class, 'index'])->name('index');
            Route::get('/create', [ProductManagementController::class, 'create'])->name('create');
            Route::post('/', [ProductManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductManagementController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [ProductManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductManagementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryManagementController::class, 'index'])->name('index');
            Route::get('/create', [CategoryManagementController::class, 'create'])->name('create');
            Route::post('/', [CategoryManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryManagementController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [CategoryManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryManagementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products/{productId}/images')->name('product-images.')->group(function () {
            Route::get('/', [ProductImageController::class, 'index'])->name('index');
            Route::post('/', [ProductImageController::class, 'store'])->name('store');
            Route::patch('/{id}/thumbnail', [ProductImageController::class, 'setThumbnail'])->name('set-thumbnail');
            Route::delete('/{id}', [ProductImageController::class, 'destroy'])->name('destroy');
        });
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [AdminDashboard::class, 'transactions'])->name('index');
    });

    Route::prefix('store-verification')->name('store-verification.')->group(function () {
        Route::get('/', [StoreVerificationController::class, 'index'])->name('index');
        Route::get('/{id}', [StoreVerificationController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [StoreVerificationController::class, 'verify'])->name('verify');
        Route::post('/{id}/reject', [StoreVerificationController::class, 'reject'])->name('reject');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/', [StoreManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [StoreManagementController::class, 'show'])->name('show');
        Route::post('/{id}/suspend', [StoreManagementController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/activate', [StoreManagementController::class, 'activate'])->name('activate');
        Route::delete('/{id}', [StoreManagementController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__ . '/auth.php';