@extends('layouts.app')

@section('title', 'Home - Premium Tumbler Marketplace')

@section('content')
<div class="container-custom">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-tumbloo-black to-tumbloo-dark rounded-2xl p-12 mb-12 text-center shadow-elegant-lg">
        <h1 class="text-5xl font-bold text-tumbloo-white mb-4">
            Discover Premium Tumblers
        </h1>
        <p class="text-xl text-tumbloo-gray-light mb-8">
            Find unique, high-quality drinkware from verified sellers
        </p>
        <a href="{{ route('categories') }}" class="btn-secondary inline-block">
            Browse Categories
        </a>
    </div>

    <!-- Categories Filter -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-tumbloo-black">Shop by Category</h2>
            <a href="{{ route('categories') }}" class="text-tumbloo-gray hover:text-tumbloo-black font-medium">
                View All →
            </a>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('home') }}" 
               class="px-5 py-2 rounded-full font-semibold transition-all
                      {{ !request('category') ? 'bg-tumbloo-black text-tumbloo-white' : 'bg-tumbloo-white text-tumbloo-black border-2 border-tumbloo-black hover:bg-tumbloo-black hover:text-tumbloo-white' }}">
                All Products
            </a>
            @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->id]) }}" 
               class="px-5 py-2 rounded-full font-semibold transition-all
                      {{ request('category') == $category->id ? 'bg-tumbloo-black text-tumbloo-white' : 'bg-tumbloo-white text-tumbloo-black border-2 border-tumbloo-black hover:bg-tumbloo-black hover:text-tumbloo-white' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-tumbloo-black">
                @if(request('category'))
                    {{ $categories->find(request('category'))->name ?? 'Products' }}
                @else
                    All Products
                @endif
            </h2>
            <p class="text-tumbloo-gray font-medium">
                {{ $products->total() }} products found
            </p>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-tumbloo-gray-light mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-2xl font-bold text-tumbloo-black mb-2">No Products Found</h3>
            <p class="text-tumbloo-gray mb-6">Try adjusting your filters or browse all categories</p>
            <a href="{{ route('home') }}" class="btn-primary">
                View All Products
            </a>
        </div>
        @endif
    </div>

    <!-- Why Choose Us -->
    <div class="bg-tumbloo-off-white rounded-2xl p-12 mb-12">
        <h2 class="text-3xl font-bold text-center text-tumbloo-black mb-12">Why Choose Tumbloo?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-tumbloo-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-tumbloo-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-tumbloo-black mb-2">Verified Sellers</h3>
                <p class="text-tumbloo-gray">All sellers are verified to ensure quality and trust</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-tumbloo-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-tumbloo-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-tumbloo-black mb-2">Secure Payments</h3>
                <p class="text-tumbloo-gray">Your transactions are safe and protected</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-tumbloo-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-tumbloo-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-tumbloo-black mb-2">Premium Quality</h3>
                <p class="text-tumbloo-gray">High-quality tumblers from trusted brands</p>
            </div>
        </div>
    </div>

</div>
@endsection