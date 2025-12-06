@extends('layouts.app')

@section('title', 'Products - SORAE')

@section('styles')
<style>
    .filter-sidebar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
    }
    
    .filter-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--secondary-color);
    }
    
    .category-filter {
        list-style: none;
        padding: 0;
    }
    
    .category-filter li {
        margin-bottom: 12px;
    }
    
    .category-filter a {
        color: var(--text-dark);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .category-filter a:hover,
    .category-filter a.active {
        background: var(--secondary-color);
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .products-header {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .sort-select {
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        padding: 8px 15px;
        font-weight: 600;
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Filter Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="filter-sidebar">
            <h3 class="filter-title">
                <i class="fas fa-filter"></i> Filters
            </h3>
            
            <!-- Search -->
            <form action="{{ url('/products') }}" method="GET" class="mb-4">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Search products..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Categories -->
            <h5 class="fw-bold mb-3">Categories</h5>
            <ul class="category-filter">
                <li>
                    <a href="{{ url('/products') }}" 
                       class="{{ !request('category') ? 'active' : '' }}">
                        <span>All Products</span>
                        <span class="badge bg-secondary">{{ $products->total() }}</span>
                    </a>
                </li>
                @foreach($categories as $category)
                <li>
                    <a href="{{ url('/products?category=' . $category->id) }}" 
                       class="{{ request('category') == $category->id ? 'active' : '' }}">
                        <span>{{ $category->name }}</span>
                        <span class="badge bg-secondary">{{ $category->products_count }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <!-- Products Grid -->
    <div class="col-lg-9">
        <!-- Header -->
        <div class="products-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-0" style="color: var(--primary-color); font-weight: 700;">
                        Products
                        @if(request('category'))
                            <small class="text-muted">in {{ $categories->find(request('category'))->name ?? '' }}</small>
                        @endif
                    </h2>
                    <p class="text-muted mb-0">Found {{ $products->total() }} products</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <form action="{{ url('/products') }}" method="GET" class="d-inline">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="sort" class="sort-select" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products -->
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    @if($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" 
                             alt="{{ $product->name }}" class="product-image">
                    @else
                        <img src="https://via.placeholder.com/300x300?text=No+Image" 
                             alt="{{ $product->name }}" class="product-image">
                    @endif
                    
                    <div class="product-info">
                        <span class="product-category">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-store"></i> {{ $product->store->name ?? 'Unknown Store' }}
                        </p>
                        <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary flex-fill">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="btn btn-outline-primary" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-box-open" style="font-size: 5rem; color: var(--secondary-color);"></i>
                    <h3 class="mt-3" style="color: var(--primary-color);">No Products Found</h3>
                    <p class="text-muted">Try adjusting your filters or search terms</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection