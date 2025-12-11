<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
<<<<<<< HEAD
            'isadmin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        $middleware->alias([
            'is_admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
=======
            'store.verified' => \App\Http\Middleware\StoreIsVerified::class,
>>>>>>> 248a66fdfc86b0ed23ff66b8e186e1e5f0defc26
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
