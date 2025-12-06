@extends('layouts.app')

@section('title', 'SORAE - Premium Fashion Import')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #561C24 0%, #8B2E3B 100%);
        color: white;
        padding: 100px 0;
        margin: -40px -15px 40px -15px;
        text-align: center;
    }
    
    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 20px;
        letter-spacing: 5px;
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 30px;
        color: var(--secondary-color);
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 40px;
        text-align: center;
        position: relative;
        padding-bottom: 15px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: var(--primary-color);
    }
    
    .category-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(86, 28, 36, 0.2);
    }
    
    .category-icon {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .category-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(86, 28, 36, 0.2);
    }
    
    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    
    .product-info {
        padding: 20px;
    }
    
    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .product-category {
        display: inline-block;
        background: var(--secondary-color);
        color: var(--primary-color);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .features-section {
        background: var(--secondary-color);
        padding: 60px 0;
        margin: 60px -15px 40px -15px;
    }
    
    .feature-box {
        text-align: center;
        padding: 30px;
    }
    
    .feature-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <h1 class="hero-title">SORAE</h1>
        <p class="hero-subtitle">Discover Premium Fashion from Around the World</p>
        <a href="{{ url('/products') }}" class="btn btn-light btn-lg px-5 py-3">
            <i class="fas fa-shopping-bag"></i> Shop Now
        </a>
    </div>
</div>

<!-- Categories Section -->
<section class="mb-5">
    <h2 class="section-title">Shop by Category</h2>
    <div class="row g-4">
        @forelse($categories as $category)
        <div class="col-md-4 col-lg-3">
            <a href="{{ url('/products?category=' . $category->id) }}" class="text-decoration-none">
                <div class="category-card">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; margin-bottom: 15px;">
                    @else
                        <div class="category-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                    @endif
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <p class="text-muted small mb-0">{{ $category->products_count ?? 0 }} Products</p>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">No categories available</p>
        </div>
        @endforelse
    </div>
</section>

<!-- Featured Products Section -->
<section class="mb-5">
    <h2 class="section-title">Featured Products</h2>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-3">
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
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">No products available</p>
        </div>
        @endforelse
    </div>
    
    @if($products->count() > 0)
    <div class="text-center mt-4">
        <a href="{{ url('/products') }}" class="btn btn-outline-primary btn-lg px-5">
            View All Products <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    @endif
</section>

<!-- Features Section -->
<div class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4 class="fw-bold" style="color: var(--primary-color);">Fast Shipping</h4>
                    <p class="text-muted">Reliable and fast delivery to your doorstep</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="fw-bold" style="color: var(--primary-color);">Secure Payment</h4>
                    <p class="text-muted">Your payment information is safe with us</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h4 class="fw-bold" style="color: var(--primary-color);">Premium Quality</h4>
                    <p class="text-muted">Only the finest imported fashion products</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection