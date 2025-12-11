@extends('layouts.app')

@section('title', $category->name . ' - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-8 flex items-center gap-2 text-sm text-tumbloo-gray">
            <a href="{{ route('home') }}" class="hover:text-tumbloo-white">Home</a>
            <span>›</span>
            <a href="{{ route('categories') }}" class="hover:text-tumbloo-white">Kategori</a>
            <span>›</span>
            <span class="text-tumbloo-white">{{ $category->name }}</span>
        </nav>

        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-8 mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-tumbloo-accent/20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-tumbloo-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-tumbloo-white">{{ $category->name }}</h1>
                    <p class="text-tumbloo-gray">{{ $products->total() }} produk tersedia</p>
                </div>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h2 class="text-2xl font-bold text-tumbloo-white mb-2">Belum Ada Produk</h2>
                <p class="text-tumbloo-gray mb-6">Belum ada produk di kategori ini</p>
                <a href="{{ route('home') }}" class="inline-block bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-6 rounded-lg transition">
                    Lihat Semua Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group">
                        <div class="bg-tumbloo-black rounded-lg overflow-hidden border border-tumbloo-accent hover:border-tumbloo-accent-light transition-all duration-300 transform hover:-translate-y-1">

                            <div class="relative aspect-square overflow-hidden bg-tumbloo-dark">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ asset($product->images->first()->image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($product->stock < 5 && $product->stock > 0)
                                    <div class="absolute top-2 left-2 px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded">
                                        Stok Terbatas
                                    </div>
                                @elseif($product->stock == 0)
                                    <div class="absolute top-2 left-2 px-2 py-1 bg-gray-500 text-white text-xs font-semibold rounded">
                                        Stok Habis
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="text-xs text-tumbloo-gray mb-1">{{ $product->store->name }}</div>
                                <h3 class="text-tumbloo-white font-semibold mb-2 line-clamp-2 group-hover:text-tumbloo-accent transition">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-tumbloo-accent font-bold text-lg">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-tumbloo-gray">
                                            @if($product->stock > 0)
                                                Stok: {{ $product->stock }}
                                            @else
                                                Habis
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($product->reviews_count > 0)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-xs text-tumbloo-gray">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-12">
            <a href="{{ route('home.categories') }}" class="inline-flex items-center gap-2 text-tumbloo-accent hover:text-tumbloo-accent-light transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Semua Kategori
            </a>
        </div>
    </div>
</div>
@endsection