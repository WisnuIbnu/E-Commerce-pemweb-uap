<!-- buyer/products/show.blade.php -->
@extends('layouts.app')
@section('title', $product->name . ' - ELSHOP')
@section('content')
<div class="container mt-5">
    <div class="product-detail">
        <div class="product-gallery">
            @if($product->images->first())
                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" class="main-image">
            @else
                <div class="placeholder" style="height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 64px;">
                    🛍️
                </div>
            @endif
            
            @if($product->images->count() > 1)
                <div class="thumbnail-gallery">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Thumbnail" class="thumbnail">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="product-details-section">
            <div class="product-header">
                <h1>{{ $product->name }}</h1>
                <div class="product-meta">
                    <span class="badge">{{ $product->category->name }}</span>
                    <span class="rating">⭐ 4.8 | Terjual 234</span>
                </div>
            </div>

            <div class="product-price-section">
                <div class="price-display">
                    <span class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="stock">Stok: {{ $product->stock }}</span>
                </div>
            </div>

            <div class="product-store">
                <div class="store-info">
                    <h3>{{ $product->store->name }}</h3>
                    <p>{{ $product->store->city }}</p>
                    <a href="#" class="btn-secondary btn-sm">Kunjungi Toko</a>
                </div>
            </div>

            <div class="product-description">
                <h3>Deskripsi Produk</h3>
                <p>{{ $product->description }}</p>
            </div>

            <div class="product-actions">
                <form action="{{ route('buyer.cart.add') }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="quantity-selector">
                        <button type="button" class="qty-btn" onclick="decrementQty()">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                        <button type="button" class="qty-btn" onclick="incrementQty({{ $product->stock }})">+</button>
                    </div>
                    <button type="submit" class="btn-primary btn-lg">Tambah ke Keranjang</button>
                </form>
            </div>

            <div class="product-reviews">
                <h3>Ulasan Produk</h3>
                <div class="reviews-list">
                    @if($product->reviews && $product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <strong>{{ $review->user->name }}</strong>
                                    <span class="review-rating">⭐ {{ $review->rating }}</span>
                                </div>
                                <p class="review-text">{{ $review->comment }}</p>
                                <p class="review-date">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada ulasan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="related-products">
            <h2>Produk Serupa</h2>
            <div class="products-grid">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('buyer.products.show', $relatedProduct->id) }}" class="product-card">
                        <div class="product-image">
                            @if($relatedProduct->images->first())
                                <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_url) }}" alt="{{ $relatedProduct->name }}">
                            @else
                                <div class="placeholder">🛍️</div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3>{{ Str::limit($relatedProduct->name, 50) }}</h3>
                            <p class="category">{{ $relatedProduct->category->name }}</p>
                            <div class="product-footer">
                                <div class="price">Rp{{ number_format($relatedProduct->price, 0, ',', '.') }}</div>
                                <div class="rating">⭐ 4.8</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function incrementQty(max) {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>
@endsection