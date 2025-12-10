<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasStore
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role !== 'member') {
            return redirect()->route('home')
                ->with('error', 'Unauthorized access.');
        }

        if (!$user->store) {
            return redirect()->route('seller.register')
                ->with('error', 'Please register your store first!');
        }

        if (!$user->store->is_verified) {
            return redirect()->route('home')
                ->with('error', 'Your store is pending verification!');
        }

        return $next($request);
    }
}
