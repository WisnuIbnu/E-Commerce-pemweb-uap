<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoreVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->store || !$user->store->is_verified) {
            // If the request is not for the dashboard or store profile, redirect to dashboard
            if (!$request->routeIs('seller.dashboard') && !$request->routeIs('seller.store.*')) {
                 return redirect()->route('seller.dashboard');
            }
        }

        return $next($request);
    }
}
