<x-app-layout>
<x-slot name="title">My Orders - SORAÉ</x-slot>

<style>
.transactions-page {
    padding: 60px 0;
    min-height: 70vh;
}

.page-header {
    margin-bottom: 40px;
}

.page-header h1 {
    font-size: 3rem;
    color: var(--color-primary);
    margin-bottom: 10px;
}

.filter-tabs {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    border-bottom: 2px solid var(--color-light);
    flex-wrap: wrap;
}

.filter-tab {
    padding: 15px 25px;
    text-decoration: none;
    color: var(--color-tertiary);
    font-weight: 600;
    border-bottom: 3px solid transparent;
    transition: all 0.3s;
}

.filter-tab:hover,
.filter-tab.active {
    color: var(--color-primary);
    border-bottom-color: var(--color-primary);
}

.transactions-list {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.transaction-card {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(86, 28, 36, 0.1);
    transition: transform 0.3s;
}

.transaction-card:hover {
    transform: translateY(-5px);
}

.transaction-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--color-light);
}

.transaction-id {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-primary);
    margin-bottom: 5px;
}

.transaction-date {
    color: var(--color-tertiary);
    font-size: 0.9rem;
}

.status-badge {
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-processing {
    background: #cfe2ff;
    color: #084298;
}

.status-shipped {
    background: #cff4fc;
    color: #055160;
}

.status-completed {
    background: #d1e7dd;
    color: #0f5132;
}

.status-cancelled {
    background: #f8d7da;
    color: #842029;
}

.transaction-items {
    margin-bottom: 20px;
}

.item-row {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--color-light);
}

.item-row:last-child {
    border-bottom: none;
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

.transaction-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid var(--color-light);
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-primary);
}

.action-buttons {
    display: flex;
    gap: 10px;
}

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
    .transaction-header,
    .transaction-footer {
        flex-direction: column;
        gap: 15px;
    }
    
    .action-buttons {
        width: 100%;
    }
    
    .action-buttons button,
    .action-buttons a {
        flex: 1;
    }
}
</style>

<div class="transactions-page">
    <div class="container" style="max-width: 1000px;">
        <div class="page-header">
            <h1>My Orders</h1>
            <p style="color: var(--color-secondary);">Track and manage your orders</p>
        </div>
        
        <div class="filter-tabs">
            <a href="{{ route('transactions.index') }}" class="filter-tab active">
                All Orders
            </a>
            <a href="{{ route('transactions.index') }}?status=pending" class="filter-tab">
                Pending
            </a>
            <a href="{{ route('transactions.index') }}?status=processing" class="filter-tab">
                Processing
            </a>
            <a href="{{ route('transactions.index') }}?status=shipped" class="filter-tab">
                Shipped
            </a>
            <a href="{{ route('transactions.index') }}?status=completed" class="filter-tab">
                Completed
            </a>
        </div>
        
        <div class="transactions-list">
            <!-- Demo Transaction 1 -->
            <div class="transaction-card">
                <div class="transaction-header">
                    <div>
                        <div class="transaction-id">#ORDER-001</div>
                        <div class="transaction-date">December 1, 2024 at 10:30 AM</div>
                    </div>
                    <span class="status-badge status-processing">Processing</span>
                </div>
                
                <div class="transaction-items">
                    <div class="item-row">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Premium Cotton T-Shirt</div>
                            <div class="item-quantity">Quantity: 2 × Rp 150,000</div>
                        </div>
                        <div class="item-price">Rp 300,000</div>
                    </div>
                    <div class="item-row">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Elegant Summer Dress</div>
                            <div class="item-quantity">Quantity: 1 × Rp 350,000</div>
                        </div>
                        <div class="item-price">Rp 350,000</div>
                    </div>
                </div>
                
                <div class="transaction-footer">
                    <div class="total-amount">
                        Total: Rp 741,500
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-secondary">Track Order</a>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Demo Transaction 2 -->
            <div class="transaction-card">
                <div class="transaction-header">
                    <div>
                        <div class="transaction-id">#ORDER-002</div>
                        <div class="transaction-date">November 28, 2024 at 2:15 PM</div>
                    </div>
                    <span class="status-badge status-completed">Completed</span>
                </div>
                
                <div class="transaction-items">
                    <div class="item-row">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Leather Messenger Bag</div>
                            <div class="item-quantity">Quantity: 1 × Rp 750,000</div>
                        </div>
                        <div class="item-price">Rp 750,000</div>
                    </div>
                </div>
                
                <div class="transaction-footer">
                    <div class="total-amount">
                        Total: Rp 770,000
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-secondary">Write Review</a>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Demo Transaction 3 -->
            <div class="transaction-card">
                <div class="transaction-header">
                    <div>
                        <div class="transaction-id">#ORDER-003</div>
                        <div class="transaction-date">November 25, 2024 at 4:45 PM</div>
                    </div>
                    <span class="status-badge status-shipped">Shipped</span>
                </div>
                
                <div class="transaction-items">
                    <div class="item-row">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" class="item-image">
                        <div class="item-details">
                            <div class="item-name">Winter Wool Coat</div>
                            <div class="item-quantity">Quantity: 1 × Rp 850,000</div>
                        </div>
                        <div class="item-price">Rp 850,000</div>
                    </div>
                </div>
                
                <div class="transaction-footer">
                    <div class="total-amount">
                        Total: Rp 870,000
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-secondary">Track Shipment</a>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Empty State (Hidden when there are transactions) -->
        <!-- <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h3 style="color: var(--color-primary); margin-bottom: 15px;">No Orders Yet</h3>
            <p style="color: var(--color-secondary); margin-bottom: 25px;">Start shopping and your orders will appear here</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
        </div> -->
    </div>
</div>
</x-app-layout>