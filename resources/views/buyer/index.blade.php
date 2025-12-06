@extends('layouts.app')

@section('title', 'FlexSport - E-Commerce Olahraga Terpercaya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>⚡ Selamat Datang di FlexSport</h1>
        <p>Platform e-commerce olahraga terpercaya untuk semua kebutuhan Anda</p>
        <a href="#products" class="btn btn-primary">🛒 Belanja Sekarang</a>
    </div>
</section>

<!-- Search Bar -->
<section class="search-section">
    <div class="container">
        <form action="{{ route('home') }}" method="GET" class="search-bar">
            <input type="text" name="search" class="search-input" placeholder="🔍 Cari produk olahraga..." 
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
</section>

<!-- Categories -->
<section class="categories">
    <div class="container">
        <h2 class="section-title">🏆 Kategori Produk</h2>

        <div class="category-grid">

            <div class="category-card" onclick="window.location.href='{{ route('home') }}'">
                <div class="category-icon">🌟</div>
                <h3>Semua Produk</h3>
            </div>

            @php 
                $icons = ['⚽', '🏀', '🎾', '🏈', '⛳', '🏐', '🥊'];
            @endphp

            @foreach($categories as $index => $category)
            <div class="category-card"
                 onclick="window.location.href='{{ route('home') }}?category={{ $category->id }}#products'">
                <div class="category-icon">{{ $icons[$index % count($icons)] }}</div>
                <h3>{{ $category->name }}</h3>
            </div>
            @endforeach

        </div>
    </div>
</section>

<!-- Products -->
<section class="products" id="products">
    <div class="container">
        <h2 class="section-title">
            🎯 
            {{ request('search') ? 'Hasil Pencarian: "' . request('search') . '"' : 'Produk Terbaru' }}
        </h2>

        <div class="products-grid">

            @forelse($products as $product)
            <div class="product-card">

                <div class="product-image">
                    @if($product->image)
                        <img src="{{ $product->image }}" 
                             alt="{{ $product->name }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        🏅
                    @endif
                </div>

                <div class="product-info">
                    <div class="product-category">⭐ {{ $product->category }}</div>

                    <h3 class="product-name">{{ $product->name }}</h3>

                    <p class="product-store">🏪 {{ $product->store_name }}</p>

                    <span class="product-condition">
                        {{ $product->condition === 'new' ? '✨ Baru' : '♻️ Bekas' }}
                    </span>

                    <div class="product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="product-actions">
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline">👁️ Detail</a>

                        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary">
                            🛒 Beli
                        </button>
                    </div>
                </div>

            </div>
            @empty

            <div class="empty-state" style="grid-column: 1/-1;">
                <h3>😔 {{ request('search') ? 'Produk tidak ditemukan' : 'Belum ada produk' }}</h3>
                <p>{{ request('search') ? 'Coba kata kunci lain' : 'Produk akan muncul di sini setelah seller menambahkan' }}</p>
            </div>

            @endforelse

        </div>
    </div>
</section>

@push('scripts')
<script>
function addToCart(productId) {
    alert('🛒 Produk ditambahkan ke keranjang! (ID: ' + productId + ')');
}
</script>
@endpush

@endsection