@extends('layouts.buyer')

@section('title', 'ELSHOP - Dashboard')

@section('content')
    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="hero-content">
            <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p>Temukan berbagai snack favorit Anda di ELSHOP</p>
            <a href="{{ route('buyer.products.index') }}" class="hero-btn">
                Mulai Belanja Sekarang
            </a>
        </div>
    </section>

    {{-- Categories --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Kategori Populer</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>
        
        <div class="category-grid">
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories as $category)
                    <a href="{{ route('buyer.products.index', ['category' => $category->id]) }}" class="category-card">
                        <div class="category-icon">
                            @if($category->icon)
                                {!! $category->icon !!}
                            @else
                                🍪
                            @endif
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                    </a>
                @endforeach
            @else
                {{-- Dummy categories --}}
                <a href="#" class="category-card">
                    <div class="category-icon">🍟</div>
                    <div class="category-name">Keripik</div>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">🍪</div>
                    <div class="category-name">Biskuit</div>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">🍫</div>
                    <div class="category-name">Cokelat</div>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">🍬</div>
                    <div class="category-name">Permen</div>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">🥤</div>
                    <div class="category-name">Minuman</div>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">🍜</div>
                    <div class="category-name">Instan</div>
                </a>
            @endif
        </div>
    </section>

    {{-- Products --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Produk Pilihan</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                        @if($product->images && $product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image">
                        @else
                            <img src="https://via.placeholder.com/300x300/98bad5/ffffff?text=No+Image" 
                                 alt="{{ $product->name }}" 
                                 class="product-image">
                        @endif
                        
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star-icon">⭐</span>
                                    <span>4.5</span>
                                </div>
                                <div class="product-sold">100+ terjual</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum Ada Produk</h3>
                <p class="empty-text">Produk akan ditampilkan setelah seller menambahkan produk</p>
            </div>
        @endif
    </section>
@endsection