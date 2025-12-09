<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // bawaan Laravel/Breeze
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // alias baru kita
            'role' => \App\Http\Middleware\RoleMiddleware::class,
             'admin' =>\App\Http\Middleware\AdminMiddleware::class,  // Tambahkan middleware admin
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

