<x-app-layout>
<x-slot name="title">SORAÉ - Elevate Style, Embrace Story</x-slot>

<style>
/* Hero Section */
.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    padding: 80px 0;
    min-height: 600px;
}

.hero-content h1 {
    font-size: 4rem;
    line-height: 1.2;
    margin-bottom: 30px;
    color: var(--color-primary);
}

.hero-content p {
    font-size: 1.1rem;
    margin-bottom: 40px;
    color: var(--color-secondary);
    line-height: 1.8;
}

.hero-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(86, 28, 36, 0.2);
}

.hero-image img {
    width: 100%;
    height: auto;
    display: block;
    min-height: 500px;
    object-fit: cover;
}

/* Section Title */
.section-title {
    text-align: center;
    margin: 80px 0 50px;
}

.section-title h2 {
    font-size: 3rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.section-title p {
    font-size: 1.1rem;
    color: var(--color-secondary);
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 40px;
    margin-bottom: 50px;
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

.product-image {
    width: 100%;
    height: 350px;
    object-fit: cover;
    background: var(--color-light);
}

.product-info {
    padding: 25px;
}

.product-title {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--color-primary);
    font-weight: 600;
}

.product-price {
    font-size: 1.2rem;
    color: var(--color-secondary);
    font-weight: 600;
}

.product-actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.product-actions button {
    flex: 1;
}

/* Collections Section */
.collections-section {
    background: var(--color-white);
    padding: 80px 0;
    margin: 80px 0;
    border-radius: 30px;
}

.collection-showcase {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    margin-bottom: 50px;
}

.collection-item {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    height: 500px;
    box-shadow: 0 10px 30px rgba(86, 28, 36, 0.15);
}

.collection-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.collection-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(to top, rgba(86, 28, 36, 0.95), transparent);
    color: var(--color-white);
}

.collection-overlay h3 {
    font-size: 2rem;
    margin-bottom: 15px;
}

.view-all-btn {
    text-align: center;
    margin-top: 40px;
}

/* Testimonials */
.testimonials {
    padding: 80px 0;
}

.testimonial-card {
    background: var(--color-white);
    padding: 40px;
    border-radius: 20px;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    box-shadow: 0 10px 30px rgba(86, 28, 36, 0.1);
}

.testimonial-content {
    font-size: 1.2rem;
    font-style: italic;
    margin-bottom: 30px;
    color: var(--color-secondary);
    line-height: 1.8;
}

.testimonial-author {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.author-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.author-info h4 {
    color: var(--color-primary);
    margin-bottom: 5px;
}

.author-info p {
    color: var(--color-tertiary);
    font-size: 0.9rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: var(--color-white);
    border-radius: 20px;
}

.empty-state-icon {
    font-size: 5rem;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .hero {
        grid-template-columns: 1fr;
        padding: 40px 0;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .collection-showcase {
        grid-template-columns: 1fr;
    }
    
    .product-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Hero Section -->
<section class="hero container">
    <div class="hero-content">
        <h1>Elevate Style.<br>Embrace Story.</h1>
        <p>We provide designers' styles and collections for any season. You can choose trendy or classic designs as you like or your purposes. Our service has a spice that will not vanish anytime.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Explore →</a>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/hero-couple.jpg') }}" alt="Fashion Couple">
    </div>
</section>

<!-- Trending Collections -->
<section class="container">
    <div class="section-title">
        <h2>Trending Collections</h2>
        <p>Have a look at what's trending now!</p>
    </div>
    
    @if($trendingProducts->count() > 0)
        <div class="product-grid">
            @foreach($trendingProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="product-card">
                    <img src="{{ $product->images->first()?->image_url ? asset('storage/' . $product->images->first()->image_url) : asset('images/placeholder.jpg') }}"
                         alt="{{ $product->name }}"
                         class="product-image">
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="product-actions">
                            <button class="btn btn-primary" onclick="event.preventDefault(); event.stopPropagation(); alert('Added to cart!');">Add to Cart</button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h3 style="color: var(--color-primary); margin-bottom: 15px;">No Products Yet</h3>
            <p style="color: var(--color-secondary);">Check back soon for new arrivals!</p>
        </div>
    @endif
    
    <div class="view-all-btn">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">View All →</a>
    </div>
</section>

<!-- Summer Collections -->
<section class="collections-section">
    <div class="container">
        <div class="section-title">
            <h2>Summer Collections</h2>
            <p>We curated your look and comfort on scoreless weather.</p>
        </div>
        <div class="collection-showcase">
            <div class="collection-item">
                <img src="{{ asset('images/summer-1.jpg') }}" alt="Summer Collection 1">
                <div class="collection-overlay">
                    <h3>Casual Comfort</h3>
                    <p>Your daily style in the screen, your tranquility with kinetic sound a product.</p>
                </div>
            </div>
            <div class="collection-item">
                <img src="{{ asset('images/summer-2.jpg') }}" alt="Summer Collection 2">
                <div class="collection-overlay">
                    <h3>Beach Ready</h3>
                    <p>Our main claim in the perfect your expression with kinetic quality a product.</p>
                </div>
            </div>
        </div>
        <div class="view-all-btn">
            <a href="{{ route('products.index') }}?season=summer" class="btn btn-primary">Explore →</a>
        </div>
    </div>
</section>

<!-- Winter Collections -->
<section class="container">
    <div class="section-title">
        <h2>Winter Collections</h2>
        <p>We curated your look and comfort on cold weather.</p>
    </div>
    <div class="collection-showcase">
        <div class="collection-item">
            <img src="{{ asset('images/winter-1.jpg') }}" alt="Winter Collection">
            <div class="collection-overlay">
                <h3>Cozy & Warm</h3>
                <p>We provide the spread original collection for any season.</p>
            </div>
        </div>
        <div class="collection-item">
            <img src="{{ asset('images/winter-2.jpg') }}" alt="Winter Accessories">
            <div class="collection-overlay">
                <h3>Winter Essentials</h3>
                <p>That main with is in screen our exclusivity so luxury quality a product.</p>
            </div>
        </div>
    </div>
    <div class="view-all-btn">
        <a href="{{ route('products.index') }}?season=winter" class="btn btn-primary">Explore →</a>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <div class="section-title">
            <h2>What our Customer says</h2>
            <p>We value our customers' feedback to provide the best service.</p>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-content">
                <p>"Soraé has provided me the best quality products I could imagine. I was so sick with the lack of good design, feels like there is no hope, but Soraé had it all."</p>
            </div>
            <div class="testimonial-author">
                <img src="{{ asset('images/customer-1.jpg') }}" alt="Jane Bennet" class="author-image">
                <div class="author-info">
                    <h4>Jane Bennet</h4>
                    <p>Fashion Model</p>
                </div>
            </div>
        </div>
    </div>
</section>
</x-app-layout>