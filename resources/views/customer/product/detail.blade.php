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
            display: flex;
            align-items: center;
            justify-content: center;
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

        .image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .placeholder-icon {
            font-size: 120px;
            opacity: 0.4;
        }

        .placeholder-text {
            color: #999;
            font-size: 16px;
            font-weight: 500;
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
            flex-shrink: 0;
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

        /* Product Info Wrapper */
        .product-info-wrapper {
            padding: 20px 0;
        }

        /* Category Tag */
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

        .tag-icon {
            font-size: 16px;
        }

        /* Product Title */
        .product-title {
            font-size: 40px;
            font-weight: 800;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.3;
            letter-spacing: -0.5px;
        }

        /* Rating Section */
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
            color: #E0E0E0;
        }

        .star.filled {
            color: #FFC107;
        }

        .star.half {
            background: linear-gradient(90deg, #FFC107 50%, #E0E0E0 50%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        /* Price Section */
        .price-section {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .current-price {
            font-size: 48px;
            font-weight: 800;
            color: #984216;
            letter-spacing: -1px;
        }

        .original-price {
            font-size: 24px;
            color: #999;
            text-decoration: line-through;
        }

        .discount-badge {
            background: linear-gradient(135deg, #E8A87C 0%, #984216 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
        }

        /* Stock Section */
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

        .stock-icon {
            font-size: 18px;
        }

        .stock-count {
            color: #666;
            font-size: 14px;
        }

        /* Quantity Section */
        .quantity-section {
            margin-bottom: 24px;
        }

        .quantity-label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .qty-btn {
            width: 44px;
            height: 44px;
            border: 2px solid #E4D6C5;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            color: #984216;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .qty-btn:hover:not(:disabled) {
            background: #984216;
            color: white;
            border-color: #984216;
        }

        .qty-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .qty-input {
            width: 80px;
            height: 44px;
            border: 2px solid #E4D6C5;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .stock-info {
            color: #8D957E;
            font-size: 14px;
            font-weight: 500;
        }

        /* Add to Cart Button */
        .add-to-cart-section {
            margin-bottom: 32px;
        }

        .btn-add-cart {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(152, 66, 22, 0.3);
        }

        .btn-add-cart:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(152, 66, 22, 0.4);
        }

        .btn-add-cart:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Trust Badges */
        .trust-badges {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            padding: 24px;
            background: linear-gradient(135deg, #E4D6C5 0%, #F5E8DD 100%);
            border-radius: 16px;
            margin-bottom: 32px;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .trust-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .trust-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .trust-text strong {
            font-size: 14px;
            color: #984216;
            font-weight: 700;
        }

        .trust-text span {
            font-size: 12px;
            color: #666;
        }

        /* Description & Features */
        .desc-feature-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .description-section,
        .features-section {
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

        .heading-icon {
            font-size: 24px;
        }

        .description-text {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 12px;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #555;
            font-size: 15px;
            font-weight: 500;
        }

        .features-list li::before {
            content: '✓';
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
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

        .related-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
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
            letter-spacing: 1px;
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
            letter-spacing: 0.5px;
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

        /* Cart Success Modal */
        .cart-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .cart-modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .cart-modal {
            background: white;
            border-radius: 24px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.8) translateY(20px);
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-modal-overlay.show .cart-modal {
            transform: scale(1) translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border: none;
            background: #F0F0F0;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #984216;
            color: white;
            transform: rotate(90deg);
        }

        .modal-icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: bounceIn 0.6s ease;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-icon {
            font-size: 48px;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 800;
            color: #2E7D32;
            text-align: center;
            margin-bottom: 12px;
        }

        .modal-message {
            font-size: 16px;
            color: #666;
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .modal-product-info {
            background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            border: 2px solid #F0F0F0;
        }

        .modal-product-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .modal-product-row:last-child {
            margin-bottom: 0;
            padding-top: 12px;
            border-top: 2px solid #E0E0E0;
        }

        .modal-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .modal-value {
            font-size: 16px;
            color: #333;
            font-weight: 700;
        }

        .modal-value.highlight {
            color: #984216;
            font-size: 18px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .modal-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-btn-continue {
            background: white;
            color: #984216;
            border: 2px solid #984216;
        }

        .modal-btn-continue:hover {
            background: #FFF5F0;
            transform: translateY(-2px);
        }

        .modal-btn-cart {
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(152, 66, 22, 0.3);
        }

        .modal-btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(152, 66, 22, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-gallery {
                position: static;
            }

            .main-image-container {
                height: 500px;
            }

            .product-title {
                font-size: 32px;
            }

            .current-price {
                font-size: 40px;
            }

            .desc-feature-wrapper {
                grid-template-columns: 1fr;
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

            .trust-badges {
                grid-template-columns: 1fr;
            }

            .related-products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        @media (max-width: 480px) {
            .breadcrumb-container {
                font-size: 12px;
            }

            .product-main-section {
                padding: 40px 0;
            }

            .main-image-container {
                height: 320px;
                border-radius: 16px;
            }

            .product-title {
                font-size: 24px;
            }

            .current-price {
                font-size: 32px;
            }

            .related-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="product-detail-page">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <div class="breadcrumb-container">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                <span class="breadcrumb-separator">›</span>
                <a href="{{ url('/category/' . ($product->productCategory->id ?? '#')) }}" class="breadcrumb-link">
                    {{ $product->productCategory->name ?? 'Category' }}
                </a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">{{ $product->name }}</span>
            </div>
        </div>

        <!-- Main Product Section -->
        <div class="product-main-section">
            <div class="product-container">

                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="main-image-container">
                        @php
                            $hasImagesCollection = isset($product->productImages) && $product->productImages->count() > 0;
                        @endphp

                        @if($hasImagesCollection)
                            @php
                                $mainImageRecord = $product->productImages->firstWhere('is_thumbnail', true) ?? $product->productImages->first();
                                $mainImagePath = $mainImageRecord->image ?? null;
                                $imageExists = $mainImagePath && file_exists(public_path($mainImagePath));
                                $mainImageUrl = $imageExists ? asset($mainImagePath) : "https://placehold.co/600x600/E4D6C5/984216?text=" . urlencode(Str::limit($product->name, 20));
                            @endphp
                            <img src="{{ $mainImageUrl }}" alt="{{ $product->name }}" class="main-product-image" id="mainImage">
                        @elseif(isset($product->image) && $product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="main-product-image" id="mainImage">
                        @else
                            <div class="image-placeholder">
                                <span class="placeholder-icon">🍼</span>
                                <p class="placeholder-text">No image available</p>
                            </div>
                        @endif

                        <button class="wishlist-badge" aria-label="Add to wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($hasImagesCollection)
                        <div class="thumbnail-gallery">
                            @foreach($product->productImages as $img)
                                @php
                                    $thumbPath = $img->image;
                                    $thumbExists = $thumbPath && file_exists(public_path($thumbPath));
                                    $thumbUrl = $thumbExists ? asset($thumbPath) : "https://placehold.co/100x100/E4D6C5/984216?text=" . $loop->iteration;
                                @endphp
                                <div class="thumbnail-item {{ ($img->id === ($mainImageRecord->id ?? null)) ? 'active' : '' }}"
                                     onclick="changeMainImage('{{ $thumbUrl }}', this)">
                                    <img src="{{ $thumbUrl }}" alt="Thumbnail {{ $loop->iteration }}">
                                </div>
                            @endforeach
                        </div>
                    @elseif(isset($product->image) && $product->image)
                        <div class="thumbnail-gallery">
                            <div class="thumbnail-item active">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Thumbnail">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info-wrapper">
                    <!-- Category Badge -->
                    <div class="category-tag">
                        <span class="tag-icon">🏷️</span>
                        {{ $product->productCategory->name ?? 'Uncategorized' }}
                    </div>

                    <!-- Product Title -->
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <!-- Rating & Reviews -->
                    <div class="rating-section">
                        <div class="stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star half">★</span>
                        </div>
                        <span class="rating-value">4.8</span>
                        <span class="review-count">(124 reviews)</span>
                        <span class="sold-count">• 350+ sold</span>
                    </div>

                    <!-- Price Section -->
                    <div class="price-section">
                        <div class="current-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="stock-section">
                        @if($product->stock > 0)
                            <div class="stock-badge in-stock">
                                <span class="stock-icon">✓</span>
                                In Stock
                            </div>
                            <span class="stock-count">{{ $product->stock }} items available</span>
                        @else
                            <div class="stock-badge out-of-stock">
                                <span class="stock-icon">✗</span>
                                Out of Stock
                            </div>
                        @endif
                    </div>

                    <!-- Quantity Selector -->
                    <div class="quantity-section">
                        <label class="quantity-label">Quantity:</label>
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="changeQty(-1)" type="button" aria-label="Decrease quantity">
                                −
                            </button>
                            <input type="number" 
                                   id="product-quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock }}"
                                   class="qty-input">
                            <button class="qty-btn" onclick="changeQty(1)" type="button" aria-label="Increase quantity">
                                +
                            </button>
                            <span class="stock-info">{{ $product->stock }} available</span>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button id="add-to-cart-btn"
        data-product-id="{{ $product->id }}"
        class="btn-add-cart"
        {{ $product->stock <= 0 ? 'disabled' : '' }}>
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="9" cy="21" r="1"></circle>
        <circle cx="20" cy="21" r="1"></circle>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
    </svg>
    Add to Cart
</button>


                    <!-- Trust Badges -->
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

        <!-- Store Info -->
        @include('customer.store.store')

        <!-- Description & Features (Side by Side) -->
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <div class="desc-feature-wrapper">
                <!-- Description -->
                @if($product->description)
                    <div class="description-section">
                        <h3 class="section-heading">
                            <span class="heading-icon">📝</span>
                            Description
                        </h3>
                        <p class="description-text">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Features -->
                @if(!empty($product->features) && is_array($product->features))
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
            </div>
        </div>

        <!-- Reviews Section -->
        @include('customer.product.reviews', ['product' => $product])

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
                            <a href="{{ route('product.show', $related->id) }}" class="related-product-card">
                                <div class="related-image-wrapper">
                                    @if(isset($related->productImages) && $related->productImages->count() > 0)
                                        @php
                                            $relatedImage = $related->productImages->firstWhere('is_thumbnail', true) ?? $related->productImages->first();
                                            $relatedImagePath = $relatedImage->image ?? null;
                                            $relatedImageExists = $relatedImagePath && file_exists(public_path($relatedImagePath));
                                        @endphp
                                        <img src="{{ $relatedImageExists ? asset($relatedImagePath) : "https://placehold.co/280x280/E4D6C5/984216?text=" . urlencode(Str::limit($related->name, 15)) }}" 
                                             alt="{{ $related->name }}" 
                                             class="related-image">
                                    @elseif(isset($related->image) && $related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" 
                                             alt="{{ $related->name }}" 
                                             class="related-image">
                                    @else
                                        <div class="related-placeholder">
                                            <span>🍼</span>
                                        </div>
                                    @endif
                                    <div class="related-overlay">
                                        <span class="view-text">View Details</span>
                                    </div>
                                </div>
                                <div class="related-info">
                                    <span class="related-category">{{ $related->productCategory->name ?? 'Category' }}</span>
                                    <h4 class="related-name">{{ Str::limit($related->name, 40) }}</h4>
                                    <div class="related-footer">
                                        <span class="related-price">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                        <button class="related-cart-btn" type="button" aria-label="Add to cart">
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

    <!-- Cart Success Modal -->
    <div class="cart-modal-overlay" id="cartModal">
        <div class="cart-modal">
            <button class="modal-close" onclick="closeCartModal()" aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <div class="modal-icon-wrapper">
                <span class="modal-icon">✓</span>
            </div>

            <h3 class="modal-title">Added to Cart!</h3>
            <p class="modal-message">Your item has been successfully added to your shopping cart.</p>

            <div class="modal-product-info">
                <div class="modal-product-row">
                    <span class="modal-label">Product:</span>
                    <span class="modal-value" id="modalProductName">-</span>
                </div>
                <div class="modal-product-row">
                    <span class="modal-label">Quantity:</span>
                    <span class="modal-value" id="modalQuantity">-</span>
                </div>
                <div class="modal-product-row">
                    <span class="modal-label">Subtotal:</span>
                    <span class="modal-value highlight" id="modalSubtotal">-</span>
                </div>
            </div>

            <div class="modal-actions">
                <button class="modal-btn modal-btn-continue" onclick="closeCartModal()">
                    Continue Shopping
                </button>
                <button class="modal-btn modal-btn-cart" onclick="goToCart()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    View Cart
                </button>
            </div>
        </div>
    </div>

<script>

    document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-to-cart-btn');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const id = this.getAttribute('data-product-id');
            addToCart(id);
        });
    }
});
// Define required URLs and tokens
        const CART_ADD_URL = "{{ route('cart.add') }}";
        const CART_URL = "{{ route('cart.index') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        
        // Change main image
        function changeMainImage(imageSrc, element) {
            const mainImage = document.getElementById('mainImage');
            if (mainImage && imageSrc) {
                mainImage.src = imageSrc;
            }

            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach(function(item) {
                item.classList.remove('active');
            });
            if (element) {
                element.classList.add('active');
            }
        }

        // Quantity selector
        function changeQty(change) {
            const input = document.getElementById('product-quantity');
            if (!input) return;

            let value = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || value;

            value += change;

            if (value < min) value = min;
            if (value > max) value = max;

            input.value = value;
        }

        // Add to cart function
        function addToCart(productId) {
            const quantityInput = document.getElementById('product-quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            const addButton = document.getElementById('add-to-cart-btn');
            
            // Get product data from page
            const productNameElement = document.querySelector('.product-title');
            const productPriceElement = document.querySelector('.current-price');
            
            let productName = 'Product';
            let productPrice = 0;
            
            if (productNameElement) {
                productName = productNameElement.textContent.trim();
            }
            
            if (productPriceElement) {
                const priceText = productPriceElement.textContent.trim();
                productPrice = parseInt(priceText.replace(/[^\d]/g, ''));
            }

            // Disable button during request
            if (addButton) {
                addButton.disabled = true;
                addButton.textContent = 'Adding...';
            }
            
            // Send AJAX request to add to cart
            fetch(CART_ADD_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                // Re-enable button
                if (addButton) {
                    addButton.disabled = false;
                    addButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> Add to Cart';
                }

                if (data.success) {
                    // Show success modal
                    showCartModal(productName, quantity, productPrice);
                    
                    // Update cart count if element exists
                    updateCartCount();
                } else {
                    alert(data.message || 'Failed to add to cart');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                
                // Re-enable button
                if (addButton) {
                    addButton.disabled = false;
                    addButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> Add to Cart';
                }
                
                alert('Failed to add to cart. Please try again.');
            });
        }

        // Update cart count badge
        function updateCartCount() {
            fetch("{{ route('cart.count') }}")
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    const cartBadge = document.querySelector('.cart-count-badge');
                    if (cartBadge && data.count !== undefined) {
                        cartBadge.textContent = data.count;
                        if (data.count > 0) {
                            cartBadge.style.display = 'flex';
                        }
                    }
                })
                .catch(function(error) {
                    console.error('Error updating cart count:', error);
                });
        }

        // Show cart modal
        function showCartModal(productName, quantity, price) {
            const modal = document.getElementById('cartModal');
            const subtotal = quantity * price;

            // Update modal content
            const modalProductName = document.getElementById('modalProductName');
            const modalQuantity = document.getElementById('modalQuantity');
            const modalSubtotal = document.getElementById('modalSubtotal');
            
            if (modalProductName) modalProductName.textContent = productName;
            if (modalQuantity) modalQuantity.textContent = quantity;
            if (modalSubtotal) modalSubtotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

            // Show modal
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        // Close cart modal
        function closeCartModal() {
            const modal = document.getElementById('cartModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        }

        // Go to cart page
        function goToCart() {
            window.location.href = CART_URL;
        }

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal when clicking overlay
            const cartModal = document.getElementById('cartModal');
            if (cartModal) {
                cartModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCartModal();
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCartModal();
                }
            });

            // Input validation
            const qtyInput = document.getElementById('product-quantity');
            if (qtyInput) {
                qtyInput.addEventListener('input', function() {
                    let value = parseInt(this.value);
                    let min = parseInt(this.min) || 1;
                    let max = parseInt(this.max) || value;

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