@extends('layouts.buyer')

@section('title', 'ELSHOP - Dashboard Pembeli')

@section('content')
    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="hero-content">
            <h1>HALLO BANG</h1>
            <p>Temukan berbagai snack premium dan camilan favorit Anda di ELSHOP</p>
            <a href="{{ route('buyer.products.index') }}" class="hero-btn">
                Mulai Belanja Sekarang
            </a>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Kategori Populer</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>

        <div class="category-grid">
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories->take(6) as $category)
                    <a href="{{ route('buyer.products.index', ['category' => $category->id]) }}" class="category-card">
                        <div class="category-icon">
                            @php
                                $iconMap = [
                                    'Keripik' => '🍟',
                                    'Biskuit' => '🍪',
                                    'Cokelat' => '🍫',
                                    'Permen' => '🍭',
                                    'Minuman' => '🥤',
                                    'Instan' => '🍜',
                                ];

                                $icon = $iconMap[$category->name] ?? '<svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #6b7280"><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/></svg>';
                            @endphp
                            {!! $icon !!}
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">
                            {{ $category->products_count ?? 0 }} produk
                        </div>
                    </a>
                @endforeach
            @else
                {{-- Default categories with SVG icons --}}
                <a href="{{ route('buyer.products.index', ['category' => 1]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #f59e0b">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                        </svg>
                    </div>
                    <div class="category-name">Keripik</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
                <a href="{{ route('buyer.products.index', ['category' => 2]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #f59e0b">
                            <circle cx="8" cy="8" r="1" />
                            <circle cx="4" cy="4" r="1" />
                            <circle cx="12" cy="4" r="1" />
                            <circle cx="4" cy="12" r="1" />
                            <circle cx="12" cy="12" r="1" />
                            <path d="M8 2a6 6 0 1 0 0 12A6 6 0 0 0 8 2zM1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8z" />
                        </svg>
                    </div>
                    <div class="category-name">Biskuit</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
                <a href="{{ route('buyer.products.index', ['category' => 3]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #78350f">
                            <path
                                d="M0 .5A.5.5 0 0 1 .5 0h15a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5V.5zM5 1v3H1V1h4zm1 0h4v3H6V1zm5 0v3h4V1h-4zM1 5h4v3H1V5zm5 0h4v3H6V5zm5 0h4v3h-4V5zM1 9h4v3H1V9zm5 0h4v3H6V9zm5 0h4v3h-4V9zM1 13h4v3H1v-3zm5 0h4v3H6v-3zm5 0h4v3h-4v-3z" />
                        </svg>
                    </div>
                    <div class="category-name">Cokelat</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
                <a href="{{ route('buyer.products.index', ['category' => 4]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #ec4899">
                            <path
                                d="M12.344 1.027C11.79.47 10.975.24 10.172.39c-.812.152-1.608.645-2.166 1.203-.56.558-1.052 1.354-1.204 2.166-.15.803.08 1.618.638 2.172l6.716 6.716c.554.554 1.369.788 2.172.638.812-.152 1.608-.645 2.166-1.203.56-.558 1.052-1.354 1.204-2.166.15-.803-.08-1.618-.638-2.172L12.344 1.027z" />
                            <path
                                d="M1.027 12.344C.47 11.79.24 10.975.39 10.172c.152-.812.645-1.608 1.203-2.166.558-.56 1.354-1.052 2.166-1.204.803-.15 1.618.08 2.172.638l6.716 6.716c.554.554.788 1.369.638 2.172-.152.812-.645 1.608-1.203 2.166-.558.56-1.354 1.052-2.166 1.204-.803.15-1.618-.08-2.172-.638L1.027 12.344z" />
                        </svg>
                    </div>
                    <div class="category-name">Permen</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
                <a href="{{ route('buyer.products.index', ['category' => 5]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #0891b2">
                            <path
                                d="M2 1a1 1 0 0 0-1 1v9h5.5A1.5 1.5 0 0 0 8 9.5V7a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v2.5a2.5 2.5 0 0 1-2.5 2.5H9a1 1 0 0 0-1 1v2h2a1 1 0 1 1 0 2H2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1h.5A1.5 1.5 0 0 0 7 9.5V7a1 1 0 0 0-1-1H1V2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-3a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        </svg>
                    </div>
                    <div class="category-name">Minuman</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
                <a href="{{ route('buyer.products.index', ['category' => 6]) }}" class="category-card">
                    <div class="category-icon">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color: #dc2626">
                            <path
                                d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5h11zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2h-11zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5z" />
                        </svg>
                    </div>
                    <div class="category-name">Makanan Instan</div>
                    <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">Lihat produk</div>
                </a>
            @endif
        </div>
    </section>

    {{-- Featured Products Section --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Produk Pilihan Hari Ini</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>

        {{-- Quick Filter --}}
        <div class="filter-bar">
            <div class="filter-group">
                <label>Kategori:</label>
                <select class="filter-select" id="categoryFilter">
                    <option value="">Semua Kategori</option>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="filter-group">
                <label>Urutkan:</label>
                <select class="filter-select" id="sortFilter">
                    <option value="latest">Terbaru</option>
                    <option value="price_low">Harga Terendah</option>
                    <option value="price_high">Harga Tertinggi</option>
                    <option value="popular">Terlaris</option>
                </select>
            </div>

            <button type="button" class="filter-btn" id="applyFilter">
                Terapkan Filter
            </button>
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                        @if($product->images && $product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}"
                                class="product-image"
                                onerror="this.onerror=null; this.src='https://placehold.co/400x400/98bad5/ffffff?text={{ urlencode(substr($product->name, 0, 10)) }}'">
                        @else
                            <img src="https://placehold.co/400x400/98bad5/ffffff?text={{ urlencode(substr($product->name, 0, 10)) }}"
                                alt="{{ $product->name }}" class="product-image">
                        @endif

                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    ⭐ <span>{{ $product->average_rating ?? '4.5' }}</span>
                                </div>
                                <div class="product-sold">{{ $product->sold ?? rand(50, 500) }}+ terjual</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"></div>
                <h3 class="empty-title">Belum Ada Produk</h3>
                <p class="empty-text">Produk akan segera hadir. Silakan cek kembali nanti!</p>
                <a href="{{ route('buyer.products.index') }}" class="hero-btn">
                    Cari Produk Lain
                </a>
            </div>
        @endif
    </section>

    {{-- Promo Banner --}}
    <section class="section">
        <div class="promo-banner">
            <img src="https://image.slidesdocs.com/responsive-images/background/food-cute-cartoon-illustration-powerpoint-background_a777da9c8d__960_540.jpg" 
                 alt="Promo Diskon" 
                 class="promo-image"
                 onerror="this.src='https://placehold.co/800x400/304674/ffffff?text=Diskon+hingga+50%'">
            <div class="promo-overlay">
                <div class="promo-badge">PROMO SPESIAL</div>
                <h2 class="promo-title">Diskon hingga 50% untuk produk pilihan!</h2>
                <p class="promo-description">Buruan belanja sebelum promo berakhir. Stok terbatas!</p>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const applyBtn = document.getElementById('applyFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortFilter = document.getElementById('sortFilter');

            if (applyBtn && categoryFilter && sortFilter) {
                applyBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const category = categoryFilter.value;
                    const sort = sortFilter.value;

                    let url = '{{ route("buyer.products.index") }}?';
                    const params = [];

                    if (category) params.push('category=' + category);
                    if (sort) params.push('sort=' + sort);

                    url += params.join('&');

                    window.location.href = url;
                });
            }
        });
    </script>
@endpush