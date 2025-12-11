@extends('layouts.app')

@section('title', 'Marketplace - Tumbloo')

@section('content')
<div class="relative border-b border-tumbloo-accent w-full">
    
    <div 
        class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
        style="background-image: url('{{ asset('images/background.png') }}');">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-tumbloo-black mb-4">
                Marketplace Tumbler
            </h1>
            <p class="text-lg text-tumbloo-gray font-semibold mb-8 max-w-2xl mx-auto">
                Marketplace terpercaya untuk membeli dan menjual tumbler terbaik
            </p>

            <div class="flex justify-center gap-8 mt-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-tumbloo-accent">{{ $categories->count() }}</div>
                    <div class="text-sm text-tumbloo-gray">Brand Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-tumbloo-accent">{{ $categories->sum('products_count') }}+</div>
                    <div class="text-sm text-tumbloo-gray">Produk Aktif</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-tumbloo-white mb-4">Brand Tumbler Terbaik</h2>
            <p class="text-tumbloo-gray">Pilih brand favorit Anda dan temukan produk terbaik</p>
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-tumbloo-white mb-2">Belum Ada Kategori</h3>
                <p class="text-tumbloo-gray">Kategori produk akan segera tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="group">
                        <div class="bg-tumbloo-black rounded-xl overflow-hidden border border-tumbloo-accent hover:border-tumbloo-accent-light transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-tumbloo-accent/20">
                            
                            <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-tumbloo-dark to-tumbloo-black">
                                @if($category->image && file_exists(public_path($category->image)))
                                    <img src="{{ asset($category->image) }}" 
                                         alt="{{ $category->name }}"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><div class=\'text-center\'><svg class=\'w-20 h-20 mx-auto text-tumbloo-accent mb-3\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\'></path></svg><div class=\'text-4xl font-bold text-tumbloo-accent\'>{{ substr($category->name, 0, 1) }}</div></div></div>';"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-20 h-20 mx-auto text-tumbloo-accent mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <div class="text-4xl font-bold text-tumbloo-accent">{{ substr($category->name, 0, 1) }}</div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-tumbloo-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-tumbloo-white mb-2 group-hover:text-tumbloo-accent transition">
                                    {{ $category->name }}
                                </h3>
                                
                                @if($category->tagline)
                                    <p class="text-sm text-tumbloo-gray mb-3 line-clamp-2">
                                        {{ $category->tagline }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-tumbloo-gray text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span>{{ $category->products_count }} Produk</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-1 text-blue-400 font-semibold text-sm group-hover:gap-2 transition-all">
                                        <span>Lihat</span>
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>

                                @if($category->description)
                                    <div class="mt-4 pt-4 border-t border-tumbloo-accent/30">
                                        <p class="text-xs text-tumbloo-gray line-clamp-2">
                                            {{ Str::limit($category->description, 80) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-16 bg-gradient-to-r from-tumbloo-accent to-tumbloo-accent-light rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-3">Tidak Menemukan Brand Favorit?</h3>
            <p class="text-white/80 mb-6 max-w-2xl mx-auto">
                Kami terus menambahkan brand dan produk baru setiap minggu. Pantau terus marketplace kami!
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-white text-tumbloo-accent font-semibold rounded-lg hover:bg-tumbloo-offwhite transition">
                    Lihat Semua Produk
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-3 bg-tumbloo-black/30 text-white font-semibold rounded-lg hover:bg-tumbloo-black/50 transition border border-white/30">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection