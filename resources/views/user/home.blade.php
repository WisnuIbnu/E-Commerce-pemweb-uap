@extends('layouts.app')

@section('title', 'Marketplace - Tumbloo')

@section('content')
<!-- Hero Section -->
<div class="relative border-b border-tumbloo-accent w-full">
    
    <!-- Background (punya opacity sendiri) -->
    <div 
        class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
        style="background-image: url('{{ asset('images/background.png') }}');">
    </div>

    <!-- Overlay isi (tidak transparan) -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-tumbloo-black mb-4">
                Temukan Tumbler Berkualitas
            </h1>
            <p class="text-lg text-tumbloo-gray mb-8 max-w-2xl mx-auto">
                Marketplace terpercaya untuk membeli dan menjual tumbler terbaik
            </p>

            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}"
                        placeholder="Cari tumbler..." 
                        class="flex-1 px-6 py-4 bg-tumbloo-dark border border-tumbloo-accent 
                               rounded-lg text-tumbloo-white placeholder-tumbloo-gray 
                               focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light">
                    
                    <button type="submit" 
                        class="px-8 py-4 bg-tumbloo-accent hover:bg-tumbloo-accent-light 
                               text-white font-semibold rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Categories Filter -->
<div class="bg-tumbloo-dark border-b border-tumbloo-accent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center gap-4 overflow-x-auto">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap {{ !request('category') ? 'bg-tumbloo-accent text-white' : 'bg-tumbloo-black text-tumbloo-gray hover:text-tumbloo-white' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap {{ request('category') == $category->id ? 'bg-tumbloo-accent text-white' : 'bg-tumbloo-black text-tumbloo-gray hover:text-tumbloo-white' }}">
                    {{ $category->name }}
                </a>
            @endforeach
            <a href="{{ route('categories') }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium bg-tumbloo-black text-tumbloo-offwhite hover:text-tumbloo-accent-light transition whitespace-nowrap">
                Lihat Semua →
            </a>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($products->isEmpty())
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-tumbloo-white mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-tumbloo-gray">Coba kata kunci atau kategori lain</p>
            </div>
        @else
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
                                @if($product->stock < 5)
                                    <div class="absolute top-2 left-2 px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded">
                                        Stok Terbatas
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
                                        <div class="text-blue-900 font-bold text-lg">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-tumbloo-gray">Stok: {{ $product->stock }}</div>
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
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection