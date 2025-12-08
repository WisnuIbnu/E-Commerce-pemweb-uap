@extends('layouts.buyer')

@section('title', $product->name . ' - ELSHOP')

@section('content')
    <div class="buyer-container">
        {{-- Product Detail Section --}}
        <div class="product-detail">
            <div class="product-detail-grid">
                {{-- Product Image --}}
                <div class="product-gallery">
                    @if($product->images && $product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                             alt="{{ $product->name }}" 
                             class="product-detail-image"
                             onerror="this.src='https://placehold.co/500x500/1e3a5f/ffffff?text={{ urlencode(substr($product->name, 0, 15)) }}'">
                    @else
                        <img src="https://placehold.co/500x500/1e3a5f/ffffff?text=No+Image" 
                             alt="No Image" class="product-detail-image">
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="product-info-section">
                    <div class="product-category-badge">
                        @if($product->category)
                            <span class="badge-primary">{{ $product->category->name }}</span>
                        @endif
                    </div>

                    <h1 class="product-detail-title">{{ $product->name }}</h1>

                    <div class="product-rating-section">
                        <div class="rating-stars">⭐⭐⭐⭐⭐</div>
                        <span class="rating-text">{{ $product->average_rating ?? '4.5' }} ({{ $product->reviews_count ?? 0 }} ulasan)</span>
                    </div>

                    <div class="product-price-section">
                        <div class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if($product->original_price > $product->price)
                            <div class="original-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</div>
                        @endif
                    </div>

                    <div class="product-stock-section">
                        <p class="stock-info">
                            <span class="stock-label">Stok Tersedia:</span>
                            <span class="stock-value">{{ $product->stock }} produk</span>
                        </p>
                        <p class="seller-info">
                            <span class="seller-label">Penjual:</span>
                            <a href="#" class="seller-link">{{ $product->store->name ?? 'ELSHOP Official' }}</a>
                        </p>
                    </div>

                    {{-- Description --}}
                    <div class="product-description">
                        <h4 class="desc-title">Deskripsi Produk</h4>
                        <p class="desc-text">{{ $product->description }}</p>
                    </div>

                    {{-- Add to Cart Form --}}
                    <div class="add-to-cart-form">
                        <input type="hidden" id="productId" value="{{ $product->id }}">

                        <div class="quantity-selector">
                            <label class="qty-label">Jumlah:</label>
                            <div class="qty-input-group">
                                <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                                <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock }}" 
                                       class="qty-input">
                                <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                            </div>
                            <span class="qty-info">Maks: {{ $product->stock }} produk</span>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-add-cart" onclick="addToCart()">
                                🛒 Tambah ke Keranjang
                            </button>
                            <button type="button" class="btn-buy-now" onclick="buyNow()">
                                ⚡ Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products Section --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">Produk Lainnya dari Toko Ini</h2>
                    <a href="#" class="view-all">Lihat Semua →</a>
                </div>

                <div class="product-grid">
                    @foreach($relatedProducts->take(4) as $related)
                        <a href="{{ route('buyer.products.show', $related->id) }}" class="product-card">
                            @if($related->images && $related->images->count() > 0)
                                <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                     alt="{{ $related->name }}"
                                     class="product-image"
                                     onerror="this.src='https://placehold.co/400x400/1e3a5f/ffffff?text={{ urlencode(substr($related->name, 0, 10)) }}'">
                            @else
                                <img src="https://placehold.co/400x400/1e3a5f/ffffff?text=No+Image" 
                                     alt="{{ $related->name }}" class="product-image">
                            @endif

                            <div class="product-info">
                                <h3 class="product-name">{{ $related->name }}</h3>
                                <div class="product-price">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </div>
                                <div class="product-meta">
                                    <div class="product-rating">
                                        ⭐ <span>{{ $related->average_rating ?? '4.5' }}</span>
                                    </div>
                                    <div class="product-sold">{{ $related->sold ?? rand(50, 500) }}+ terjual</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function increaseQty() {
            const input = document.getElementById('qtyInput');
            const max = parseInt(input.max);
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decreaseQty() {
            const input = document.getElementById('qtyInput');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function addToCart() {
            const qty = document.getElementById('qtyInput').value;
            const productId = document.getElementById('productId').value;
            
            fetch('{{ route('buyer.cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: qty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Produk berhasil ditambahkan ke keranjang!');
                } else {
                    alert('❌ Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan');
            });
        }

        function buyNow() {
            const qty = document.getElementById('qtyInput').value;
            const productId = document.getElementById('productId').value;
            window.location.href = `{{ route('buyer.checkout.index') }}?product_id=${productId}&qty=${qty}`;
        }
    </script>
@endpush