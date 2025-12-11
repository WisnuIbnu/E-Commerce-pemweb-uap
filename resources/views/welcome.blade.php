<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    </head>
    <body>
        <!-- Header dengan navigasi -->
        <header class="welcome-top-header">
            <div class="welcome-nav">
                @if (Route::has('login'))
                    <div class="welcome-nav-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </header>

        <div class="container" style="margin-top: 2rem;">
            <!-- Banner Welcome (hanya untuk guest) -->
            @guest
                <div class="welcome-banner">
                    <h1>Selamat Datang di Klikly</h1>
                    <p>Belanja dengan mudah dan cepat, tinggal klik dan dapatkan produk impianmu.</p>
                </div>
            @endguest

            <!-- Filter & Search Section -->
            <div class="filter-section">
                <form method="GET" action="{{ route('home') }}" class="filter-form">
                    <!-- Search Bar -->
                    <div class="search-group">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Cari produk..." 
                            value="{{ request('q') }}"
                        >
                        <button type="submit">Cari</button>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-group">
                        <label for="category">Kategori:</label>
                        <select name="category" id="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option 
                                    value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div class="filter-group">
                        <label for="sort">Urutkan:</label>
                        <select name="sort" id="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Harga Terendah
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Harga Tertinggi
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter">Filter</button>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="products-container">
                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                @auth
                                    {{-- Jika sudah login, arahkan ke detail produk --}}
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                                @else
                                    {{-- Jika belum login, arahkan ke halaman login --}}
                                    <a href="{{ route('login') }}" class="product-link-guest">
                                @endauth
                                    <!-- Product Image -->
                                    <div class="product-image">
                                        @php
                                            $thumbnail = $product->productImages->first();
                                        @endphp
                                        
                                        @if($thumbnail)
                                            <img 
                                                src="{{ asset('storage/' . $thumbnail->image) }}" 
                                                alt="{{ $product->name }}"
                                            >
                                        @else
                                            <div class="no-image">Tidak ada gambar</div>
                                        @endif

                                        <!-- Product Badge -->
                                        @if($product->condition === 'new')
                                            <span class="badge badge-new">Baru</span>
                                        @else
                                            <span class="badge badge-second">Bekas</span>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="product-info">
                                        <h3 class="product-name">{{ $product->name }}</h3>
                                        
                                        <div class="product-category">
                                            {{ $product->productCategory->name ?? 'Tanpa Kategori' }}
                                        </div>

                                        <div class="product-price">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>

                                        <div class="product-meta">
                                            <span class="product-stock">
                                                Stok: {{ $product->stock }}
                                            </span>
                                            <span class="product-weight">
                                                {{ $product->weight }}g
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <h3>Tidak ada produk ditemukan</h3>
                        <p>Coba gunakan kata kunci atau filter lain</p>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>