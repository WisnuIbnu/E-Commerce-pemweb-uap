@extends('layouts.app')

@section('title', 'Orders - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.orders-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

.stats-mini {
    display: flex;
    gap: var(--spacing-md);
    background: var(--white);
    padding: var(--spacing-md);
    border-radius: var(--radius-lg);
}

.stat-mini {
    flex: 1;
    text-align: center;
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
    background: var(--light-gray);
}

.stat-mini-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
}

.stat-mini-label {
    font-size: 12px;
    color: var(--gray);
}

.filter-tabs {
    display: flex;
    gap: var(--spacing-sm);
    background: var(--white);
    padding: var(--spacing-md);
    border-radius: var(--radius-lg);
}

.filter-tab {
    padding: 8px 16px;
    border: 1px solid var(--border);
    background: var(--white);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    text-decoration: none;
    color: var(--dark);
}

.filter-tab:hover,
.filter-tab.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.order-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s;
}

.order-card:hover {
    box-shadow: var(--shadow-lg);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: var(--spacing-md);
    border-bottom: 1px solid var(--border);
    margin-bottom: var(--spacing-md);
}

.order-code {
    font-weight: 600;
    font-size: 16px;
    color: var(--primary);
}

.order-date {
    font-size: 12px;
    color: var(--gray);
}

.order-customer {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-md);
}

.order-items-preview {
    display: flex;
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-md);
}

.order-item-preview {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.item-preview-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: var(--radius-md);
    background: var(--light-gray);
}

.item-preview-info {
    font-size: 14px;
}

.item-preview-name {
    font-weight: 500;
    margin-bottom: 2px;
}

.item-preview-qty {
    font-size: 12px;
    color: var(--gray);
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: var(--spacing-md);
    border-top: 1px solid var(--border);
}

.order-total {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
}

.empty-state {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-2xl);
    text-align: center;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: var(--spacing-md);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .stats-mini {
        flex-direction: column;
    }
    
    .filter-tabs {
        flex-wrap: wrap;
    }
    
    .order-footer {
        flex-direction: column;
        gap: var(--spacing-md);
        align-items: stretch;
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
        <main class="orders-content">
            <div class="page-header">
                <h1>🛒 Orders</h1>
            </div>

            <!-- Statistics -->
            <div class="stats-mini">
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $totalOrders }}</div>
                    <div class="stat-mini-label">Total Orders</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $paidOrders }}</div>
                    <div class="stat-mini-label">Paid</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $unpaidOrders }}</div>
                    <div class="stat-mini-label">Unpaid</div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="{{ route('seller.orders.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    All Orders
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'paid']) }}" class="filter-tab {{ request('status') == 'paid' ? 'active' : '' }}">
                    Paid
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'unpaid']) }}" class="filter-tab {{ request('status') == 'unpaid' ? 'active' : '' }}">
                    Unpaid
                </a>
            </div>

            <!-- Orders List -->
            @if($orders->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🛒</div>
                    <h3>No orders yet</h3>
                    <p style="color: var(--gray);">Orders from customers will appear here</p>
                </div>
            @else
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="order-card">
                            <!-- Header -->
                            <div class="order-header">
                                <div>
                                    <div class="order-code">{{ $order->code }}</div>
                                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                @if($order->payment_status === 'paid')
                                    <span class="badge badge-success">✓ Paid</span>
                                @else
                                    <span class="badge badge-warning">⏳ Unpaid</span>
                                @endif
                            </div>

                            <!-- Customer Info -->
                            <div class="order-customer">
                                <span>👤</span>
                                <span><strong>{{ $order->buyer->user->name }}</strong></span>
                                <span style="color: var(--gray);">•</span>
                                <span style="color: var(--gray); font-size: 14px;">{{ $order->buyer->user->email }}</span>
                            </div>

                            <!-- Items Preview -->
                            <div class="order-items-preview">
                                @foreach($order->transactionDetails->take(3) as $detail)
                                    <div class="order-item-preview">
                                        <img 
                                            src="{{ $detail->product->productImages->first() ? asset('storage/' . $detail->product->productImages->first()->image) : asset('images/default-product.png') }}" 
                                            alt="{{ $detail->product->name }}"
                                            class="item-preview-image">
                                        <div class="item-preview-info">
                                            <div class="item-preview-name">{{ $detail->product->name }}</div>
                                            <div class="item-preview-qty">Qty: {{ $detail->qty }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if($order->transactionDetails->count() > 3)
                                    <div style="display: flex; align-items: center; color: var(--gray); font-size: 14px;">
                                        +{{ $order->transactionDetails->count() - 3 }} more
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="order-footer">
                                <div>
                                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Total</div>
                                    <div class="order-total">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                </div>

                                <a href="{{ route('seller.orders.show', $order) }}" class="btn btn-primary">
                                    📋 View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $orders->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection