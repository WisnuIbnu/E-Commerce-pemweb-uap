<!-- resources/views/seller/dashboard.blade.php -->
<x-seller-layout>
<x-slot name="title">Seller Dashboard - SORAÉ</x-slot>

<style>
.dashboard-header {
    margin-bottom: 40px;
}

.dashboard-header h1 {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 10px;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 20px;
}

.stat-label {
    color: var(--color-tertiary);
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--color-primary);
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.dashboard-section {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--color-light);
}

.section-header h2 {
    font-size: 1.5rem;
    color: var(--color-primary);
}

.order-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.order-item {
    padding: 20px;
    background: var(--color-light);
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.3s;
}

.order-item:hover {
    background: var(--color-tertiary);
}

.order-info h4 {
    color: var(--color-primary);
    margin-bottom: 5px;
}

.order-info p {
    font-size: 0.9rem;
    color: var(--color-secondary);
}

.order-amount {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-primary);
}

.product-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: var(--color-light);
    border-radius: 10px;
}

.product-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.product-info {
    flex: 1;
}

.product-info h4 {
    color: var(--color-primary);
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.stock-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.stock-low {
    background: #fff3cd;
    color: #856404;
}

.stock-critical {
    background: #f8d7da;
    color: #721c24;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--color-tertiary);
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

@media (max-width: 968px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-header">
    <h1>Dashboard</h1>
    <p style="color: var(--color-secondary);">Welcome back, {{ $store->name }}!</p>
</div>

<!-- Statistics Cards -->
<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🛒</div>
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $totalOrders }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-label">Pending Orders</div>
        <div class="stat-value">{{ $pendingOrders }}</div>
    </div>
</div>

<!-- Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Recent Orders -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Recent Orders</h2>
            <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary">View All</a>
        </div>

        <div class="order-list">
            @forelse($recentOrders as $order)
                <a href="{{ route('seller.orders.show', $order) }}" class="order-item" style="text-decoration: none; color: inherit;">
                    <div class="order-info">
                        <h4>#{{ $order->id }} - {{ $order->buyer->name }}</h4>
                        <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="order-amount">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No orders yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Low Stock Alert</h2>
        </div>

        <div class="product-list">
            @forelse($lowStockProducts as $product)
                <div class="product-item">
                    <img src="{{ $product->images->first()?->image_url ?? asset('images/placeholder.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="product-image">
                    <div class="product-info">
                        <h4>{{ $product->name }}</h4>
                        <span class="stock-badge {{ $product->stock < 5 ? 'stock-critical' : 'stock-low' }}">
                            {{ $product->stock }} left
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <p>All products have sufficient stock</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="dashboard-section">
    <div class="section-header">
        <h2>Quick Actions</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">➕</div>
            <div>Add Product</div>
        </a>

        <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
            <div>Manage Orders</div>
        </a>

        <a href="{{ route('seller.balance.index') }}" class="btn btn-secondary" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">💰</div>
            <div>View Balance</div>
        </a>

        <a href="{{ route('seller.store.edit') }}" class="btn btn-secondary" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">⚙️</div>
            <div>Store Settings</div>
        </a>
    </div>
</div>

</x-seller-layout>
