<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedStore
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please login first');
        }

        // Check if user has a store
        if (!$user->store) {
            return redirect()->route('seller.register')
                ->with('error', 'Please register your store first to access seller features.');
        }

        // Check if store is verified
        if (!$user->store->is_verified) {
            return redirect()->route('dashboard')
                ->with('warning', 'Your store is pending verification. Please wait for admin approval.');
        }

        return $next($request);
    }
}