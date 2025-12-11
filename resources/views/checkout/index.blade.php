@extends('layouts.app')

@section('title', 'Checkout - SORAE')

@section('content')
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-shipping-fast"></i> Shipping Information</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('/checkout/process') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Full Address</label>
                        <textarea name="address" class="form-control" rows="3" required
                                  placeholder="Enter your complete address"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required
                                   placeholder="City name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" required
                                   placeholder="Postal code">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Shipping Method</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card shipping-option" onclick="selectShipping('regular')">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="shipping_type" value="regular" 
                                                   id="shipping_regular" checked>
                                            <label class="form-check-label w-100" for="shipping_regular">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>Regular</strong>
                                                        <p class="text-muted small mb-0">3-5 business days</p>
                                                    </div>
                                                    <div>
                                                        <strong class="text-primary">Rp 20.000</strong>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shipping-option" onclick="selectShipping('express')">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="shipping_type" value="express" 
                                                   id="shipping_express">
                                            <label class="form-check-label w-100" for="shipping_express">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>Express</strong>
                                                        <p class="text-muted small mb-0">1-2 business days</p>
                                                    </div>
                                                    <div>
                                                        <strong class="text-primary">Rp 50.000</strong>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card position-sticky" style="top: 20px;">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Order Summary</h4>
            </div>
            <div class="card-body">
                <!-- Product Info -->
                <div class="d-flex mb-3">
                    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/80' }}" 
                         alt="{{ $product->name }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                    <div class="ms-3">
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <p class="text-muted small mb-1">Quantity: {{ $quantity }}</p>
                        <p class="fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <hr>
                
                <!-- Price Details -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span id="shipping">Rp 20.000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (10%)</span>
                        <span id="tax">Rp {{ number_format($subtotal * 0.10, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong style="font-size: 1.2rem;">Total</strong>
                        <strong style="font-size: 1.2rem; color: var(--primary-color);" id="grandTotal">
                            Rp {{ number_format($subtotal + 20000 + ($subtotal * 0.10), 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
                
                <button type="submit" form="checkoutForm" class="btn btn-primary w-100 btn-lg">
                    <i class="fas fa-check"></i> Place Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const subtotal = {{ $subtotal }};
    
    function selectShipping(type) {
        const shippingCost = type === 'express' ? 50000 : 20000;
        const tax = subtotal * 0.10;
        const grandTotal = subtotal + shippingCost + tax;
        
        document.getElementById('shipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('grandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        
        // Check the radio button
        document.getElementById('shipping_' + type).checked = true;
    }
</script>

<style>
    .shipping-option {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
    }
    
    .shipping-option:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(86, 28, 36, 0.1);
    }
    
    .shipping-option:has(input:checked) {
        border-color: var(--primary-color);
        background-color: rgba(86, 28, 36, 0.05);
    }
</style>
@endsection