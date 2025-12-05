<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELSHOP - Marketplace Makanan Ringan Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                ELSHOP
            </a>
            
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
                    <span class="icon-btn" style="opacity: 0.5; cursor: not-allowed;">🛒</span>
                @endauth
            </div>

            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-register">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Promo Banner -->
    <div class="promo-banner">
        🎉 DISKON HINGGA 70%! Gratis Ongkir Min. Pembelian Rp50.000 - Gunakan Kode: DISKON70
    </div>

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
                                @case('Biskuit')
                                    🍪
                                    @break
                                @case('Keripik')
                                    🥔
                                    @break
                                @case('Coklat')
                                    🍫
                                    @break
                                @case('Permen')
                                    🍬
                                    @break
                                @default
                                    🍩
                            @endswitch
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                    </a>
                @endforeach
            @else
                <!-- Default Categories -->
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🍪</div>
                    <div class="category-name">Biskuit</div>
                </a>
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🥔</div>
                    <div class="category-name">Keripik</div>
                </a>
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🍫</div>
                    <div class="category-name">Cokelat</div>
                </a>
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🍬</div>
                    <div class="category-name">Permen</div>
                </a>
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🥜</div>
                    <div class="category-name">Kacang</div>
                </a>
                <a href="{{ route('products.index') }}" class="category-item">
                    <div class="category-icon">🍩</div>
                    <div class="category-name">Roti</div>
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
                        @if($product->images && $product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}">
                        @else
                            <div style="font-size: 64px; display: flex; align-items: center; justify-content: center; height: 100%;">
                                🍪
                            </div>
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
                <!-- Placeholder if no products -->
                <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p style="font-size: 18px; color: #666;">Belum ada produk. Silakan login sebagai seller untuk menambah produk.</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn-register" style="display: inline-block; margin-top: 20px;">Daftar Sebagai Seller</a>
                    @endguest
                </div>
            @endforelse
        </div>
    </div>

    <!-- CTA Section for Guest -->
    @guest
    <div class="cta-section">
        <div class="cta-content">
            <h2>Belanja Lebih Mudah dengan Akun ElSHOP</h2>
            <p>Daftar sekarang dan nikmati berbagai keuntungan:</p>
            <ul>
                <li>✓ Akses ke ribuan produk makanan ringan</li>
                <li>✓ Gratis ongkir untuk pembelian tertentu</li>
                <li>✓ Promo eksklusif member</li>
                <li>✓ Riwayat transaksi tersimpan</li>
            </ul>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta-primary">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn-cta-secondary">Sudah Punya Akun? Login</a>
            </div>
        </div>
    </div>
    @endguest

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <h3>Untuk Pembeli</h3>
                <p>Jelajahi ribuan pilihan makanan ringan berkualitas dari berbagai penjual terpercaya. Belanja mudah, pembayaran aman, dan pengiriman cepat ke seluruh Indonesia.</p>
                @guest
                    <a href="{{ route('register') }}">Daftar & Mulai Belanja →</a>
                @else
                    <a href="{{ route('products.index') }}">Lihat Semua Produk →</a>
                @endguest
            </div>
            <div class="info-item">
                <h3>Untuk Penjual</h3>
                <p>Bergabung dengan ElSHOP dan jangkau jutaan pelanggan potensial. Proses pendaftaran mudah, sistem pembayaran terpercaya, dan dukungan penuh untuk kesuksesan bisnis Anda.</p>
                @auth
                    <a href="{{ route('buyer.store.apply') }}">Daftar Toko Sekarang →</a>
                @else
                    <a href="{{ route('register') }}">Daftar & Buka Toko →</a>
                @endguest
            </div>
            <div class="info-item">
                <h3>Keunggulan ElSHOP</h3>
                <p>Gratis ongkir untuk pembelian minimal Rp50.000, garansi 100% original, transaksi aman dengan berbagai metode pembayaran, dan customer service yang responsif 24/7.</p>
                <a href="#">Pelajari Lebih Lanjut →</a>
            </div>
        </div>
    </div>

    <style>
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #304674 0%, #98bad5 100%);
            padding: 60px 20px;
            margin: 40px 0;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            color: white;
        }

        .cta-content h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .cta-content ul {
            list-style: none;
            margin-bottom: 40px;
            text-align: left;
            display: inline-block;
        }

        .cta-content ul li {
            font-size: 16px;
            margin-bottom: 15px;
            padding-left: 10px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            background: white;
            color: #304674;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .btn-cta-secondary {
            background: transparent;
            color: white;
            padding: 15px 40px;
            border: 2px solid white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-cta-secondary:hover {
            background: white;
            color: #304674;
        }

        @media (max-width: 768px) {
            .cta-content h2 {
                font-size: 24px;
            }

            .cta-content p {
                font-size: 16px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-cta-primary,
            .btn-cta-secondary {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>

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
                    @auth
                        <li><a href="{{ route('buyer.store.apply') }}">Daftar Toko</a></li>
                    @else
                        <li><a href="{{ route('register') }}">Daftar Seller</a></li>
                    @endauth
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