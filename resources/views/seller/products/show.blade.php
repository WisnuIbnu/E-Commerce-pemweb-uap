<x-app-layout>
    <x-slot name="title">{{ $product->name }} - SORAÉ</x-slot>
    
    <style>
        .product-detail {
            padding: 60px 0;
        }
        
        .product-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }
        
        /* Image Gallery */
        .product-gallery {
            position: sticky;
            top: 100px;
            height: fit-content;
        }
        
        .main-image {
            width: 100%;
            height: 600px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        
        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .thumbnail {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        
        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--color-primary);
        }
        
        /* Product Info */
        .product-info-section {
            padding: 20px 0;
        }
        
        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--color-tertiary);
            font-size: 0.9rem;
        }
        
        .breadcrumb a {
            color: var(--color-tertiary);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            color: var(--color-primary);
        }
        
        .product-title {
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 15px;
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        
        .stars {
            color: #FFB800;
            font-size: 1.2rem;
        }
        
        .rating-text {
            color: var(--color-secondary);
        }
        
        .product-price {
            font-size: 2.5rem;
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 30px;
        }
        
        .product-description {
            color: var(--color-secondary);
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 1.05rem;
        }
        
        /* Product Options */
        .product-option {
            margin-bottom: 30px;
        }
        
        .option-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 15px;
        }
        
        .option-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .option-btn {
            padding: 12px 24px;
            border: 2px solid var(--color-tertiary);
            background: transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .option-btn:hover,
        .option-btn.active {
            border-color: var(--color-primary);
            background: var(--color-primary);
            color: var(--color-white);
        }
        
        /* Quantity Selector */
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .quantity-controls {
            display: flex;
            border: 2px solid var(--color-tertiary);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--color-white);
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.3s;
        }
        
        .quantity-btn:hover {
            background: var(--color-light);
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            border-left: 1px solid var(--color-tertiary);
            border-right: 1px solid var(--color-tertiary);
            font-size: 1rem;
            font-weight: 600;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .btn-large {
            flex: 1;
            padding: 15px;
            font-size: 1.1rem;
        }
        
        /* Product Details Tabs */
        .product-tabs {
            margin-top: 60px;
            border-top: 2px solid var(--color-tertiary);
        }
        
        .tab-buttons {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .tab-btn {
            padding: 20px 0;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--color-tertiary);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .tab-btn.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-primary);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Reviews Section */
        .reviews-section {
            margin-top: 80px;
        }
        
        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .review-card {
            background: var(--color-white);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .reviewer-info {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--color-tertiary);
        }
        
        .reviewer-name {
            font-weight: 600;
            color: var(--color-primary);
        }
        
        .review-date {
            color: var(--color-tertiary);
            font-size: 0.9rem;
        }
        
        .review-rating {
            color: #FFB800;
        }
        
        .review-content {
            color: var(--color-secondary);
            line-height: 1.7;
        }
        
        /* Related Products */
        .related-products {
            margin-top: 80px;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            color: var(--color-primary);
        }
        
        @media (max-width: 968px) {
            .product-layout {
                grid-template-columns: 1fr;
            }
            
            .product-gallery {
                position: static;
            }
        }
    </style>
    
    <div class="product-detail">
        <div class="container">
            <div class="product-layout">
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <img id="mainImage" 
                         src="{{ $product->images->first()?->image_url ?? asset('images/placeholder.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="main-image">
                    
                    @if($product->images->count() > 1)
                    <div class="thumbnail-grid">
                        @foreach($product->images as $image)
                        <img src="{{ $image->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="thumbnail {{ $loop->first ? 'active' : '' }}"
                             onclick="changeImage('{{ $image->image_url }}', this)">
                        @endforeach
                    </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="product-info-section">
                    <div class="breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <span>/</span>
                        <a href="{{ route('products.index') }}">Products</a>
                        <span>/</span>
                        <span>{{ $product->name }}</span>
                    </div>
                    
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    <div class="product-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">{{ $product->reviews->avg('rating') ?? 5 }}/5 ({{ $product->reviews->count() }} reviews)</span>
                    </div>
                    
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <p class="product-description">{{ $product->description }}</p>
                    
                    <!-- Size Options -->
                    <div class="product-option">
                        <div class="option-label">Select Size</div>
                        <div class="option-buttons">
                            <button class="option-btn" onclick="selectOption(this)">S</button>
                            <button class="option-btn active" onclick="selectOption(this)">M</button>
                            <button class="option-btn" onclick="selectOption(this)">L</button>
                            <button class="option-btn" onclick="selectOption(this)">XL</button>
                            <button class="option-btn" onclick="selectOption(this)">XXL</button>
                        </div>
                    </div>
                    
                    <!-- Color Options -->
                    <div class="product-option">
                        <div class="option-label">Select Color</div>
                        <div class="option-buttons">
                            <button class="option-btn active" onclick="selectOption(this)">Maroon</button>
                            <button class="option-btn" onclick="selectOption(this)">Black</button>
                            <button class="option-btn" onclick="selectOption(this)">Beige</button>
                        </div>
                    </div>
                    
                    <!-- Quantity -->
                    <div class="quantity-selector">
                        <div class="option-label">Quantity</div>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1">
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-large" onclick="addToCart()">Add to Cart</button>
                        <button class="btn btn-secondary btn-large" onclick="buyNow()">Buy Now</button>
                    </div>
                    
                    <!-- Product Info -->
                    <div style="background: var(--color-white); padding: 20px; border-radius: 10px; margin-top: 20px;">
                        <p style="margin-bottom: 10px;"><strong>SKU:</strong> {{ $product->id }}</p>
                        <p style="margin-bottom: 10px;"><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p style="margin-bottom: 10px;"><strong>Stock:</strong> {{ $product->stock }} items available</p>
                        <p><strong>Store:</strong> {{ $product->store->name ?? 'Official Store' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-buttons">
                    <button class="tab-btn active" onclick="switchTab(0)">Description</button>
                    <button class="tab-btn" onclick="switchTab(1)">Specifications</button>
                    <button class="tab-btn" onclick="switchTab(2)">Reviews ({{ $product->reviews->count() }})</button>
                </div>
                
                <div class="tab-content active">
                    <p style="color: var(--color-secondary); line-height: 1.8;">{{ $product->description }}</p>
                </div>
                
                <div class="tab-content">
                    <p style="color: var(--color-secondary); line-height: 1.8;">Product specifications and details will be displayed here.</p>
                </div>
                
                <div class="tab-content">
                    <!-- Reviews -->
                    <div class="reviews-section">
                        <div class="reviews-header">
                            <h3 style="color: var(--color-primary);">Customer Reviews</h3>
                            @auth
                            <button class="btn btn-primary" onclick="showReviewForm()">Write a Review</button>
                            @endauth
                        </div>
                        
                        @forelse($product->reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar"></div>
                                    <div>
                                        <div class="reviewer-name">{{ $review->user->name }}</div>
                                        <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 0; $i < $review->rating; $i++)★@endfor
                                </div>
                            </div>
                            <p class="review-content">{{ $review->comment }}</p>
                        </div>
                        @empty
                        <p style="text-align: center; color: var(--color-tertiary); padding: 40px 0;">No reviews yet. Be the first to review this product!</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <div class="related-products">
                <div class="section-header">
                    <h2>You May Also Like</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                    @foreach($relatedProducts ?? [] as $relatedProduct)
                    <a href="{{ route('products.show', $relatedProduct) }}" style="text-decoration: none; color: inherit;">
                        <div style="background: var(--color-white); border-radius: 15px; overflow: hidden;">
                            <img src="{{ $relatedProduct->images->first()?->image_url ?? asset('images/placeholder.jpg') }}" 
                                 style="width: 100%; height: 300px; object-fit: cover;">
                            <div style="padding: 20px;">
                                <h4 style="color: var(--color-primary); margin-bottom: 10px;">{{ $relatedProduct->name }}</h4>
                                <p style="color: var(--color-secondary); font-weight: 700; font-size: 1.2rem;">
                                    Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function changeImage(src, thumbnail) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }
        
        function selectOption(btn) {
            btn.parentElement.querySelectorAll('.option-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
        }
        
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        
        function switchTab(index) {
            document.querySelectorAll('.tab-btn').forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
            document.querySelectorAll('.tab-content').forEach((content, i) => {
                content.classList.toggle('active', i === index);
            });
        }
        
        function addToCart() {
            alert('Product added to cart!');
        }
        
        function buyNow() {
            window.location.href = '{{ route("checkout.index") }}';
        }
        
        function showReviewForm() {
            alert('Review form will be shown here');
        }
    </script>
    @endpush
</x-app-layout>
