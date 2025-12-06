@extends('layouts.app')

@section('title', $product['name'] . ' - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<div class="product-detail">
    <div class="container">
        <div class="product-grid">
            <div class="product-images">
                <div class="main-image" id="mainImage">
                    @if(count($product['images']) > 0)
                        <img src="{{ $product['images'][0] }}" style="width:100%; height:100%; object-fit:cover; border-radius:15px;">
                    @else
                        🏅
                    @endif
                </div>
                
                @if(count($product['images']) > 1)
                <div class="thumbnails">
                    @foreach($product['images'] as $img)
                    <img src="{{ $img }}" class="thumbnail {{ $loop->first ? 'active' : '' }}" onclick="changeImage('{{ $img }}')">
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="product-info">
                <div class="product-meta">
                    <span class="badge badge-category">⭐ {{ $product['category'] }}</span>
                    <span class="badge badge-condition">{{ $product['condition'] == 'new' ? '✨ Baru' : '♻️ Bekas' }}</span>
                </div>
                
                <h1>{{ $product['name'] }}</h1>
                
                <div class="rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= 4 ? '★' : '☆' }}
                        @endfor
                    </div>
                    <span>({{ count($product['reviews']) }} ulasan)</span>
                </div>
                
                <div class="price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                
                <div class="store-info">
                    <h3>🏪 {{ $product['store_name'] }}</h3>
                    <p>📍 {{ $product['store_city'] }}</p>
                </div>
                
                <div class="stock-info">
                    @if($product['stock'] > 0)
                        <span style="color:#00C49A;">✅ Stok tersedia: <strong>{{ $product['stock'] }}</strong> unit</span>
                    @else
                        <span style="color:#dc3545;">❌ Stok habis</span>
                    @endif
                </div>
                
                <div class="description">
                    <h3>📝 Deskripsi Produk</h3>
                    <p>{{ $product['description'] }}</p>
                </div>
                
                <p><strong>⚖️ Berat:</strong> {{ $product['weight'] }} gram</p>
                
                @if($product['stock'] > 0)
                <div class="quantity-selector">
                    <button class="qty-btn" onclick="updateQty(-1)">-</button>
                    <input type="number" class="qty-input" id="quantity" value="1" min="1" max="{{ $product['stock'] }}" readonly>
                    <button class="qty-btn" onclick="updateQty(1)">+</button>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="addToCart({{ $product['id'] }})">🛒 Tambah ke Keranjang</button>
                    <a href="{{ route('checkout') }}" class="btn btn-outline">⚡ Beli Langsung</a>
                </div>
                @else
                <div style="background:#fee; padding:1rem; border-radius:10px; text-align:center;">
                    ℹ️ Produk sedang habis
                </div>
                @endif
            </div>
        </div>
        
        <div class="reviews-section">
            <h2>⭐ Ulasan Produk</h2>
            @forelse($product['reviews'] as $review)
            <div class="review-item">
                <div class="review-header">
                    <span class="reviewer-name">👤 {{ $review['user_name'] }}</span>
                    <span class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review['rating'] ? '★' : '☆' }}
                        @endfor
                    </span>
                </div>
                <p>{{ $review['review'] }}</p>
            </div>
            @empty
            <p style="text-align:center; color:#666;">Belum ada ulasan untuk produk ini</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').innerHTML = `<img src="${src}" style="width:100%; height:100%; object-fit:cover; border-radius:15px;">`;
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
}

function updateQty(change) {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value) + change;
    if (val < 1) val = 1;
    if (val > parseInt(input.max)) val = parseInt(input.max);
    input.value = val;
}

function addToCart(productId) {
    const qty = document.getElementById('quantity').value;
    alert(`✅ Produk ditambahkan ke keranjang! (${qty} item)`);
    // TODO: Implement cart system
}
</script>
@endpush
@endsection