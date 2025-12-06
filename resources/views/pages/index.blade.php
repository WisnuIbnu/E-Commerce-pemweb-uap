@extends('layouts.app')

@section('title', 'Beranda - Tumbloo')

@section('content')
<div class="bg-tumbloo-offwhite">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-tumbloo-black mb-6">
                Jual Beli Blog Tumblr<br>
                <span class="text-tumbloo-accent-light">Aman & Terpercaya</span>
            </h1>
            <p class="text-xl text-tumbloo-gray-dark max-w-2xl mx-auto mb-8">
                Platform marketplace terpercaya untuk membeli dan menjual blog Tumblr dengan sistem escrow yang aman.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/categories" class="bg-tumbloo-black hover:bg-tumbloo-dark text-tumbloo-white px-8 py-4 rounded-lg font-semibold transition">
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