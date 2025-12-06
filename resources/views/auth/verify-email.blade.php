@extends('layouts.app')

@section('title', 'Verifikasi Email - Tumbloo')

@section('content')
<div class="min-h-screen bg-tumbloo-dark py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-tumbloo-accent/20 rounded-full mb-4">
                <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-tumbloo-white">Verifikasi Email Anda</h2>
            <p class="mt-2 text-sm text-tumbloo-gray max-w-sm mx-auto">
                Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengklik link yang telah kami kirimkan.
            </p>
        </div>

        <!-- Verification Card -->
        <div class="bg-tumbloo-black rounded-lg shadow-xl p-8 border border-tumbloo-accent">
            <!-- Success Status -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-900/50 border border-green-500 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-green-200">
                            Link verifikasi baru telah dikirim ke email Anda!
                        </p>
                    </div>
                </div>
            @endif

            <!-- Email Info -->
            <div class="mb-6 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent/30">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-tumbloo-gray">Email dikirim ke:</p>
                        <p class="text-sm font-medium text-tumbloo-white">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mb-6">
                <h3 class="text-sm font-medium text-tumbloo-white mb-3">Langkah verifikasi:</h3>
                <ol class="space-y-2 text-sm text-tumbloo-gray">
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-tumbloo-accent/20 text-tumbloo-accent rounded-full flex items-center justify-center text-xs font-semibold mr-3">1</span>
                        <span>Buka email Anda dan cari email dari Tumbloo</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-tumbloo-accent/20 text-tumbloo-accent rounded-full flex items-center justify-center text-xs font-semibold mr-3">2</span>
                        <span>Klik link verifikasi di dalam email</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-tumbloo-accent/20 text-tumbloo-accent rounded-full flex items-center justify-center text-xs font-semibold mr-3">3</span>
                        <span>Anda akan diarahkan kembali ke dashboard</span>
                    </li>
                </ol>
            </div>

            <!-- Resend Form -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button 
                    type="submit"
                    class="w-full bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                >
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button 
                    type="submit"
                    class="w-full bg-tumbloo-dark hover:bg-tumbloo-accent/20 text-tumbloo-gray hover:text-tumbloo-white font-medium py-3 px-4 rounded-lg border border-tumbloo-accent transition duration-200"
                >
                    Logout
                </button>
            </form>
        </div>

        <!-- Help Info -->
        <div class="mt-8 bg-tumbloo-black/50 border border-tumbloo-accent/30 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-tumbloo-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-tumbloo-white mb-1">Tidak menerima email?</h4>
                    <ul class="space-y-1 text-xs text-tumbloo-gray">
                        <li>• Periksa folder spam atau junk email</li>
                        <li>• Pastikan email yang Anda daftarkan sudah benar</li>
                        <li>• Tunggu beberapa menit, terkadang email memerlukan waktu</li>
                        <li>• Hubungi <a href="{{ route('contact') }}" class="text-tumbloo-accent hover:text-tumbloo-accent-light">support kami</a> jika masih bermasalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection