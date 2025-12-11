<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Store;

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
    // proses login bawaan Breeze
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user(); // atau $request->user();

    // ==== Redirect sesuai role ====

    // ADMIN
    if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
        $default = route(name: 'admin.dashboard', absolute: false);

    // SELLER
    } elseif ($user->role === 'seller') {

        // cek apakah seller sudah punya toko
        $store = Store::where('user_id', $user->id)->first();

        if ($store) {
            // sudah punya toko -> ke dashboard seller
            $default = route(name: 'seller.dashboard', absolute: false);
        } else {
            // belum punya toko -> wajib isi form dulu
            $default = route(name: 'seller.form', absolute: false);
        }

    // BUYER (atau role lain)
    } else {
        $default = route(name: 'dashboard', absolute: false);
    }

    return redirect()->intended($default);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
