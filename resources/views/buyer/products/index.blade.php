@extends('layouts.buyer')

@section('title', 'Belanja Produk - ELSHOP')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('buyer.dashboard') }}">Beranda</a>
    <span>/</span>
    <span>Produk</span>
</div>

<div class="section">
    <div class="section-header">
        <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Belanja Produk</h2>
        <div style="color: var(--gray-600); font-size: 0.938rem;">
            Menampilkan {{ $products->total() ?? 0 }} produk
        </div>
    </div>

    {{-- Filter & Sort Bar --}}
    <div class="filter-bar">
        {{-- Category Filter --}}
        <div class="filter-group">
            <label>Kategori:</label>
            <select name="category" class="filter-select" onchange="window.location.href='?category='+this.value+'&search={{ request('search') }}&sort={{ request('sort') }}'">
                <option value="">Semua Kategori</option>
                @if(isset($categories))
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Sort --}}
        <div class="filter-group">
            <label>Urutkan:</label>
            <select name="sort" class="filter-select" onchange="window.location.href='?category={{ request('category') }}&search={{ request('search') }}&sort='+this.value">
                <option value="">Terbaru</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
            </select>
        </div>

        {{-- Price Range --}}
        <div class="filter-group">
            <label>Harga Min:</label>
            <input type="number" name="min_price" class="filter-select" 
                   style="width: 120px;" 
                   placeholder="0" 
                   value="{{ request('min_price') }}">
        </div>

        <div class="filter-group">
            <label>Harga Max:</label>
            <input type="number" name="max_price" class="filter-select" 
                   style="width: 120px;" 
                   placeholder="1000000" 
                   value="{{ request('max_price') }}">
        </div>

        <button type="button" class="filter-btn" onclick="applyFilters()">
            <i class="fas fa-filter"></i> Terapkan
        </button>

        @if(request()->has(['category', 'sort', 'min_price', 'max_price']) && (request('category') || request('sort') || request('min_price') || request('max_price')))
            <a href="{{ route('buyer.products.index', ['search' => request('search')]) }}" 
               style="background: var(--gray-100); color: var(--gray-700); border: none; padding: 8px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-block;">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                    {{-- Product Image --}}
                    @if($product->images && $product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @else
                        <img src="https://via.placeholder.com/300x300/98bad5/ffffff?text={{ urlencode(substr($product->name, 0, 10)) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @endif
                    
                    {{-- Stock Badge --}}
                    @if($product->stock < 10)
                        <div style="position: absolute; top: 12px; left: 12px; background: var(--danger); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; box-shadow: var(--shadow);">
                            <i class="fas fa-fire"></i> Stok {{ $product->stock }}
                        </div>
                    @endif

                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        
                        {{-- Store Info --}}
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 0.813rem; color: var(--gray-600);">
                            <i class="fas fa-store"></i>
                            <span>{{ $product->store->name ?? 'Store' }}</span>
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        
                        <div class="product-meta">
                            <div class="product-rating">
                                <span class="star-icon">⭐</span>
                                <span>{{ number_format(rand(40, 50) / 10, 1) }}</span>
                                <span style="color: var(--gray-400);">|</span>
                                <span>{{ rand(50, 500) }} terjual</span>
                            </div>
                        </div>

                        {{-- Category Badge --}}
                        @if($product->category)
                            <div style="margin-top: 8px;">
                                <span style="background: var(--accent-lightest); color: var(--primary); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-search"></i></div>
            <h3 class="empty-title">Produk Tidak Ditemukan</h3>
            <p class="empty-text">
                @if(request('search'))
                    Tidak ada hasil untuk "{{ request('search') }}"
                @else
                    Belum ada produk yang tersedia saat ini
                @endif
            </p>
            @if(request()->hasAny(['category', 'search', 'sort', 'min_price', 'max_price']))
                <a href="{{ route('buyer.products.index') }}" 
                   style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                    <i class="fas fa-sync-alt"></i> Lihat Semua Produk
                </a>
            @else
                <a href="{{ route('buyer.dashboard') }}" 
                   style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            @endif
        </div>
    @endif
</div>

<script>
function applyFilters() {
    const category = document.querySelector('select[name="category"]').value;
    const sort = document.querySelector('select[name="sort"]').value;
    const minPrice = document.querySelector('input[name="min_price"]').value;
    const maxPrice = document.querySelector('input[name="max_price"]').value;
    const search = '{{ request("search") }}';
    
    let url = '{{ route("buyer.products.index") }}?';
    const params = [];
    
    if (category) params.push('category=' + category);
    if (sort) params.push('sort=' + sort);
    if (minPrice) params.push('min_price=' + minPrice);
    if (maxPrice) params.push('max_price=' + maxPrice);
    if (search) params.push('search=' + search);
    
    window.location.href = url + params.join('&');
}

// Press Enter to apply filters
document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
});
</script>

<style>
.product-card {
    position: relative;
}

.product-card:hover {
    transform: translateY(-6px);
}

a[href*="refresh"]:hover,
a[href*="home"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}
</style>
@endsection