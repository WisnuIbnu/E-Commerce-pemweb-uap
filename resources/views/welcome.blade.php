<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELSHOP - Marketplace Makanan Ringan Premium</title>
    <style>
        {!! file_get_contents(resource_path('css/app.css')) !!}
    </style>
</head>
<body>
    <!-- Header Top -->
    <div class="header-top">
        <div class="header-top-content">
            <div class="location-info">
                <span><strong>Tempat Jual Beli Online</strong></span>
            </div>
            <div class="header-top-links">
                <a href="#">Tentang Kami</a>
                <a href="#">Mulai Berjualan</a>
                <a href="#">Promo</a>
                <a href="#">Bantuan</a>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <header class="header-main">
        <div class="header-content">
              <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/elshop-logo.png') }}" alt="ELSHOP Logo" style="height: 40px; margin-right: 10px;">
            <a href="{{ route('home') }}" class="logo">ELSHOP</a>
            
            <button class="category-btn">
                ☰ Kategori
            </button>

            <div class="search-bar">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari makanan ringan favorit...">
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="header-icons">
                @auth
                    <a href="{{ route('buyer.cart') }}" class="icon-btn">🛒</a>
                @else
                    <span class="icon-btn">🛒</span>
                @endauth
            </div>

            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-register">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                @endguest
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="banner-slider">
            <div class="banner-content">
                <h1>Temukan Camilan Favorit Anda</h1>
                <p>Ribuan pilihan makanan ringan berkualitas dari seller terpercaya</p>
                <p>Gratis ongkir untuk pembelian minimal Rp50.000</p>
                <div class="promo-code">DISKON70</div>
            </div>
        </div>
    </div>

    <!-- Category Section -->
    <div class="category-section">
        <h2 class="section-title">Kategori Pilihan</h2>
        <div class="category-grid">
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-item">
                        <div class="category-icon">
                            @switch($category->name)
                                @case('Kue & Biskuit')
                                    🍪
                                    @break
                                @case('Snack Asin')
                                    🍿
                                    @break
                                @case('Cokelat')
                                    🍫
                                    @break
                                @case('Permen')
                                    🍬
                                    @break
                                @case('Kacang')
                                    🥜
                                    @break
                                @default
                                    🍩
                            @endswitch
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                    </a>
                @endforeach
            @else
                <a href="#" class="category-item">
                    <div class="category-icon">🍪</div>
                    <div class="category-name">Kue & Biskuit</div>
                </a>
                <a href="#" class="category-item">
                    <div class="category-icon">🍿</div>
                    <div class="category-name">Snack Asin</div>
                </a>
                <a href="#" class="category-item">
                    <div class="category-icon">🍫</div>
                    <div class="category-name">Cokelat</div>
                </a>
                <a href="#" class="category-item">
                    <div class="category-icon">🍬</div>
                    <div class="category-name">Permen</div>
                </a>
                <a href="#" class="category-item">
                    <div class="category-icon">🥜</div>
                    <div class="category-name">Kacang</div>
                </a>
                <a href="#" class="category-item">
                    <div class="category-icon">🍩</div>
                    <div class="category-name">Donat & Roti</div>
                </a>
            @endif
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-section">
        <div class="products-header">
            <h2 class="section-title">Produk Terbaru</h2>
            <a href="{{ route('products.index') }}" class="view-all">Lihat Semua →</a>
        </div>
        <div class="products-grid">
            @forelse($products as $product)
                <a href="{{ route('product.detail', $product->id) }}" class="product-card">
                    <div class="product-image">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1599490659213-e2b9527bd087?w=400&h=400&fit=crop" alt="Snack">
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.8</span>
                            </div>
                            <span>|</span>
                            <span>{{ $product->stock }} stok</span>
                        </div>
                        @if($product->store)
                            <div class="store-badge">{{ $product->store->name }}</div>
                        @endif
                    </div>
                </a>
            @empty
                <!-- Placeholder Products with Real Images -->
                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400&h=400&fit=crop" alt="Biskuit Cokelat">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Biskuit Cokelat Premium</div>
                        <div class="product-price">Rp25.000</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.8</span>
                            </div>
                            <span>|</span>
                            <span>150 stok</span>
                        </div>
                        <div class="store-badge">Snack Paradise</div>
                    </div>
                </a>

                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1607920591413-4ec007e70023?w=400&h=400&fit=crop" alt="Keripik Kentang">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Keripik Kentang Balado</div>
                        <div class="product-price">Rp18.500</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.9</span>
                            </div>
                            <span>|</span>
                            <span>200 stok</span>
                        </div>
                        <div class="store-badge">Crispy Shop</div>
                    </div>
                </a>

                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1566454419290-0a58b7b25df8?w=400&h=400&fit=crop" alt="Cokelat Bar">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Cokelat Bar Dark 70%</div>
                        <div class="product-price">Rp35.000</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>5.0</span>
                            </div>
                            <span>|</span>
                            <span>80 stok</span>
                        </div>
                        <div class="store-badge">Choco Heaven</div>
                    </div>
                </a>

                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1582058091505-f87a2e55a40f?w=400&h=400&fit=crop" alt="Kacang Almond">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Kacang Almond Panggang</div>
                        <div class="product-price">Rp45.000</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.7</span>
                            </div>
                            <span>|</span>
                            <span>120 stok</span>
                        </div>
                        <div class="store-badge">Nutty Store</div>
                    </div>
                </a>

                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=400&h=400&fit=crop" alt="Permen Jelly">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Permen Jelly Rainbow</div>
                        <div class="product-price">Rp12.000</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.6</span>
                            </div>
                            <span>|</span>
                            <span>300 stok</span>
                        </div>
                        <div class="store-badge">Sweet Corner</div>
                    </div>
                </a>

                <a href="#" class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1626356795203-bd8e50c5e42c?w=400&h=400&fit=crop" alt="Wafer Roll">
                    </div>
                    <div class="product-info">
                        <div class="product-name">Wafer Roll Cokelat</div>
                        <div class="product-price">Rp22.000</div>
                        <div class="product-meta">
                            <div class="rating">
                                <span class="star">⭐</span>
                                <span>4.8</span>
                            </div>
                            <span>|</span>
                            <span>180 stok</span>
                        </div>
                        <div class="store-badge">Wafer World</div>
                    </div>
                </a>
            @endforelse
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <h3>🛍️ Untuk Pembeli</h3>
                <p>Jelajahi ribuan pilihan makanan ringan berkualitas dari berbagai penjual terpercaya. Belanja mudah, pembayaran aman, dan pengiriman cepat ke seluruh Indonesia.</p>
                @guest
                    <a href="{{ route('login') }}">Mulai Belanja →</a>
                @else
                    <a href="{{ route('products.index') }}">Lihat Semua Produk →</a>
                @endguest
            </div>
            <div class="info-item">
                <h3>🏪 Untuk Penjual</h3>
                <p>Bergabung dengan ElSHOP dan jangkau jutaan pelanggan potensial. Proses pendaftaran mudah, sistem pembayaran terpercaya, dan dukungan penuh untuk kesuksesan bisnis Anda.</p>
                @auth
                    <a href="{{ route('buyer.store.apply') }}">Daftar Sekarang →</a>
                @else
                    <a href="{{ route('register') }}">Mulai Berjualan →</a>
                @endguest
            </div>
            <div class="info-item">
                <h3>✨ Keunggulan ElSHOP</h3>
                <p>Gratis ongkir untuk pembelian minimal Rp50.000, garansi 100% original, transaksi aman dengan berbagai metode pembayaran, dan customer service yang responsif 24/7.</p>
                <a href="#">Pelajari Lebih Lanjut →</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>ElSHOP</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Press</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Belanja</h3>
                <ul>
                    <li><a href="{{ route('products.index') }}">Semua Produk</a></li>
                    <li><a href="#">Promo Hari Ini</a></li>
                    <li><a href="#">Gratis Ongkir</a></li>
                    <li><a href="#">Wishlist</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Jual</h3>
                <ul>
                    <li><a href="{{ route('buyer.store.apply') }}">Daftar Seller</a></li>
                    <li><a href="#">Panduan Seller</a></li>
                    <li><a href="#">Pusat Edukasi</a></li>
                    <li><a href="#">Tips Sukses</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Bantuan</h3>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Cara Belanja</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © 2024 - 2025 ElSHOP. Marketplace Makanan Ringan Terpercaya di Indonesia.
        </div>
    </footer>
</body>
</html>