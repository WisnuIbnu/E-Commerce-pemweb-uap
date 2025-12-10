@extends('layouts.app')

@section('content')
<p style="color:red; font-size:30px">TEST LANDING</p>

{{-- PAGE WRAPPER --}}
<div class="page-wrapper">

    {{-- =======================================================
        HERO SECTION
    ======================================================== --}}
    <section class="hero-section">
        <div class="hero-container">

            {{-- LEFT: TEXT CONTENT --}}
            <div class="hero-left">

                <h1 class="hero-title">
                    Fresh Desserts,<br>
                    Delivered Daily 🍰
                </h1>

                <p class="hero-subtitle">
                    Temukan dessert favoritmu — dibuat segar oleh seller lokal & dikirim cepat langsung ke pintumu.
                </p>

                <div class="hero-cta-group">
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        Shop Desserts
                    </a>

                    @guest
                    <a href="{{ route('register') }}" class="btn-outline">
                        Join as Customer
                    </a>
                    @endguest
                </div>

                <div class="hero-benefits">
                    <div class="benefit-item">
                        <h4>Fresh Daily</h4>
                        <p>Dibuat tiap hari</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Local Sellers</h4>
                        <p>Dukung UMKM</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Secure Checkout</h4>
                        <p>Aman & cepat</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT: PHONE MOCKUP --}}
            <div class="mockup-wrapper">
                <div class="mockup-box">
                    <div class="mockup-header">
                        <div class="mockup-brand">
                            <div class="mockup-logo"></div>
                            <span>SweetMart</span>
                        </div>
                        <span class="mockup-version">v1.0</span>
                    </div>

                    <div class="mockup-body">

                        <div class="mockup-image">
                            <img src="{{ asset('categories/7.png') }}" alt="Dessert Preview">
                        </div>

                        <div class="mockup-text">
                            <h3>Chocolate Cake Premium</h3>
                            <p>Rp 120.000</p>
                        </div>

                        <div class="mockup-actions">
                            <button class="btn-primary flex-1">Add to Cart</button>

                            <button class="mockup-icon-btn">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-width="2"
                                        d="M3 3h18v2H3zM5 7h14l-1 11H6L5 7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mockup-footer">
                        Secure payment • Fast delivery
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- =======================================================
        POPULAR CATEGORIES
    ======================================================== --}}
    <section class="section">
        <h2 class="section-title">Popular Categories</h2>

        <div class="category-grid">
            @foreach($categories as $cat)
                <a href="{{ route('categories.products', $cat->id) }}" class="category-card">

                    <img src="{{ asset($cat->image) }}"
                         class="category-icon">

                    <div class="category-name">{{ $cat->name }}</div>

                </a>
            @endforeach
        </div>
    </section>


    {{-- =======================================================
        FEATURED DESSERTS
    ======================================================== --}}
    <section class="section bg-white">
        <div>

            <div class="section-header">
                <h2 class="section-title">Featured Desserts</h2>
                <a href="{{ route('products.index') }}" class="see-all">See all</a>
            </div>

            <div class="featured-grid">
                @foreach($products as $p)
                <a href="{{ route('products.show', $p->id) }}" class="product-card">

                    @if($p->images->first())
                        <img src="{{ asset('storage/'.$p->images->first()->image) }}"
                             class="product-thumbnail">
                    @else
                        <div class="no-image">No Image</div>
                    @endif

                    <h3 class="product-name">{{ $p->name }}</h3>
                    <p class="product-price">Rp {{ number_format($p->price,0,',','.') }}</p>

                </a>
                @endforeach
            </div>

        </div>
    </section>


@endsection