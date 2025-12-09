@extends('layouts.app')

@section('title', 'Order Detail - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.order-detail-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.breadcrumb {
    display: flex;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-md);
    font-size: 14px;
    color: var(--gray);
}

.breadcrumb a {
    color: var(--gray);
}

.breadcrumb a:hover {
    color: var(--primary);
}

.detail-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-sm);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-md);
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-size: 18px;
    font-weight: 600;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-lg);
}

.info-item {
    padding: var(--spacing-md);
    background: var(--light-gray);
    border-radius: var(--radius-md);
}

.info-label {
    font-size: 12px;
    color: var(--gray);
    margin-bottom: 4px;
}

.info-value {
    font-weight: 600;
}

.product-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.product-item {
    display: flex;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius-md);
    background: var(--light-gray);
}

.product-info {
    flex: 1;
}

.product-name {
    font-weight: 600;
    margin-bottom: 4px;
}

.product-details {
    font-size: 14px;
    color: var(--gray);
}

.product-price {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary);
    text-align: right;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: var(--spacing-sm) 0;
    font-size: 14px;
}

.summary-row.total {
    font-size: 18px;
    font-weight: 700;
    padding-top: var(--spacing-md);
    border-top: 2px solid var(--border);
    color: var(--primary);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="seller-layout">
        <!-- Sidebar -->
        @include('seller.partials.sidebar', ['activeMenu' => 'orders'])

        <!-- Main Content -->
        <main class="order-detail-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('seller.dashboard') }}">Dashboard</a>
                <span>›</span>
                <a href="{{ route('seller.orders.index') }}">Orders</a>
                <span>›</span>
                <span>{{ $transaction->code }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1>📦 Order Details</h1>
                @if($transaction->payment_status === 'paid')
                    <span class="badge badge-success" style="font-size: 16px; padding: 8px 16px;">✓ Paid</span>
                @else
                    <span class="badge badge-warning" style="font-size: 16px; padding: 8px 16px;">⏳ Unpaid</span>
                @endif
            </div>

            <!-- Order Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">📋 Order Information</h2>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Order Number</div>
                        <div class="info-value">{{ $transaction->code }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Order Date</div>
                        <div class="info-value">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Customer Name</div>
                        <div class="info-value">{{ $transaction->buyer->user->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Customer Email</div>
                        <div class="info-value">{{ $transaction->buyer->user->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Payment Status</div>
                        <div class="info-value">
                            @if($transaction->payment_status === 'paid')
                                <span class="badge badge-success">Paid</span>
                            @else
                                <span class="badge badge-warning">Unpaid</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Shipping Method</div>
                        <div class="info-value">{{ ucfirst(str_replace('_', ' ', $transaction->shipping_type)) }}</div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">📍 Shipping Address</h2>
                </div>

                <p style="line-height: 1.8;">
                    <strong>{{ $transaction->address_id }}</strong><br>
                    {{ $transaction->address }}<br>
                    {{ $transaction->city }}, {{ $transaction->postal_code }}
                </p>
            </div>

            <!-- Order Items -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">🛍️ Order Items</h2>
                </div>

                <div class="product-list">
                    @foreach($transaction->transactionDetails as $detail)
                        <div class="product-item">
                            <img 
                                src="{{ $detail->product->productImages->first() ? asset('storage/' . $detail->product->productImages->first()->image) : asset('images/default-product.png') }}" 
                                alt="{{ $detail->product->name }}"
                                class="product-image">
                            
                            <div class="product-info">
                                <div class="product-name">{{ $detail->product->name }}</div>
                                <div class="product-details">
                                    Quantity: {{ $detail->qty }} × Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">💰 Order Summary</h2>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->grand_total - $transaction->tax - $transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div class="summary-row">
                    <span>Tax (10%)</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>

                <div class="summary-row">
                    <span>Shipping Cost</span>
                    <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Tracking Number -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">🚚 Shipping Information</h2>
                </div>

                <form method="POST" action="{{ route('seller.orders.update', $transaction) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="tracking_number" class="form-label">Tracking Number</label>
                        <input 
                            type="text" 
                            id="tracking_number" 
                            name="tracking_number" 
                            value="{{ old('tracking_number', $transaction->tracking_number) }}"
                            class="form-control @error('tracking_number') error @enderror"
                            placeholder="Enter shipping tracking number">
                        @error('tracking_number')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-md">
                        <button type="submit" class="btn btn-primary">
                            💾 Update Tracking
                        </button>
                        <a href="{{ route('seller.orders.index') }}" class="btn btn-outline">
                            ← Back to Orders
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection