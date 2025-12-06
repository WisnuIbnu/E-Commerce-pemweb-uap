<x-app-layout>
<x-slot name="title">Checkout - SORAÉ</x-slot>

<style>
.checkout-page {
    padding: 60px 0;
}

.checkout-header {
    text-align: center;
    margin-bottom: 50px;
}

.checkout-header h1 {
    font-size: 3rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.checkout-steps {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 40px 0;
}

.step {
    display: flex;
    align-items: center;
    gap: 10px;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-tertiary);
    color: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.step.active .step-number {
    background: var(--color-primary);
}

.step-label {
    color: var(--color-tertiary);
}

.step.active .step-label {
    color: var(--color-primary);
    font-weight: 600;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.checkout-form {
    background: var(--color-white);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(86, 28, 36, 0.1);
}

.form-section {
    margin-bottom: 35px;
}

.section-title {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--color-light);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.order-summary {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(86, 28, 36, 0.1);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.summary-title {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin-bottom: 25px;
}

.cart-items {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 25px;
}

.cart-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--color-light);
}

.item-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    background: var(--color-light);
}

.item-details {
    flex: 1;
}

.item-name {
    font-weight: 600;
    color: var(--color-primary);
    margin-bottom: 5px;
}

.item-quantity {
    color: var(--color-tertiary);
    font-size: 0.9rem;
}

.item-price {
    font-weight: 600;
    color: var(--color-secondary);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    color: var(--color-secondary);
}

.summary-row.total {
    border-top: 2px solid var(--color-light);
    margin-top: 15px;
    padding-top: 15px;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-primary);
}

.payment-methods {
    display: grid;
    gap: 15px;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border: 2px solid var(--color-tertiary);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-option:hover {
    border-color: var(--color-primary);
    background: var(--color-light);
}

.payment-option input[type="radio"] {
    width: 20px;
    height: 20px;
}

.payment-icon {
    font-size: 2rem;
}

.payment-info {
    flex: 1;
}

.payment-name {
    font-weight: 600;
    color: var(--color-primary);
    margin-bottom: 3px;
}

.payment-desc {
    font-size: 0.85rem;
    color: var(--color-tertiary);
}

@media (max-width: 968px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
    
    .order-summary {
        position: static;
    }
    
    .checkout-steps {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<div class="checkout-page">
    <div class="container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <div class="checkout-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <span class="step-label">Shipping</span>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <span class="step-label">Payment</span>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <span class="step-label">Confirmation</span>
                </div>
            </div>
        </div>
        
        <div class="checkout-container">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    
                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h2 class="section-title">Shipping Information</h2>
                        <div class="form-group">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="name" class="form-input" 
                                   value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Phone Number</label>
                            <input type="tel" name="phone" class="form-input" 
                                   value="{{ auth()->user()->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" class="form-input" 
                                   value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Shipping Address</label>
                            <textarea name="address" class="form-textarea" rows="4" 
                                      placeholder="Complete address with street, city, province, and postal code" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">City</label>
                                <input type="text" name="city" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label required">Postal Code</label>
                                <input type="text" name="postal_code" class="form-input" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2 class="section-title">Payment Method</h2>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer" checked>
                                <div class="payment-icon">🏦</div>
                                <div class="payment-info">
                                    <div class="payment-name">Bank Transfer</div>
                                    <div class="payment-desc">Transfer to our bank account</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card">
                                <div class="payment-icon">💳</div>
                                <div class="payment-info">
                                    <div class="payment-name">Credit/Debit Card</div>
                                    <div class="payment-desc">Visa, Mastercard, JCB</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="e-wallet">
                                <div class="payment-icon">📱</div>
                                <div class="payment-info">
                                    <div class="payment-name">E-Wallet</div>
                                    <div class="payment-desc">GoPay, OVO, Dana, ShopeePay</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod">
                                <div class="payment-icon">💵</div>
                                <div class="payment-info">
                                    <div class="payment-name">Cash on Delivery</div>
                                    <div class="payment-desc">Pay when you receive</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    <div class="form-section">
                        <h2 class="section-title">Order Notes (Optional)</h2>
                        <div class="form-group">
                            <textarea name="notes" class="form-textarea" rows="3" 
                                      placeholder="Any special instructions for your order?"></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                        Place Order →
                    </button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="order-summary">
                <h2 class="summary-title">Order Summary</h2>
                
                <div class="cart-items">
                    <!-- Demo Cart Items -->
                    <div class="cart-item">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Premium Cotton T-Shirt</div>
                            <div class="item-quantity">Qty: 2 × Rp 150,000</div>
                        </div>
                        <div class="item-price">Rp 300,000</div>
                    </div>
                    
                    <div class="cart-item">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Elegant Summer Dress</div>
                            <div class="item-quantity">Qty: 1 × Rp 350,000</div>
                        </div>
                        <div class="item-price">Rp 350,000</div>
                    </div>
                </div>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp 650,000</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Rp 20,000</span>
                </div>
                <div class="summary-row">
                    <span>Tax (11%)</span>
                    <span>Rp 71,500</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp 741,500</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>