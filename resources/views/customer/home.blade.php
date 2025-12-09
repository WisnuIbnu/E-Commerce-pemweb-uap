{{-- ============================================
     FILE: resources/views/customer/home.blade.php
     Homepage dengan product listing
     ============================================ --}}
@extends('layouts.app')

@section('title', 'Home - Shop Quality Products')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Welcome to DrizStuff</h1>
        <p>Discover amazing products from trusted sellers across Indonesia</p>

        <!-- Search Bar -->
        <div class="search-bar">
            <form action="{{ route('home') }}" method="GET" class="search-input-group">
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search for products, brands, or categories..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary search-btn">
                    🔍 Search
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Category Filters -->
<section class="container" style="margin-top: -30px; position: relative; z-index: 10;">
    <div class="category-filters">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
            <h3 style="margin: 0;">Browse by Category</h3>
            <span class="text-sm text-gray">{{ $categories->count() }} categories available</span>
        </div>
        <div class="category-pills">
            <a href="{{ route('home') }}"
                class="category-pill {{ !request('category') ? 'active' : '' }}">
                🏷️ All Products
            </a>
            @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->id]) }}"
                class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>
                    @if(request('search'))
                    Search Results for "{{ request('search') }}"
                    @elseif(request('category'))
                    {{ $categories->find(request('category'))->name ?? 'Products' }}
                    @else
                    Featured Products
                    @endif
                </h2>
                <p class="text-gray">
                    @if($products->total() > 0)
                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products
                    @else
                    No products found
                    @endif
                </p>
            </div>

            <!-- Sort Filter -->
            @if($products->count() > 0)
            <form action="{{ route('home') }}" method="GET" style="display: flex; align-items: center; gap: 8px;">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <label for="sort" style="font-size: 14px; color: var(--gray); white-space: nowrap;">Sort by:</label>
                <select name="sort" id="sort" class="form-control" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                </select>
            </form>
            @endif
        </div>

        @if($products->count() > 0)
        <!-- Product Grid -->
        <div class="product-grid">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <!-- Product Image -->
                <img
                    src="{{ $product->thumbnail_url }}"
                    alt="{{ $product->name }}"
                    class="product-image">

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-category">
                        {{ $product->productCategory->name }}
                    </div>

                    <h3 class="product-name" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>

                    <div class="product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="product-footer">
                        <div class="product-store">
                            <span>🏪</span>
                            <span>{{ Str::limit($product->store->name, 15) }}</span>
                        </div>

                        <div class="product-rating">
                            <span class="star">⭐</span>
                            <span>
                                @if($product->productReviews->count() > 0)
                                {{ number_format($product->productReviews->avg('rating'), 1) }}
                                <span class="text-xs text-gray">({{ $product->productReviews->count() }})</span>
                                @else
                                <span class="text-xs text-gray">No reviews</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Stock & Condition Badges -->
                    <div style="margin-top: 8px; display: flex; gap: 4px; flex-wrap: wrap;">
                        @if($product->stock > 0)
                        <span class="badge badge-success">
                            ✓ {{ $product->stock }} in stock
                        </span>
                        @if($product->condition === 'new')
                        <span class="badge badge-primary">🆕 New</span>
                        @else
                        <span class="badge badge-warning">📦 Second</span>
                        @endif
                        @else
                        <span class="badge badge-danger">✗ Out of Stock</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($products->onFirstPage())
            <span class="pagination-link" style="opacity: 0.5; cursor: not-allowed;">‹ Previous</span>
            @else
            <a href="{{ $products->appends(request()->query())->previousPageUrl() }}" class="pagination-link">‹ Previous</a>
            @endif

            {{-- Pagination Elements --}}
            @php
            $start = max($products->currentPage() - 2, 1);
            $end = min($start + 4, $products->lastPage());
            $start = max($end - 4, 1);
            @endphp

            @if($start > 1)
            <a href="{{ $products->appends(request()->query())->url(1) }}" class="pagination-link">1</a>
            @if($start > 2)
            <span class="pagination-link" style="opacity: 0.5; cursor: default;">...</span>
            @endif
            @endif

            @foreach(range($start, $end) as $page)
            @if($page == $products->currentPage())
            <span class="pagination-link active">{{ $page }}</span>
            @else
            <a href="{{ $products->appends(request()->query())->url($page) }}" class="pagination-link">{{ $page }}</a>
            @endif
            @endforeach

            @if($end < $products->lastPage())
                @if($end < $products->lastPage() - 1)
                    <span class="pagination-link" style="opacity: 0.5; cursor: default;">...</span>
                    @endif
                    <a href="{{ $products->appends(request()->query())->url($products->lastPage()) }}" class="pagination-link">{{ $products->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                    <a href="{{ $products->appends(request()->query())->nextPageUrl() }}" class="pagination-link">Next ›</a>
                    @else
                    <span class="pagination-link" style="opacity: 0.5; cursor: not-allowed;">Next ›</span>
                    @endif
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                @if(request('search'))
                🔍
                @else
                📦
                @endif
            </div>
            <h3>
                @if(request('search'))
                No Products Found
                @else
                No Products Available
                @endif
            </h3>
            <p class="text-gray">
                @if(request('search'))
                We couldn't find any products matching "<strong>{{ request('search') }}</strong>".<br>
                Try different keywords or browse our categories.
                @elseif(request('category'))
                This category doesn't have any products yet.<br>
                Check back soon or explore other categories!
                @else
                There are no products available at the moment.<br>
                Please check back later.
                @endif
            </p>
            @if(request('search') || request('category'))
            <a href="{{ route('home') }}" class="btn btn-primary mt-md">
                ← Browse All Products
            </a>
            @endif
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section style="background: var(--white); padding: var(--spacing-2xl) 0; margin-top: var(--spacing-xl);">
    <div class="container">
        <h2 class="text-center mb-xl">Why Shop at DrizStuff?</h2>

        <div class="grid grid-cols-4">
            <div class="text-center" style="padding: var(--spacing-md);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-md);">🚚</div>
                <h3 style="font-size: 18px; margin-bottom: 8px;">Fast Delivery</h3>
                <p class="text-gray text-sm">Quick and reliable shipping to your doorstep</p>
            </div>

            <div class="text-center" style="padding: var(--spacing-md);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-md);">🔒</div>
                <h3 style="font-size: 18px; margin-bottom: 8px;">Secure Payment</h3>
                <p class="text-gray text-sm">Your payment information is always safe</p>
            </div>

            <div class="text-center" style="padding: var(--spacing-md);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-md);">⭐</div>
                <h3 style="font-size: 18px; margin-bottom: 8px;">Quality Products</h3>
                <p class="text-gray text-sm">Only from verified and trusted sellers</p>
            </div>

            <div class="text-center" style="padding: var(--spacing-md);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-md);">💬</div>
                <h3 style="font-size: 18px; margin-bottom: 8px;">24/7 Support</h3>
                <p class="text-gray text-sm">We're always here to help you</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@guest
<section style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: var(--spacing-2xl) 0; color: var(--white);">
    <div class="container text-center">
        <h2 style="color: var(--white); margin-bottom: var(--spacing-md);">Want to Sell on DrizStuff?</h2>
        <p style="font-size: 18px; margin-bottom: var(--spacing-xl); opacity: 0.9;">
            Join thousands of sellers and start your online business today!
        </p>
        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
            🚀 Start Selling Now
        </a>
    </div>
</section>
@endguest
@endsection