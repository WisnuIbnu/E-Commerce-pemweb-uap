<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }
    
    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $remember = $request->has('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard')
                    ->with('success', 'Welcome back, Admin!');
            } elseif ($user->role === 'seller') {
                // Check if seller has store
                if (!$user->store) {
                    return redirect('/seller/store/register')
                        ->with('info', 'Please complete your store registration.');
                }
                return redirect('/seller/dashboard')
                    ->with('success', 'Welcome back to your store!');
            } else {
                // Buyer - create buyer profile if not exists
                if (!$user->buyer) {
                    \App\Models\Buyer::create(['user_id' => $user->id]);
                }
                return redirect('/')
                    ->with('success', 'Welcome back!');
            }
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    // Show register form
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }
    
    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:buyer,seller',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
        
        // Don't auto login, redirect to login page
        return redirect('/login')
            ->with('success', 'Account created successfully! Please login to continue.');
    }
    
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'You have been logged out successfully.');
    }
}