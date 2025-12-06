<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELSHOP - Marketplace Terpercaya</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/css/navbar-footer.css'])
</head>

<body>
    <!-- Header Top -->
    <div class="header-top">
        <div class="header-top-content">
            <div class="location-info">
                <span><strong>Marketplace Terpercaya Indonesia</strong></span>
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
            <a href="/" class="logo">
                <img src="{{ asset('images/elshop-logo.png') }}" alt="ELSHOP Logo">
                ELSHOP
            </a>

            <button class="category-btn">
                ☰ Kategori
            </button>

            <div class="search-bar">
                @auth
                    <form action="{{ route('buyer.products.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Cari produk...">
                        <button type="submit">Cari</button>
                    </form>
                @else
                    <form action="{{ route('login') }}" method="GET">
                        <input type="text" name="search" placeholder="Cari produk..." disabled>
                        <button type="submit">Cari</button>
                    </form>
                @endauth
            </div>

            <div class="header-icons">
                @auth
                    <a href="{{ route('buyer.cart.index') }}" class="icon-btn" title="Keranjang">🛒</a>
                @else
                    <span class="icon-btn" style="opacity: 0.5; cursor: not-allowed;" title="Login untuk belanja">🛒</span>
                @endauth
            </div>

            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-register">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-login" style="background: none; border: none; cursor: pointer;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="min-height: calc(100vh - 400px);">
        @if (session('success'))
            <div style="max-width: 1200px; margin: 20px auto; padding: 0 20px;">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div style="max-width: 1200px; margin: 20px auto; padding: 0 20px;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>ELSHOP</h3>
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
                    @auth
                        <li><a href="{{ route('buyer.products.index') }}">Semua Produk</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Semua Produk</a></li>
                    @endauth
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
            © 2024 - 2025 ELSHOP. Marketplace Makanan Ringan Terpercaya di Indonesia.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>