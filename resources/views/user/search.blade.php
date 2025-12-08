@extends('layouts.app')

@section('title', 'Hasil Pencarian - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-tumbloo-white mb-2">
                Hasil Pencarian untuk "{{ $query }}"
            </h1>
            <p class="text-tumbloo-gray">Ditemukan {{ $products->total() }} produk</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="mb-8">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $query }}"
                    placeholder="Cari tumbler..." 
                    class="flex-1 px-6 py-4 bg-tumbloo-black border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light"
                >
                <button type="submit" class="px-8 py-4 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        @if($products->isEmpty())
            <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-tumbloo-white mb-2">Tidak Ada Hasil</h2>
                <p class="text-tumbloo-gray mb-6">Tidak ditemukan produk untuk "{{ $query }}"</p>
                <div class="space-y-2 text-sm text-tumbloo-gray mb-6">
                    <p>Saran:</p>
                    <ul class="list-disc list-inside">
                        <li>Periksa ejaan kata kunci Anda</li>
                        <li>Coba gunakan kata kunci yang lebih umum</li>
                        <li>Coba gunakan kata kunci yang berbeda</li>
                    </ul>
                </div>
                <a href="{{ route('home') }}" class="inline-block bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-6 rounded-lg transition">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group">
                        <div class="bg-tumbloo-black rounded-lg overflow-hidden border border-tumbloo-accent hover:border-tumbloo-accent-light transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Product Image -->
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
                                
                                <!-- Stock Badge -->
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

                            <!-- Product Info -->
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

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection