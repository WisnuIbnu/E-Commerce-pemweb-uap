@extends('layouts.app')

@section('title', 'Beranda - Tumbloo')

@section('content')
<div class="relative bg-tumbloo-offwhite overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/background.png') }}" alt="Background" class="w-full h-full object-cover opacity-30">
    </div>
    
    <!-- Content - Tombol tetap bisa diklik -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-tumbloo-black mb-6">
                GUDANGNYA TUMBLER!<br>
                <span class="text-tumbloo-accent-light">100% Original</span>
            </h1>
            <p class="text-xl text-tumbloo-gray-dark max-w-2xl mx-auto mb-8">
                Platform marketplace terpercaya untuk membeli dan menjual Tumbler terbaik di seluruh dunia.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/marketplace" class="bg-tumbloo-black hover:bg-tumbloo-dark text-tumbloo-white px-8 py-4 rounded-lg font-semibold transition">
                    Jelajahi Marketplace
                </a>
                <a href="/seller-guide" class="bg-tumbloo-white hover:bg-tumbloo-offwhite text-tumbloo-black border-2 border-tumbloo-gray-light px-8 py-4 rounded-lg font-semibold transition">
                    Jual Blog Kamu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection