<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureBuyerProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // kalau belum punya buyer, arahkan ke form profil buyer
        if (! $user->buyer) {
            return redirect()
                ->route('buyer.profile.create') // sesuaikan dengan route-mu
                ->with('info', 'Silakan lengkapi profil pembeli terlebih dahulu.');
        }

        return $next($request);
    }
}
