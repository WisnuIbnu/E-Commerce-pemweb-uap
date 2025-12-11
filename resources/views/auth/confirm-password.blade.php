@extends('layouts.app')

@section('title', 'Konfirmasi Password - Tumbloo')

@section('content')
<div class="min-h-screen bg-tumbloo-dark py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-tumbloo-accent/20 rounded-full mb-4">
                <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-tumbloo-white">Area Aman</h2>
            <p class="mt-2 text-sm text-tumbloo-gray max-w-sm mx-auto">
                Ini adalah area yang dilindungi. Mohon konfirmasi password Anda untuk melanjutkan.
            </p>
        </div>

        <div class="bg-tumbloo-black rounded-lg shadow-xl p-8 border border-tumbloo-accent">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autofocus
                        autocomplete="current-password"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light focus:border-transparent transition"
                        placeholder="Masukkan password Anda"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                >
                    Konfirmasi
                </button>
            </form>
        </div>

        <div class="mt-8 bg-tumbloo-black/50 border border-tumbloo-accent/30 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-tumbloo-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-tumbloo-white mb-1">Mengapa saya perlu konfirmasi?</h4>
                    <p class="text-xs text-tumbloo-gray">
                        Untuk keamanan ekstra, kami meminta Anda mengkonfirmasi password sebelum mengakses informasi sensitif atau melakukan perubahan penting pada akun Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection