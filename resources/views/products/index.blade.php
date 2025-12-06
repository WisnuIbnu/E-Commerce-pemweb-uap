<x-app-layout>
<x-slot name="title">All Products - SORAÉ</x-slot>

<style>
.products-page {
    padding: 60px 0;
}

.page-header {
    text-align: center;
    margin-bottom: 60px;
}

.page-header h1 {
    font-size: 3.5rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.page-header p {
    font-size: 1.2rem;
    color: var(--color-secondary);
}

.products-container {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 40px;
}

/* Filter Sidebar */
.filter-sidebar {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    height: fit-content;
    position: sticky;
    top: 100px;
    box-shadow: 0 5px 15px rgba(86, 28, 36, 0.1);
}

.filter-section {
    margin-bottom: 30px;
}

.filter-section h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: var(--color-primary);
}

.filter-option {
    margin-bottom: 10px;
}

.filter-option label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    transition: background 0.3s;
}

.filter-option label:hover {
    background: var(--color-light);
}

.filter-option input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.price-range {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.price-inputs {
    display: flex;
    gap: 10px;
    align-items: center;
}

.price-inputs input {
    width: 100%;
    padding: 8px;
    border: 1px solid var(--color-tertiary);
    border-radius: 5px;
}

/* Products Grid */
.products-content {
    flex: 1;
}

.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.products-count {
    color: var(--color-secondary);
    font-weight: 500;
}

.sort-select {
    padding: 10px 20px;
    border: 1px solid var(--color-tertiary);
    border-radius: 25px;
    background: var(--color-white);
    color: var(--color-primary);
    cursor: pointer;
    font-weight: 500;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

.product-card {
    background: var(--color-white);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 5px 15px rgba(86, 28, 36, 0.1);
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(86, 28, 36, 0.2);
}

.product-image-container {
    position: relative;
    width: 100%;
    height: 320px;
    background: var(--color-light);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--color-primary);
    color: var(--color-white);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.product-info {
    padding: 20px;
}

.product-category {
    font-size: 0.85rem;
    color: var(--color-tertiary);
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: var(--color-primary);
    font-weight: 600;
}

.product-price {
    font-size: 1.3rem;
    color: var(--color-secondary);
    font-weight: 700;
    margin-bottom: 15px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 15px;
}

.stars {
    color: #FFB800;
}

.rating-count {
    color: var(--color-tertiary);
    font-size: 0.9rem;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.btn-cart {
    flex: 1;
    padding: 10px;
    font-size: 0.9rem;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: var(--color-white);
    border-radius: 20px;
}

.empty-state-icon {
    font-size: 5rem;
    margin-bottom: 20px;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 50px;
}

.pagination a,
.pagination span {
    padding: 10px 15px;
    border: 1px solid var(--color-tertiary);
    border-radius: 8px;
    text-decoration: none;
    color: var(--color-primary);
    transition: all 0.3s;
}

.pagination a:hover {
    background: var(--color-primary);
    color: var(--color-white);
}

.pagination .active {
    background: var(--color-primary);
    color: var(--color-white);
    border-color: var(--color-primary);
}

@media (max-width: 968px) {
    .products-container {
        grid-template-columns: 1fr;
    }
    
    .filter-sidebar {
        position: static;
    }
}
</style>

<div class="products-page">
    <div class="container">
        <div class="page-header">
            <h1>Our Collections</h1>
            <p>Discover the perfect style for every occasion</p>
        </div>
        
        <div class="products-container">
            <!-- Filter Sidebar -->
            <aside class="filter-sidebar">
                <form method="GET" action="{{ route('products.index') }}">
                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h3>Categories</h3>
                        @forelse($categories ?? [] as $category)
                            <div class="filter-option">
                                <label>
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                    {{ $category->name }}
                                </label>
                            </div>
                        @empty
                            <p style="color: var(--color-tertiary); font-size: 0.9rem;">No categories</p>
                        @endforelse
                    </div>
                    
                    <!-- Price Range -->
                    <div class="filter-section">
                        <h3>Price Range</h3>
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                                <span>-</span>
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Season Filter -->
                    <div class="filter-section">
                        <h3>Season</h3>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" name="season[]" value="summer" {{ in_array('summer', request('season', [])) ? 'checked' : '' }}>
                                Summer
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" name="season[]" value="winter" {{ in_array('winter', request('season', [])) ? 'checked' : '' }}>
                                Winter
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" name="season[]" value="spring" {{ in_array('spring', request('season', [])) ? 'checked' : '' }}>
                                Spring
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" name="season[]" value="fall" {{ in_array('fall', request('season', [])) ? 'checked' : '' }}>
                                Fall
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
                </form>
            </aside>
            
            <!-- Products Grid -->
            <div class="products-content">
                <div class="products-header">
                    <p class="products-count">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    <select class="sort-select" onchange="window.location.href='?sort=' + this.value">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>
                
                <div class="products-grid">
                    @forelse($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="product-card">
                            <div class="product-image-container">
                                <img src="{{ $product->images->first()?->image_url ? asset('storage/' . $product->images->first()->image_url) : asset('images/placeholder.jpg') }}"
                                     alt="{{ $product->name }}"
                                     class="product-image">
                                @if($product->created_at->diffInDays(now()) < 7)
                                    <span class="product-badge">New</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <p class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @if($product->reviews_count > 0)
                                    <div class="product-rating">
                                        <span class="stars">★★★★★</span>
                                        <span class="rating-count">({{ $product->reviews_count }})</span>
                                    </div>
                                @endif
                                <div class="product-actions">
                                    <button class="btn btn-primary btn-cart" onclick="event.preventDefault(); event.stopPropagation(); alert('Added to cart!')">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">📦</div>
                            <h3 style="color: var(--color-primary); margin-bottom: 15px;">No products found</h3>
                            <p style="color: var(--color-secondary);">Try adjusting your filters</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="pagination">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>