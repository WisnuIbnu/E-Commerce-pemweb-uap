@extends('layouts.app')

@section('title', 'Kategori Produk - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-tumbloo-white mb-4">Kategori Produk</h1>
            <p class="text-lg text-tumbloo-gray">Temukan produk berdasarkan kategori yang Anda inginkan</p>
        </div>

        @if($categories->isEmpty())
            <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-tumbloo-white mb-2">Belum Ada Kategori</h2>
                <p class="text-tumbloo-gray">Kategori produk belum tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('category', $category->slug) }}" class="group">
                        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition-all duration-300 transform hover:-translate-y-1 p-6">
                            <!-- Category Icon -->
                            <div class="w-16 h-16 bg-tumbloo-accent/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-tumbloo-accent/30 transition">
                                <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-tumbloo-white mb-2 group-hover:text-tumbloo-accent transition">
                                {{ $category->name }}
                            </h3>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-tumbloo-gray">
                                    {{ $category->products_count }} Produk
                                </span>
                                <svg class="w-5 h-5 text-tumbloo-accent group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-tumbloo-accent hover:text-tumbloo-accent-light transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection