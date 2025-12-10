<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;

class StoreIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $store = $request->user()->store;
        if ($store && $store->is_verified == 0) {
            return Redirect::route('store.create')->with('warning', 'Your store has not been verified by admin yet.');
        }
        return $next($request);
    }
}
