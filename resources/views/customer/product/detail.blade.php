<x-app-layout>
    <style>
        /* Product Detail Page - Puffy Baby Theme */
        .product-detail-page {
            background: #FEFEFE;
            min-height: 100vh;
        }

        /* Breadcrumb */
        .breadcrumb-wrapper {
            background: linear-gradient(135deg, #E4D6C5 0%, #F5E8DD 100%);
            padding: 20px 0;
            border-bottom: 3px solid rgba(152, 66, 22, 0.1);
        }

        .breadcrumb-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .breadcrumb-link {
            color: #984216;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .breadcrumb-link:hover {
            color: #78898F;
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #8D957E;
            font-size: 18px;
            font-weight: 300;
        }

        .breadcrumb-current {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        /* Main Product Section */
        .product-main-section {
            padding: 60px 0;
        }

        .product-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
        }

        /* Product Gallery */
        .product-gallery {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .main-image-container {
            position: relative;
            width: 100%;
            height: 600px;
            background: linear-gradient(135deg, #E4D6C5 0%, #F9EAE1 100%);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(152, 66, 22, 0.12);
            margin-bottom: 20px;
        }

        .main-product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .main-image-container:hover .main-product-image {
            transform: scale(1.05);
        }

        /* Wishlist Badge */
        .wishlist-badge {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #984216;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .wishlist-badge:hover {
            background: #984216;
            color: white;
            transform: scale(1.1);
        }

        /* Thumbnail Gallery */
        .thumbnail-gallery {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .thumbnail-item {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail-item:hover,
        .thumbnail-item.active {
            border-color: #984216;
            box-shadow: 0 4px 12px rgba(152, 66, 22, 0.2);
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Info */
        .product-info-wrapper {
            padding: 20px 0;
        }

        .category-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(141, 149, 126, 0.25);
        }

        .product-title {
            font-size: 40px;
            font-weight: 800;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            padding-bottom: 28px;
            border-bottom: 2px solid #F0F0F0;
            flex-wrap: wrap;
        }

        .stars {
            display: flex;
            gap: 4px;
        }

        .star {
            font-size: 20px;
            color: #FFC107;
        }

        .rating-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .review-count,
        .sold-count {
            color: #666;
            font-size: 14px;
        }

        .price-section {
            margin-bottom: 28px;
        }

        .current-price {
            font-size: 48px;
            font-weight: 800;
            color: #984216;
        }

        .stock-section {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
        }

        .stock-badge.in-stock {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #2E7D32;
            border: 2px solid #4CAF50;
        }

        .stock-badge.out-of-stock {
            background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
            color: #C62828;
            border: 2px solid #EF5350;
        }

        .stock-count {
            color: #666;
            font-size: 14px;
        }

        .description-section {
            margin-bottom: 32px;
            padding: 24px;
            background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
            border-radius: 16px;
            border: 2px solid #F0F0F0;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: #984216;
            margin-bottom: 16px;
        }

        .description-text {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }
.features-section {
margin-top: 24px;
padding: 20px;
background: #FFF8F2;
border-radius: 16px;
border: 2px solid #F0D6C5;
}
.features-section .section-heading {
font-size: 20px;
font-weight: 800;
margin-bottom: 12px;
color: #8E4B25;
display: flex;
align-items: center;
gap: 6px;
}
.features-list {
padding-left: 20px;
color: #784F2B;
line-height: 1.7;
}
.features-list li {
margin-bottom: 6px;
list-style: disc;
}
        .quantity-section {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .quantity-label {
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #E4D6C5;
            border-radius: 12px;
            overflow: hidden;
        }

        .qty-btn {
            width: 48px;
            height: 48px;
            border: none;
            background: transparent;
            cursor: pointer;
            color: #984216;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #984216;
            color: white;
        }

        .qty-input {
            width: 80px;
            height: 48px;
            border: none;
            border-left: 2px solid #E4D6C5;
            border-right: 2px solid #E4D6C5;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 40px;
        }

        .btn {
            flex: 1;
            padding: 18px 32px;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(152, 66, 22, 0.3);
        }

        .btn-add-cart:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(152, 66, 22, 0.4);
        }

        .btn-buy-now {
            background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(141, 149, 126, 0.3);
        }

        .btn-buy-now:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(141, 149, 126, 0.4);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .trust-badges {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            padding: 24px;
            background: linear-gradient(135deg, #E4D6C5 0%, #F5E8DD 100%);
            border-radius: 16px;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .trust-icon {
            font-size: 32px;
        }

        .trust-text strong {
            font-size: 14px;
            color: #984216;
            font-weight: 700;
            display: block;
        }

        .trust-text span {
            font-size: 12px;
            color: #666;
        }

        /* Related Products */
        .related-products-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
        }

        .related-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-header-related {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title-related {
            font-size: 36px;
            font-weight: 800;
            color: #984216;
            margin-bottom: 12px;
        }

        .section-subtitle-related {
            font-size: 16px;
            color: #666;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
        }

        .related-product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            text-decoration: none;
            border: 2px solid #F0F0F0;
            transition: all 0.3s ease;
            display: block;
        }

        .related-product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(152, 66, 22, 0.15);
            border-color: #E8A87C;
        }

        .related-image-wrapper {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
            background: linear-gradient(135deg, #E4D6C5 0%, #F9EAE1 100%);
        }

        .related-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-product-card:hover .related-image {
            transform: scale(1.1);
        }

        .related-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(152, 66, 22, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .related-product-card:hover .related-overlay {
            opacity: 1;
        }

        .view-text {
            color: white;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .related-info {
            padding: 20px;
        }

        .related-category {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: #8D957E;
            background: #F0F5F0;
            padding: 6px 12px;
            border-radius: 12px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .related-name {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .related-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .related-price {
            font-size: 20px;
            font-weight: 800;
            color: #984216;
        }

        .related-cart-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #E4D6C5;
            background: white;
            color: #984216;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .related-cart-btn:hover {
            background: #984216;
            color: white;
            border-color: #984216;
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-gallery {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .main-image-container {
                height: 400px;
            }

            .product-title {
                font-size: 28px;
            }

            .current-price {
                font-size: 36px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .related-products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="product-detail-page">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <div class="breadcrumb-container">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                <span class="breadcrumb-separator">›</span>
                <a href="#" class="breadcrumb-link">{{ $product->productCategory->name }}</a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">{{ $product->name }}</span>
            </div>
        </div>

        <!-- Main Product Section -->
        <div class="product-main-section">
            <div class="product-container">
                
                <!-- Product Gallery -->
                <div class="product-gallery">
                    @php
                        $mainImageRecord = $product->productImages->firstWhere('is_thumbnail', true) 
                                        ?? $product->productImages->first();
                        $mainImagePath = $mainImageRecord->image ?? null;
                        $imageExists = $mainImagePath && file_exists(public_path($mainImagePath));
                    @endphp

                    <div class="main-image-container">
                        @if($imageExists)
                            <img src="{{ asset($mainImagePath) }}"
                                 alt="{{ $product->name }}"
                                 class="main-product-image"
                                 id="mainImage">
                        @else
                            <img src="https://placehold.co/600x600/E4D6C5/984216?text={{ urlencode(Str::limit($product->name, 20)) }}"
                                 alt="{{ $product->name }}"
                                 class="main-product-image"
                                 id="mainImage">
                        @endif

                        <button class="wishlist-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>

                    @if($product->productImages->count() > 0)
                        <div class="thumbnail-gallery">
                            @foreach($product->productImages as $img)
                                @php 
                                    $thumbPath = $img->image;
                                    $thumbExists = file_exists(public_path($thumbPath));
                                @endphp
                                <div class="thumbnail-item {{ ($img->id === ($mainImageRecord->id ?? null)) ? 'active' : '' }}"
                                     onclick="changeMainImage('{{ $thumbExists ? asset($thumbPath) : 'https://placehold.co/600x600/E4D6C5/984216?text=Thumb' }}', this)">
                                    @if($thumbExists)
                                        <img src="{{ asset($thumbPath) }}" alt="Thumbnail">
                                    @else
                                        <img src="https://placehold.co/100x100/E4D6C5/984216?text={{ $loop->iteration }}" alt="Thumbnail">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info-wrapper">
                    <div class="category-tag">
                        <span>🏷️</span>
                        {{ $product->productCategory->name }}
                    </div>

                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="rating-section">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <span class="rating-value">4.8</span>
                        <span class="review-count">(124 reviews)</span>
                        <span class="sold-count">• 350+ sold</span>
                    </div>

                    <div class="price-section">
                        <div class="current-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="stock-section">
                        @if($product->stock > 0)
                            <div class="stock-badge in-stock">
                                <span>✓</span>
                                In Stock
                            </div>
                            <span class="stock-count">{{ $product->stock }} items available</span>
                        @else
                            <div class="stock-badge out-of-stock">
                                <span>✗</span>
                                Out of Stock
                            </div>
                        @endif
                    </div>

                    <div class="quantity-section">
                        <label class="quantity-label">Quantity:</label>
                        <div class="quantity-selector">
                            <button class="qty-btn" id="decreaseBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                            <input type="number" value="1" min="1" max="{{ $product->stock }}" class="qty-input" id="qtyInput">
                            <button class="qty-btn" id="increaseBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-add-cart" {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            Add to Cart
                        </button>
                        <button class="btn btn-buy-now" {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                            Buy Now
                        </button>
                    </div>

                    <div class="trust-badges">
                        <div class="trust-badge">
                            <span class="trust-icon">🚚</span>
                            <div class="trust-text">
                                <strong>Free Shipping</strong>
                                <span>Orders over Rp 100.000</span>
                            </div>
                        </div>
                        <div class="trust-badge">
                            <span class="trust-icon">↩️</span>
                            <div class="trust-text">
                                <strong>Easy Returns</strong>
                                <span>30 days return policy</span>
                            </div>
                        </div>
                        <div class="trust-badge">
                            <span class="trust-icon">🔒</span>
                            <div class="trust-text">
                                <strong>Secure Payment</strong>
                                <span>100% protected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Updated product detail with features and description moved below store info -->
<!-- Please paste your full original file here if you want a fully merged version; this is a placeholder ready for integration. -->

<!-- Store Info -->
@include('customer.store.store')

<!-- Description (Moved) -->
@if($product->description)
<div class="description-section">
    <h3 class="section-heading">
        <span class="heading-icon">📝</span>
        Description
    </h3>
    <p class="description-text">{{ $product->description }}</p>
</div>
@endif

<!-- Features (Moved) -->
@if($product->features)
<div class="features-section">
    <h3 class="section-heading">
        <span class="heading-icon">✨</span>
        Features
    </h3>
    <ul class="features-list">
        @foreach($product->features as $feature)
            <li>{{ $feature }}</li>
        @endforeach
    </ul>
</div>
@endif

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="related-products-section">
            <div class="related-container">
                <div class="section-header-related">
                    <h2 class="section-title-related">You May Also Like</h2>
                    <p class="section-subtitle-related">Similar products just for you</p>
                </div>

                <div class="related-products-grid">
                    @foreach($relatedProducts as $related)
                        @php
                            $relatedImage = $related->productImages->firstWhere('is_thumbnail', true) 
                                         ?? $related->productImages->first();
                            $relatedImagePath = $relatedImage->image ?? null;
                            $relatedImageExists = $relatedImagePath && file_exists(public_path($relatedImagePath));
                        @endphp
                        
                        <a href="{{ route('product.show', $related->id) }}" class="related-product-card">
                            <div class="related-image-wrapper">
                                @if($relatedImageExists)
                                    <img src="{{ asset($relatedImagePath) }}" 
                                         alt="{{ $related->name }}"
                                         class="related-image">
                                @else
                                    <img src="https://placehold.co/280x280/E4D6C5/984216?text={{ urlencode(Str::limit($related->name, 15)) }}" 
                                         alt="{{ $related->name }}"
                                         class="related-image">
                                @endif
                                <div class="related-overlay">
                                    <span class="view-text">View Details</span>
                                </div>
                            </div>
                            <div class="related-info">
                                <span class="related-category">{{ $related->productCategory->name }}</span>
                                <h4 class="related-name">{{ Str::limit($related->name, 40) }}</h4>
                                <div class="related-footer">
                                    <span class="related-price">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                    <button class="related-cart-btn" onclick="event.preventDefault()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Change main image function
        function changeMainImage(imageSrc, element) {
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = imageSrc;
            }
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
            });
            if (element) {
                element.classList.add('active');
            }
        }

        // Quantity selector
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtn = document.getElementById('decreaseBtn');
            const increaseBtn = document.getElementById('increaseBtn');
            const qtyInput = document.getElementById('qtyInput');

            if (decreaseBtn && increaseBtn && qtyInput) {
                decreaseBtn.addEventListener('click', function() {
                    let value = parseInt(qtyInput.value);
                    if (value > parseInt(qtyInput.min)) {
                        qtyInput.value = value - 1;
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    let value = parseInt(qtyInput.value);
                    if (value < parseInt(qtyInput.max)) {
                        qtyInput.value = value + 1;
                    }
                });

                qtyInput.addEventListener('input', function() {
                    let value = parseInt(this.value);
                    let min = parseInt(this.min);
                    let max = parseInt(this.max);
                    
                    if (isNaN(value) || value < min) {
                        this.value = min;
                    } else if (value > max) {
                        this.value = max;
                    }
                });
            }
        });
    </script>
</x-app-layout>