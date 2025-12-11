<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsCustomer;
use App\Http\Middleware\SellerMiddleware;
use App\Http\Middleware\StoreVerifiedMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
            'seller' => SellerMiddleware::class,           // ✅ Diganti dengan SellerMiddleware
            'customer' => EnsureUserIsCustomer::class,
            'store.verified' => StoreVerifiedMiddleware::class, // ✅ Diganti dengan StoreVerifiedMiddleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();