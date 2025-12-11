@extends('layouts.app')

@section('title', 'My Products - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

/* Reuse seller sidebar styles */
.seller-sidebar {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.store-header {
    text-align: center;
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid var(--border);
    margin-bottom: var(--spacing-lg);
}

.store-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto var(--spacing-md);
    border: 3px solid var(--border);
}

.store-name {
    font-weight: 600;
    margin-bottom: var(--spacing-xs);
}

.seller-nav {
    list-style: none;
}

.seller-nav-item {
    margin-bottom: var(--spacing-xs);
}

.seller-nav-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: 10px 12px;
    border-radius: var(--radius-md);
    color: var(--dark);
    text-decoration: none;
    transition: all 0.2s;
    font-size: 14px;
}

.seller-nav-link:hover,
.seller-nav-link.active {
    background: var(--primary-light);
    color: var(--primary);
}

.products-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.products-table-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.table-wrapper {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
}

.products-table thead {
    background: var(--light-gray);
}

.products-table th {
    padding: var(--spacing-md);
    text-align: left;
    font-weight: 600;
    font-size: 14px;
    color: var(--dark);
    border-bottom: 2px solid var(--border);
}

.products-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid var(--border);
}

.products-table tbody tr:hover {
    background: var(--light-gray);
}

.product-cell {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.product-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--radius-md);
    background: var(--light-gray);
}

.product-info-cell h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.product-category {
    font-size: 12px;
    color: var(--gray);
}

.action-buttons {
    display: flex;
    gap: var(--spacing-xs);
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: var(--white);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-size: 14px;
}

.btn-icon:hover {
    background: var(--light-gray);
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--gray);
}

.empty-icon {
    font-size: 64px;
    margin-bottom: var(--spacing-md);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .seller-sidebar {
        position: static;
    }
    
    .page-header {
        flex-direction: column;
        align-items: stretch;
        gap: var(--spacing-md);
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="seller-layout">
        <!-- Sidebar -->
        @include('seller.partials.sidebar', ['activeMenu' => 'products'])

        <!-- Main Content -->
        <main class="products-content">
            <div class="page-header">
                <h1>📦 My Products</h1>
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                    ➕ Add New Product
                </a>
            </div>

            <div class="products-table-card">
                @if($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h3>No products yet</h3>
                        <p>Start adding products to your store</p>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-md);">
                            ➕ Add Your First Product
                        </a>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Condition</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="product-cell">
                                                <img 
                                                    src="{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image) : asset('images/default-product.png') }}" 
                                                    alt="{{ $product->name }}"
                                                    class="product-thumbnail">
                                                <div class="product-info-cell">
                                                    <h4>{{ $product->name }}</h4>
                                                    <div class="product-category">
                                                        {{ $product->productCategory->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            @if($product->stock <= 5)
                                                <span class="badge badge-danger">{{ $product->stock }} left</span>
                                            @else
                                                <span class="badge badge-success">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($product->condition) }}</span>
                                        </td>
                                        <td>
                                            @if($product->stock > 0)
                                                <span class="badge badge-success">✓ Available</span>
                                            @else
                                                <span class="badge badge-danger">✗ Out of Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn-icon" title="View">
                                                    👁️
                                                </a>
                                                <a href="{{ route('seller.products.edit', $product) }}" class="btn-icon" title="Edit">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('seller.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon" title="Delete">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="padding: var(--spacing-lg);">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection