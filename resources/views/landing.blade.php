<x-landing-layout title="SweetMart - Fresh Desserts Everyday">

{{-- =========================
       HERO SECTION
========================= --}}
<section class="hero-section">
    <div class="container hero-container">

        {{-- LEFT TEXT --}}
        <div class="hero-left">
            <h1 class="hero-title animate-fade">
                Fresh Desserts,<br> Delivered Daily 🍰
            </h1>

            <p class="hero-subtitle animate-fade-delay">
                Dessert pilihanmu dibuat oleh seller lokal terbaik — segar, manis,
                dan dikirim cepat langsung ke pintumu.
            </p>

            <div class="hero-buttons animate-fade-delay2">
                <a href="{{ route('products.index') }}" class="btn-primary">
                    Shop Desserts
                </a>

                @guest
                <a href="{{ route('register') }}" class="btn-outline">
                    Join as Customer
                </a>
                @endguest
            </div>

            <div class="hero-benefits animate-fade-delay3">
                <div class="benefit-item"><h4>Fresh Daily</h4><p>Dibuat tiap hari</p></div>
                <div class="benefit-item"><h4>Local Sellers</h4><p>Dukung UMKM</p></div>
                <div class="benefit-item"><h4>Secure Checkout</h4><p>Aman & cepat</p></div>
            </div>
        </div>

        {{-- RIGHT MOCKUP --}}
        <div class="mockup-wrapper animate-scale">
            <div class="mockup-box">

                <div class="mockup-header">
                    <div class="mockup-brand">
                        <img src="{{ asset('logo/logo.png') }}" class="mockup-logo">
                        <span class="mockup-title">SweetMart</span>
                    </div>
                    <span class="mockup-version">v1.0</span>
                </div>

                <div class="mockup-body">
                    <img src="{{ asset('storage/assets/landing/chocolate-cake-premium.png') }}" class="mockup-image">

                    <div class="mockup-text">
                        <h3>Chocolate Cake Premium</h3>
                        <p>Rp 120.000</p>
                    </div>

                    <div class="mockup-actions">
                        <button class="btn-primary flex-1">Add to Cart</button>
                        <button class="mockup-icon-btn">
                            <svg class="mockup-icon" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-width="2"
                                    d="M3 3h18v2H3zM5 7h14l-1 11H6L5 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mockup-footer">Secure payment • Fast delivery</div>
            </div>
        </div>

    </div>
</section>



{{-- =========================
       PROMO BANNER
========================= --}}
<section class="promo-section">
    <div class="container">
        <div class="promo-banner">
            <div>
                <h3 class="promo-title">🎁 Special Holiday Promo!</h3>
                <p class="promo-subtitle">Dapatkan diskon hingga 25% untuk dessert favoritmu 🎂</p>
            </div>
            <a href="{{ route('products.index') }}" class="promo-btn">Claim Promo</a>
        </div>
    </div>
</section>



{{-- =========================
       STATS
========================= --}}
<section class="stats-section">
    <div class="container stats-grid">
        <div class="stats-card">
            <h2 class="stats-number">500+</h2>
            <p class="stats-label">Desserts Delivered</p>
        </div>

        <div class="stats-card">
            <h2 class="stats-number">120+</h2>
            <p class="stats-label">Verified Sellers</p>
        </div>

        <div class="stats-card">
            <h2 class="stats-number">1500+</h2>
            <p class="stats-label">Happy Customers</p>
        </div>
    </div>
</section>



{{-- =========================
       FEATURED SELLER
========================= --}}
<section class="featured-seller-section">
    <div class="container">

        <h2 class="section-title">Featured Seller</h2>

        <div class="seller-highlight">
            <img src="{{ asset('storage/assets/landing/chef.png') }}" class="seller-photo">

            <div>
                <h3 class="seller-name">{{ $featuredStore->name }}</h3>
                <p class="seller-desc">{{ $featuredStore->about }}</p>

                <a href="#"
                   class="btn-primary mt-4 inline-block">
                    Visit Store
                </a>
            </div>
        </div>

    </div>
</section>



{{-- =========================
       TESTIMONIALS
========================= --}}
<section class="section">
    <div class="container">

        <h2 class="section-title">What Customers Say</h2>

        <div class="testimonial-grid">
            @for($i = 1; $i <= 3; $i++)
                <div class="testimonial-card">
                    <div class="testimonial-profile">
                        <img src="{{ asset('storage/assets/landing/cust' . $i . '.png') }}" class="testimonial-avatar">
                        <div>
                            <h4 class="testimonial-name">Customer {{ $i }}</h4>
                            <div class="testimonial-stars">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        “Dessertnya enak banget, ngga nyangka se-premium itu buat harga segitu!”
                    </p>
                </div>
            @endfor
        </div>

    </div>
</section>



{{-- =========================
       POPULAR CATEGORIES
========================= --}}
<section class="categories-section">
    <div class="container">

        <h2 class="section-title">Popular Categories</h2>

        <div class="category-grid">
            @foreach($categories as $cat)
            <a href="{{ route('categories.products', $cat->id) }}" class="category-card">
                <img src="{{ asset('storage/'.$cat->image) }}" class="category-icon">
                <div class="category-name">{{ $cat->name }}</div>
            </a>
            @endforeach
        </div>

    </div>
</section>



{{-- =========================
       FEATURED PRODUCTS
========================= --}}
<section class="section">
    <div class="container">

        <h2 class="section-title">Featured Desserts</h2>

        <div class="featured-grid">
            @foreach($products as $p)
            <a href="{{ route('products.show', $p->id) }}" class="product-card">
                @if($p->images->first())
                <img src="{{ asset('storage/'.$p->images->first()->image) }}" class="product-thumbnail">
                @else
                <div class="no-image">No Image</div>
                @endif

                <h3 class="product-name">{{ $p->name }}</h3>
                <p class="product-price">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
            </a>
            @endforeach
        </div>

    </div>
</section>



{{-- =========================
       FINAL CTA BOX
========================= --}}
<section class="final-cta">
    <div class="container">
        <div class="final-cta-box">

            <h2 class="final-cta-title">Join SweetMart Today</h2>
            <p class="final-cta-subtitle">Dapatkan pengalaman dessert terbaik dari seller terbaik.</p>

            <div class="final-cta-buttons">
                <a href="{{ route('products.index') }}" class="cta-btn-white">Browse Desserts</a>

                @guest
                <a href="{{ route('register') }}" class="cta-btn-white">Register</a>
                @endguest
            </div>

        </div>
    </div>
</section>

</x-landing-layout>