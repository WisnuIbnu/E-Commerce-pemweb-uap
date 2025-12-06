@extends('layouts.app')

@section('title', 'Masuk - Tumbloo')

@section('content')
<div class="min-h-screen bg-tumbloo-dark py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-tumbloo-white">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-sm text-tumbloo-gray">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-tumbloo-offwhite hover:text-tumbloo-accent-light font-medium transition">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-tumbloo-black rounded-lg shadow-xl p-8 border border-tumbloo-accent">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-900/50 border border-green-500 rounded-lg text-green-200 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 bg-tumbloo-dark border-tumbloo-accent rounded text-tumbloo-accent focus:ring-tumbloo-accent-light focus:ring-2"
                        >
                        <span class="ml-2 text-sm text-tumbloo-gray">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-tumbloo-white hover:text-tumbloo-accent-light transition">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                >
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-tumbloo-accent"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-tumbloo-black text-tumbloo-gray">atau</span>
                </div>
            </div>

            <!-- Social Login (Optional) -->
            <div class="space-y-3">
                <button class="w-full bg-tumbloo-dark hover:bg-tumbloo-accent/20 text-tumbloo-white font-medium py-3 px-4 rounded-lg border border-tumbloo-accent transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Masuk dengan Google
                </button>
            </div>
        </div>

        <!-- Additional Info -->
        <p class="mt-8 text-center text-xs text-tumbloo-gray">
            Dengan masuk, Anda menyetujui
            <a href="{{ route('terms') }}" class="text-tumbloo-white hover:text-tumbloo-accent-light">Syarat & Ketentuan</a>
            dan
            <a href="{{ route('privacy') }}" class="text-tumbloo-white hover:text-tumbloo-accent-light">Kebijakan Privasi</a>
            kami.
        </p>
    </div>
</div>
@endsection