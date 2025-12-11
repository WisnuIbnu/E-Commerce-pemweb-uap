<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    // Regenerasi session
    $request->session()->regenerate();

    // Redirect ke dashboard berdasarkan role
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard'); // Redirect ke dashboard admin
    } elseif (Auth::user()->role === 'seller') {
        return redirect()->route('seller.dashboard'); // Redirect ke dashboard seller
    } else {
        return redirect()->route('dashboard'); // Redirect ke dashboard user
    }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
