@extends('layouts.app')

@section('title', 'Lupa Password - Tumbloo')

@section('content')
<div class="min-h-screen bg-tumbloo-dark py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-tumbloo-accent/20 rounded-full mb-4">
                <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-tumbloo-white">Lupa Password?</h2>
            <p class="mt-2 text-sm text-tumbloo-gray max-w-sm mx-auto">
                Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
            </p>
        </div>

        <!-- Forgot Password Form -->
        <div class="bg-tumbloo-black rounded-lg shadow-xl p-8 border border-tumbloo-accent">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-900/50 border border-green-500 rounded-lg text-green-200 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                >
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-tumbloo-accent hover:text-tumbloo-accent-light transition inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke halaman login
                </a>
            </div>
        </div>

        <!-- Help Info -->
        <div class="mt-8 bg-tumbloo-black/50 border border-tumbloo-accent/30 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-tumbloo-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-tumbloo-white mb-1">Tidak menerima email?</h4>
                    <p class="text-xs text-tumbloo-gray mb-2">
                        Periksa folder spam atau email yang Anda berikan. Jika masih bermasalah, hubungi tim support kami.
                    </p>
                    <a href="{{ route('contact') }}" class="text-xs text-tumbloo-accent hover:text-tumbloo-accent-light">
                        Hubungi Support →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection