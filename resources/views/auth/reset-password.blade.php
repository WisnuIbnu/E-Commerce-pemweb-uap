@extends('layouts.app')

@section('title', 'Reset Password - Tumbloo')

@section('content')
<div class="min-h-screen bg-tumbloo-dark py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-tumbloo-accent/20 rounded-full mb-4">
                <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-tumbloo-white">Reset Password Anda</h2>
            <p class="mt-2 text-sm text-tumbloo-gray">
                Masukkan email dan password baru Anda
            </p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-tumbloo-black rounded-lg shadow-xl p-8 border border-tumbloo-accent">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
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
                        Password Baru
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="Minimal 8 karakter"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-tumbloo-gray">
                        Password minimal 8 karakter, kombinasi huruf dan angka
                    </p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="Ulangi password baru"
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                >
                    Reset Password
                </button>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="mt-8 bg-tumbloo-black/50 border border-tumbloo-accent/30 rounded-lg p-4">
            <h4 class="text-sm font-medium text-tumbloo-white mb-3">Tips Keamanan Password:</h4>
            <ul class="space-y-2 text-xs text-tumbloo-gray">
                <li class="flex items-start">
                    <svg class="w-4 h-4 text-tumbloo-accent mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 text-tumbloo-accent mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Hindari menggunakan informasi pribadi yang mudah ditebak</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 text-tumbloo-accent mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Jangan gunakan password yang sama untuk akun lain</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection