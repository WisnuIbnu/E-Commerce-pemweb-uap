@extends('layouts.buyer')

@section('title', 'Dashboard Buyer - ELSHOP')

@section('styles')
    @vite(['resources/css/dashboard-buyer.css'])
@endsection

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="dashboard-header">
        <div class="welcome-section">
            <h2>Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
            <p>Temukan berbagai snack favorit Anda di ELSHOP</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="search-filter-card">
        <form method="GET" action="{{ route('buyer.dashboard') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control search-input" 
                           placeholder="🔍 Cari produk..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select category-select">
                        <option value="">📦 Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" 
                           name="price_min" 
                           class="form-control price-input" 
                           placeholder="Harga Min" 
                           value="{{ request('price_min') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" 
                           name="price_max" 
                           class="form-control price-input" 
                           placeholder="Harga Max" 
                           value="{{ request('price_max') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="products-section">
            <h4 class="section-title">📦 Produk Tersedia</h4>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card">
                            <a href="{{ route('buyer.products.show', $product->id) }}" class="product-image-link">
                                @if($product->images && $product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                         class="product-image" 
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image fa-3x"></i>
                                        <p>No Image</p>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="product-info">
                                <h6 class="product-title">
                                    <a href="{{ route('buyer.products.show', $product->id) }}">
                                        {{ Str::limit($product->name, 40) }}
                                    </a>
                                </h6>
                                
                                <div class="store-name">
                                    <i class="fas fa-store"></i> 
                                    {{ $product->store->name ?? 'Unknown' }}
                                </div>
                                
                                <div class="product-meta">
                                    <span class="product-price">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="product-stock">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                
                                <form action="{{ route('buyer.cart.add') }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="btn-add-cart">
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-box-open fa-4x"></i>
            </div>
            <h5>Produk tidak ditemukan</h5>
            <p>Coba gunakan filter yang berbeda atau kata kunci lain.</p>
            <a href="{{ route('buyer.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Semua Produk
            </a>
        </div>
    @endif
</div>
@endsection
