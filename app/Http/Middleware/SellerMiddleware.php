<?php
// app/Http/Middleware/SellerMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has a store
        if (!$user->store) {
            return redirect()->route('seller.register')
                ->with('error', 'You need to register a store first.');
        }

        // Check store status
        if ($user->store->isPending()) {
            return redirect()->route('seller.register')
                ->with('info', 'Your store registration is pending approval.');
        }

        if ($user->store->isRejected()) {
            return redirect()->route('seller.register')
                ->with('error', 'Your store registration was rejected. Please submit a new application.');
        }

        if (!$user->store->isApproved()) {
            abort(403, 'Store not approved');
        }

        return $next($request);
    }
}

// REGISTER THIS MIDDLEWARE IN app/Http/Kernel.php
// protected $middlewareAliases = [
//     ...
//     'seller' => \App\Http\Middleware\SellerMiddleware::class,
// ];
