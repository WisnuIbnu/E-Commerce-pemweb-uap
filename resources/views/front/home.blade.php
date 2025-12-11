@extends('layouts.front')

@section('title', 'Beranda')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <div class="relative mb-8 group rounded-3xl overflow-hidden shadow-lg shadow-indigo-100" x-data="{ activeSlide: 0 }">
        
        <div class="flex overflow-x-auto snap-x-mandatory hide-scroll bg-slate-900"
             x-ref="slider"
             @scroll.debounce.10ms="activeSlide = Math.round($el.scrollLeft / $el.clientWidth)">
            
            <div class="min-w-full snap-center h-[280px] md:h-[320px] relative flex items-center bg-slate-900">
                <div class="absolute inset-0 bg-gradient-to-r from-primary via-indigo-600 to-purple-600"></div>
                
                <div class="relative z-10 container mx-auto px-8 md:px-12 grid md:grid-cols-2 gap-8 items-center">
                    <div class="text-white space-y-4">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-bold uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> New Arrival
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                            Upgrade Gadget <br> Hemat Budget.
                        </h1>
                        <p class="text-indigo-100 text-xs md:text-sm font-medium max-w-md">
                            Marketplace jual beli gadget terpercaya khusus mahasiswa.
                        </p>
                        <div class="pt-1">
                            <a href="#katalog" class="inline-block px-7 py-3 bg-white text-primary text-sm font-bold rounded-full shadow-lg hover:bg-indigo-50 hover:text-primary-dark transition-colors duration-300">
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:flex justify-end relative opacity-90">
                        <i class="fa-solid fa-laptop-code text-8xl text-white/10 absolute top-0 right-0 transform -rotate-12 scale-150"></i>
                        <i class="fa-solid fa-mobile-screen-button text-7xl text-white/20 relative z-10 transform rotate-12"></i>
                    </div>
                </div>
            </div>

            <div class="min-w-full snap-center h-[280px] md:h-[320px] relative flex items-center bg-slate-800">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
                
                <div class="relative z-10 container mx-auto px-8 md:px-16 text-center">
                    <span class="text-amber-400 font-bold tracking-widest uppercase text-xs mb-2 block">Promo Semester Baru</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Cuci Gudang Buku & Alat Tulis</h1>
                    <p class="text-slate-400 text-xs md:text-sm mb-6 max-w-xl mx-auto">Dapatkan penawaran terbaik untuk perlengkapan kuliahmu.</p>
                    
                    <a href="#katalog" class="px-7 py-3 bg-amber-400 hover:bg-amber-300 text-slate-900 text-sm font-bold rounded-full transition-colors duration-300 shadow-lg">Lihat Promo</a>
                </div>
            </div>

        </div>
        
        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
            <button class="h-1.5 rounded-full transition-colors duration-300" :class="activeSlide === 0 ? 'w-6 bg-white' : 'w-1.5 bg-white/30'" @click="$refs.slider.scrollTo({ left: 0, behavior: 'smooth' })"></button>
            <button class="h-1.5 rounded-full transition-colors duration-300" :class="activeSlide === 1 ? 'w-6 bg-white' : 'w-1.5 bg-white/30'" @click="$refs.slider.scrollTo({ left: $refs.slider.clientWidth, behavior: 'smooth' })"></button>
        </div>
    </div>

    <div id="katalog" class="space-y-6">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Katalog Pilihan</h2>
                <p class="text-slate-500 text-xs font-medium mt-1">Temukan barang yang kamu butuhkan.</p>
            </div>
            
            <div class="flex gap-2 overflow-x-auto hide-scroll pb-1">
                <a href="{{ route('home') }}" 
                   class="px-6 py-2.5 rounded-full text-xs font-bold border transition-colors duration-200
                   {{ !request('category') 
                      ? 'bg-primary border-primary text-white shadow-md hover:bg-primary-dark' 
                      : 'bg-white border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                   Semua
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" 
                       class="px-6 py-2.5 rounded-full text-xs font-bold border transition-colors duration-200
                       {{ request('category') == $cat->slug 
                          ? 'bg-primary border-primary text-white shadow-md hover:bg-primary-dark' 
                          : 'bg-white border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                       {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <a href="{{ route('product.detail', $product->slug) }}" class="group">
                    <div class="bg-white rounded-2xl p-3 border border-slate-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary/20">
                        
                        <div class="aspect-square rounded-xl bg-slate-50 overflow-hidden relative mb-3">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            
                            <div class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur rounded-md border border-white/50 text-[10px] font-bold text-slate-700 shadow-sm">
                                {{ $product->store->name ?? 'Store' }}
                            </div>
                        </div>

                        <div class="px-1 pb-1">
                            <div class="text-[10px] font-bold text-primary uppercase tracking-wide mb-1">{{ $product->ProductCategory->name }}</div>
                            
                            <h3 class="font-semibold text-sm text-slate-900 leading-snug line-clamp-2 mb-2 group-hover:text-primary transition-colors">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center justify-between mt-auto">
                                <div class="font-extrabold text-base text-slate-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors duration-200">
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <div class="inline-flex bg-white p-3 rounded-full shadow-sm mb-3">
                        <i class="fa-solid fa-box-open text-2xl text-slate-300"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Belum ada produk</h3>
                    <p class="text-slate-500 text-xs mt-1">Coba cek kategori lain nanti ya.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection