@extends('layouts.buyer')

@section('title', 'Selamat Datang - WALKUNO')

@section('content')

<!-- Hero Section - Dark Theme - Compact when search active -->
<section class="relative {{ request('search') || request('category') ? 'min-h-[60vh]' : 'min-h-screen' }} bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#0f172a] flex items-center justify-center overflow-hidden">
    <!-- Animated Background Glow -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-1/4 w-96 h-96 bg-[#60A5FA] rounded-full filter blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-20 right-1/4 w-96 h-96 bg-[#93C5FD] rounded-full filter blur-[120px] animate-pulse delay-1000"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center z-10 py-20">
        <!-- Welcome Text -->
        <div class="mb-8 animate-fade-in">
            <h1 class="font-heading font-black text-5xl sm:text-6xl md:text-7xl lg:text-8xl uppercase tracking-tighter leading-[0.85] mb-6">
                <span class="text-white">Selamat Datang</span><br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#60A5FA] via-[#93C5FD] to-[#60A5FA]">di WalkUno</span>
            </h1>
            <p class="text-[#93C5FD] text-base md:text-lg lg:text-xl max-w-2xl mx-auto font-medium">
                Elevate your game with premium sports equipment. Built for champions, designed for the future.
            </p>
        </div>

        <!-- Search Results Indicator -->
        @if(request('search') || request('category') || request('min_price') || request('max_price'))
            <div class="mb-8 animate-fade-in delay-150">
                <div class="bg-[#1e293b] border-2 border-[#60A5FA] rounded-2xl p-6 md:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="font-heading font-black text-lg md:text-xl text-white uppercase tracking-wide mb-2">
                                🔍 Search Results
                            </h3>
                            <div class="flex flex-wrap gap-2 text-sm">
                                @if(request('search'))
                                    <span class="inline-flex items-center gap-2 bg-[#60A5FA] text-white px-4 py-2 rounded-full font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        "{{ request('search') }}"
                                    </span>
                                @endif
                                @if(request('category'))
                                    <span class="inline-flex items-center gap-2 bg-[#93C5FD] text-[#1E3A8A] px-4 py-2 rounded-full font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ request('category') }}
                                    </span>
                                @endif
                                @if(request('min_price') || request('max_price'))
                                    <span class="inline-flex items-center gap-2 bg-[#93C5FD] text-[#1E3A8A] px-4 py-2 rounded-full font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ request('min_price') ? 'Rp ' . number_format(request('min_price'), 0, ',', '.') : '' }}
                                        {{ request('min_price') && request('max_price') ? ' - ' : '' }}
                                        {{ request('max_price') ? 'Rp ' . number_format(request('max_price'), 0, ',', '.') : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl md:text-3xl font-black text-[#60A5FA]">{{ $products->total() }}</p>
                            <p class="text-xs md:text-sm text-slate-400 uppercase tracking-wide">Products Found</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 text-[#93C5FD] hover:text-white text-sm font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endif

        <!-- Categories Section -->
        <div class="mb-12 text-left animate-fade-in delay-200">
            <h2 class="font-heading font-black text-xl md:text-2xl uppercase tracking-widest text-white border-l-4 border-[#60A5FA] pl-6 inline-block">
                Categories
            </h2>
        </div>

        <!-- Categories Grid - FlexSport Style -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4 max-w-7xl mx-auto animate-fade-in delay-300">
            <!-- All Items -->
            <a href="{{ route('home') }}" 
               class="group flex flex-col items-center justify-center h-32 md:h-36 rounded-2xl md:rounded-3xl border-2 transition-all duration-300 {{ !request('category') ? 'bg-[#1e293b] border-[#60A5FA] shadow-lg shadow-[#60A5FA]/20' : 'bg-[#1a2332] border-[#334155] hover:border-[#60A5FA] hover:shadow-lg hover:shadow-[#60A5FA]/20' }}">
                <div class="mb-2 {{ !request('category') ? 'text-[#60A5FA]' : 'text-[#93C5FD] group-hover:text-[#60A5FA]' }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </div>
                <span class="font-bold text-xs md:text-sm uppercase tracking-wide {{ !request('category') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}">All Items</span>
            </a>

            @foreach(['Sneakers', 'Running Shoes', 'Loafers', 'Boots', 'Sandals'] as $cat)
            <a href="{{ route('home', ['category' => $cat]) }}" 
               class="group flex flex-col items-center justify-center h-32 md:h-36 rounded-2xl md:rounded-3xl border-2 transition-all duration-300 {{ request('category') == $cat ? 'bg-[#1e293b] border-[#60A5FA] shadow-lg shadow-[#60A5FA]/20' : 'bg-[#1a2332] border-[#334155] hover:border-[#60A5FA] hover:shadow-lg hover:shadow-[#60A5FA]/20' }}">
                <div class="mb-2 {{ request('category') == $cat ? 'text-[#60A5FA]' : 'text-[#93C5FD] group-hover:text-[#60A5FA]' }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="font-bold text-xs md:text-sm uppercase tracking-wide {{ request('category') == $cat ? 'text-white' : 'text-slate-400 group-hover:text-white' }}">{{ $cat }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@if(request('search') || request('category') || request('min_price') || request('max_price'))
    {{-- Show All Products FIRST when filtering/searching --}}
    
    <!-- All Products - Search Results - Dark Theme -->
    <section id="search-results" class="py-16 md:py-20 bg-gradient-to-br from-[#1e293b] via-[#0f172a] to-[#1e293b]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8 md:mb-10">
                <div>
                    <h2 class="font-heading font-black text-3xl md:text-4xl uppercase tracking-tighter text-white">Search Results</h2>
                    <p class="text-[#93C5FD] mt-2">Found {{ $products->total() }} products matching your search</p>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Grid Layout for Search Results -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6 mb-8">
                    @foreach($products as $product)
                    <div class="group">
                        <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] rounded-2xl md:rounded-3xl p-4 border-2 border-[#334155] hover:border-[#93C5FD] transition-all duration-300 hover:shadow-xl hover:shadow-[#93C5FD]/20">
                            <div class="relative bg-[#0a0f1a] rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] mb-4">
                                @if($product->stock < 5)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">Low Stock</span>
                                @else
                                    <span class="absolute top-3 left-3 bg-gradient-to-r from-[#1E3A8A] to-[#60A5FA] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">New</span>
                                @endif
                                
                                @if($product->images && $product->images->count() > 0)
                                    <img src="{{ Str::startsWith($product->images->first()->image, 'http') ? $product->images->first()->image : asset('storage/' . $product->images->first()->image) }}" 
                                         alt="{{ $product->name }}"
                                         onerror="this.src='https://placehold.co/400x500/0f172a/60A5FA?text={{ urlencode($product->name) }}'"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#0a0f1a]">
                                        <svg class="w-16 h-16 text-[#60A5FA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="px-2">
                                <p class="text-[10px] font-bold text-[#60A5FA] uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                                <h3 class="font-heading font-bold text-lg md:text-xl text-white leading-tight mb-3 line-clamp-2">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-lg text-[#93C5FD]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-[#60A5FA] hover:bg-[#93C5FD] text-white text-xs font-bold uppercase rounded-lg transition-colors shadow-lg">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-[#1a2332] rounded-3xl border-2 border-[#334155]">
                    <p class="text-slate-400 text-lg mb-6">No products found</p>
                    <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] hover:from-[#93C5FD] hover:to-[#60A5FA] text-white font-bold uppercase tracking-wider text-sm rounded-full transition-all shadow-lg">
                        View All
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Best Seller Products - Dark Theme -->
    <section id="bestseller" class="py-16 md:py-20 bg-[#0f172a]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8 md:mb-10">
                <div>
                    <h2 class="font-heading font-black text-3xl md:text-4xl uppercase tracking-tighter text-white">Best Sellers</h2>
                    <p class="text-[#93C5FD] mt-2">Top picks from our collection</p>
                </div>
                <div class="hidden md:block w-32 h-1 bg-[#60A5FA] rounded-full"></div>
            </div>

            <!-- Horizontal Scroll Container -->
            <div class="relative">
                <div class="flex gap-4 md:gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
                    @foreach(App\Models\Product::with('images', 'category')->inRandomOrder()->take(8)->get() as $product)
                    <div class="flex-none w-64 md:w-72 snap-start group">
                        <div class="bg-gradient-to-br from-[#1e293b] to-[#1a2332] rounded-2xl md:rounded-3xl p-4 border-2 border-[#334155] hover:border-[#60A5FA] transition-all duration-300 hover:shadow-xl hover:shadow-[#60A5FA]/20">
                            <!-- Image -->
                            <div class="relative bg-[#0f172a] rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] mb-4">
                                <span class="absolute top-3 left-3 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">Best Seller</span>
                                
                                @if($product->images && $product->images->count() > 0)
                                    <img src="{{ Str::startsWith($product->images->first()->image, 'http') ? $product->images->first()->image : asset('storage/' . $product->images->first()->image) }}" 
                                         alt="{{ $product->name }}"
                                         onerror="this.src='https://placehold.co/400x500/1e293b/93C5FD?text={{ urlencode($product->name) }}'"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#1e293b]">
                                        <svg class="w-16 h-16 text-[#93C5FD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="px-2">
                                <p class="text-[10px] font-bold text-[#93C5FD] uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                                <h3 class="font-heading font-bold text-lg md:text-xl text-white leading-tight mb-3 line-clamp-2">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-lg text-[#60A5FA]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] hover:from-[#93C5FD] hover:to-[#60A5FA] text-white text-xs font-bold uppercase rounded-lg transition-all shadow-lg">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@else
    {{-- Normal order when NO search/filter: Best Sellers FIRST, then All Products --}}

<!-- Best Seller Products - Dark Theme -->
<section id="bestseller" class="py-16 md:py-20 bg-[#0f172a]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 md:mb-10">
            <div>
                <h2 class="font-heading font-black text-3xl md:text-4xl uppercase tracking-tighter text-white">Best Sellers</h2>
                <p class="text-[#93C5FD] mt-2">Top picks from our collection</p>
            </div>
            <div class="hidden md:block w-32 h-1 bg-[#60A5FA] rounded-full"></div>
        </div>

        <!-- Horizontal Scroll Container -->
        <div class="relative">
            <div class="flex gap-4 md:gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
                @foreach(App\Models\Product::with('images', 'category')->inRandomOrder()->take(8)->get() as $product)
                <div class="flex-none w-64 md:w-72 snap-start group">
                    <div class="bg-gradient-to-br from-[#1e293b] to-[#1a2332] rounded-2xl md:rounded-3xl p-4 border-2 border-[#334155] hover:border-[#60A5FA] transition-all duration-300 hover:shadow-xl hover:shadow-[#60A5FA]/20">
                        <!-- Image -->
                        <div class="relative bg-[#0f172a] rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] mb-4">
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">Best Seller</span>
                            
                            @if($product->images && $product->images->count() > 0)
                                <img src="{{ Str::startsWith($product->images->first()->image, 'http') ? $product->images->first()->image : asset('storage/' . $product->images->first()->image) }}" 
                                     alt="{{ $product->name }}"
                                     onerror="this.src='https://placehold.co/400x500/1e293b/93C5FD?text={{ urlencode($product->name) }}'"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#1e293b]">
                                    <svg class="w-16 h-16 text-[#93C5FD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Info -->
                        <div class="px-2">
                            <p class="text-[10px] font-bold text-[#93C5FD] uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                            <h3 class="font-heading font-bold text-lg md:text-xl text-white leading-tight mb-3 line-clamp-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-lg text-[#60A5FA]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] hover:from-[#93C5FD] hover:to-[#60A5FA] text-white text-xs font-bold uppercase rounded-lg transition-all shadow-lg">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- All Products - Dark Theme -->
<section class="py-16 md:py-20 bg-gradient-to-br from-[#1e293b] via-[#0f172a] to-[#1e293b]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 md:mb-10">
            <div>
                <h2 class="font-heading font-black text-3xl md:text-4xl uppercase tracking-tighter text-white">All Products</h2>
                <p class="text-[#93C5FD] mt-2">Discover our complete collection</p>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- Horizontal Scroll Container -->
            <div class="flex gap-4 md:gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide mb-8">
                @foreach($products as $product)
                <div class="flex-none w-64 md:w-72 snap-start group">
                    <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] rounded-2xl md:rounded-3xl p-4 border-2 border-[#334155] hover:border-[#93C5FD] transition-all duration-300 hover:shadow-xl hover:shadow-[#93C5FD]/20">
                        <div class="relative bg-[#0a0f1a] rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] mb-4">
                            @if($product->stock < 5)
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">Low Stock</span>
                            @else
                                <span class="absolute top-3 left-3 bg-gradient-to-r from-[#1E3A8A] to-[#60A5FA] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider z-10 shadow-lg">New</span>
                            @endif
                            
                            @if($product->images && $product->images->count() > 0)
                                <img src="{{ Str::startsWith($product->images->first()->image, 'http') ? $product->images->first()->image : asset('storage/' . $product->images->first()->image) }}" 
                                     alt="{{ $product->name }}"
                                     onerror="this.src='https://placehold.co/400x500/0f172a/60A5FA?text={{ urlencode($product->name) }}'"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#0a0f1a]">
                                    <svg class="w-16 h-16 text-[#60A5FA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="px-2">
                            <p class="text-[10px] font-bold text-[#60A5FA] uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                            <h3 class="font-heading font-bold text-lg md:text-xl text-white leading-tight mb-3 line-clamp-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-lg text-[#93C5FD]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-[#60A5FA] hover:bg-[#93C5FD] text-white text-xs font-bold uppercase rounded-lg transition-colors shadow-lg">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-[#1a2332] rounded-3xl border-2 border-[#334155]">
                <p class="text-slate-400 text-lg mb-6">No products found</p>
                <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-[#60A5FA] to-[#93C5FD] hover:from-[#93C5FD] hover:to-[#60A5FA] text-white font-bold uppercase tracking-wider text-sm rounded-full transition-all shadow-lg">
                    View All
                </a>
            </div>
        @endif
    </div>
</section>

@endif

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 1s ease-out; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
</style>
@endsection
