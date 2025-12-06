@extends('layouts.app')

@section('title', $product->name . ' - SORAE')

@section('styles')
<style>
    .product-gallery {
        position: sticky;
        top: 20px;
    }
    
    .main-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 15px;
    }
    
    .thumbnail-images {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    
    .thumbnail {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .thumbnail:hover,
    .thumbnail.active {
        border-color: var(--primary-color);
    }
    
    .product-detail-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .product-price-large {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin: 20px 0;
    }
    
    .store-info {
        background: var(--secondary-color);
        border-radius: 10px;
        padding: 15px;
        margin: 20px 0;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 1.2rem;
    }
    
    .review-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .qty-input {
        width: 100px;
        text-align: center;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Product Images -->
    <div class="col-lg-6 mb-4">
        <div class="product-gallery">
            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/500' }}" 
                 alt="{{ $product->name }}" 
                 class="main-image" 
                 id="mainImage">
            
            @if($product->images->count() > 1)
            <div class="thumbnail-images">
                @foreach($product->images as $index => $image)
                <img src="{{ asset('storage/' . $image->image) }}" 
                     alt="{{ $product->name }}" 
                     class="thumbnail {{ $index == 0 ? 'active' : '' }}" 
                     onclick="changeImage('{{ asset('storage/' . $image->image) }}', this)">
                @endforeach
            </div>
            @endif
        </div>
    </div>
    
    <!-- Product Details -->
    <div class="col-lg-6">
        <div class="product-detail-card">
            <!-- Category Badge -->
            <span class="badge" style="background: var(--secondary-color); color: var(--primary-color); font-size: 1rem; padding: 8px 20px;">
                {{ $product->category->name ?? 'Uncategorized' }}
            </span>
            
            <!-- Product Title -->
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="mb-3">
                <span class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $averageRating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </span>
                <span class="ms-2 text-muted">
                    ({{ number_format($averageRating, 1) }} / {{ $totalReviews }} reviews)
                </span>
            </div>
            
            <!-- Store Info -->
            <div class="store-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block">Sold by</small>
                        <strong style="color: var(--primary-color); font-size: 1.2rem;">
                            <i class="fas fa-store"></i> {{ $product->store->name ?? 'Unknown Store' }}
                        </strong>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm">Visit Store</a>
                </div>
            </div>
            
            <!-- Price -->
            <div class="product-price-large">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
            
            <!-- Stock -->
            <p class="mb-3">
                <strong>Stock:</strong> 
                <span class="badge bg-success">{{ $product->stock }} available</span>
            </p>
            
            <!-- Condition -->
            <p class="mb-3">
                <strong>Condition:</strong> 
                <span class="badge" style="background: var(--secondary-color); color: var(--primary-color);">
                    {{ ucfirst($product->condition) }}
                </span>
            </p>
            
            <!-- Quantity and Add to Cart -->
            @auth
                @if(auth()->user()->role === 'buyer')
                <form action="{{ url('/checkout') }}" method="GET">
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <label class="form-label fw-bold">Quantity:</label>
                            <input type="number" name="quantity" class="form-control qty-input" 
                                   value="1" min="1" max="{{ $product->stock }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart"></i> Buy Now
                        </button>
                    </div>
                </form>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Please <a href="{{ url('/login') }}" class="alert-link">login</a> to purchase this product.
                </div>
            @endauth
            
            <!-- Description -->
            <hr class="my-4">
            <h4 style="color: var(--primary-color); font-weight: 700;">Product Description</h4>
            <p class="text-muted" style="text-align: justify;">{{ $product->about }}</p>
            
            <!-- Specifications -->
            <h5 class="mt-4 fw-bold" style="color: var(--primary-color);">Specifications</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Weight</th>
                    <td>{{ $product->weight }} gram</td>
                </tr>
                <tr>
                    <th>Condition</th>
                    <td>{{ ucfirst($product->condition) }}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ $product->stock }} pcs</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="mt-5">
    <div class="product-detail-card">
        <h3 style="color: var(--primary-color); font-weight: 700; margin-bottom: 30px;">
            <i class="fas fa-star"></i> Customer Reviews ({{ $totalReviews }})
        </h3>
        
        @forelse($product->reviews as $review)
        <div class="review-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <strong style="color: var(--primary-color);">
                        {{ $review->buyer->user->name ?? 'Anonymous' }}
                    </strong>
                    <div class="rating-stars small">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-0 text-muted">{{ $review->review }}</p>
        </div>
        @empty
        <div class="text-center py-4">
            <i class="fas fa-comment-slash" style="font-size: 3rem; color: var(--secondary-color);"></i>
            <p class="text-muted mt-3">No reviews yet. Be the first to review this product!</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<div class="mt-5">
    <h3 style="color: var(--primary-color); font-weight: 700; margin-bottom: 30px;">
        Related Products
    </h3>
    <div class="row g-4">
        @foreach($relatedProducts as $related)
        <div class="col-md-6 col-lg-3">
            <div class="product-card">
                <img src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->image) : 'https://via.placeholder.com/300' }}" 
                     alt="{{ $related->name }}" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">{{ $related->name }}</h3>
                    <p class="product-price">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                    <a href="{{ url('/products/' . $related->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>
@endsection