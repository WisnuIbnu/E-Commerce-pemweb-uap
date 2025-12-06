
<!-- resources/views/seller/products/edit.blade.php -->
<x-seller-layout>
<x-slot name="title">Edit Product - SORAÉ</x-slot>

<style>
.product-form {
    max-width: 900px;
    background: var(--color-white);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.image-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 8px;
    overflow: hidden;
}

.image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.delete-image-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 16px;
}

.upload-btn {
    border: 2px dashed var(--color-tertiary);
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}

.upload-btn:hover {
    border-color: var(--color-primary);
    background: var(--color-light);
}
</style>

<div style="margin-bottom: 30px;">
    <a href="{{ route('seller.products.index') }}" style="color: var(--color-secondary); text-decoration: none;">
        ← Back to Products
    </a>
</div>

<div class="product-form">
    <h1 style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 30px;">
        Edit Product
    </h1>

    <form method="POST" action="{{ route('seller.products.update', $product) }}">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h2 class="form-section-title">Basic Information</h2>
            
            <div class="form-group">
                <label class="form-label required">Product Name</label>
                <input type="text" name="name" class="form-input" 
                       value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label required">Season</label>
                    <select name="season" class="form-select" required>
                        <option value="all" {{ old('season', $product->season) == 'all' ? 'selected' : '' }}>All Season</option>
                        <option value="summer" {{ old('season', $product->season) == 'summer' ? 'selected' : '' }}>Summer</option>
                        <option value="winter" {{ old('season', $product->season) == 'winter' ? 'selected' : '' }}>Winter</option>
                        <option value="spring" {{ old('season', $product->season) == 'spring' ? 'selected' : '' }}>Spring</option>
                        <option value="fall" {{ old('season', $product->season) == 'fall' ? 'selected' : '' }}>Fall</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Description</label>
                <textarea name="description" class="form-textarea" required>{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h2 class="form-section-title">Pricing & Inventory</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Price (Rp)</label>
                    <input type="number" name="price" class="form-input" 
                           value="{{ old('price', $product->price) }}" 
                           min="0" step="1000" required>
                </div>

                <div class="form-group">
                    <label class="form-label required">Stock</label>
                    <input type="number" name="stock" class="form-input" 
                           value="{{ old('stock', $product->stock) }}" 
                           min="0" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            💾 Update Product
        </button>
    </form>

    <!-- Product Images Management -->
    <div class="form-section" style="margin-top: 40px;">
        <h2 class="form-section-title">Product Images</h2>
        
        <div class="image-grid">
            @foreach($product->images as $image)
                <div class="image-item">
                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $product->name }}">
                    <form method="POST" action="{{ route('seller.products.images.destroy', $image) }}" 
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-image-btn" 
                                onclick="return confirm('Delete this image?')">
                            ×
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('seller.products.images.store', $product) }}" 
              enctype="multipart/form-data">
            @csrf
            <input type="file" name="images[]" id="new-images" accept="image/*" multiple style="display: none;">
            <label for="new-images" class="upload-btn">
                <div style="font-size: 2rem; margin-bottom: 10px;">📷</div>
                <p style="color: var(--color-primary); font-weight: 600;">Upload More Images</p>
            </label>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px;">
                Upload Selected Images
            </button>
        </form>
    </div>
</div>

</x-seller-layout>

<!-- resources/views/seller/orders/index.blade.php -->
<x-seller-layout>
<x-slot name="title">Orders - SORAÉ</x-slot>

<style>
.filter-tabs {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    border-bottom: 2px solid var(--color-light);
}

.filter-tab {
    padding: 15px 25px;
    border: none;
    background: transparent;
    color: var(--color-tertiary);
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s;
}

.filter-tab:hover,
.filter-tab.active {
    color: var(--color-primary);
    border-bottom-color: var(--color-primary);
}

.orders-table {
    background: var(--color-white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    background: var(--color-light);
}

.table th,
.table td {
    padding: 20px;
    text-align: left;
    border-bottom: 1px solid var(--color-light);
}

.table th {
    color: var(--color-primary);
    font-weight: 600;
}

.table tbody tr {
    transition: background 0.3s;
}

.table tbody tr:hover {
    background: #fafafa;
}

.status-badge {
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
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
</style>

<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2.5rem; color: var(--color-primary);">Orders</h1>
    <p style="color: var(--color-secondary);">Manage your customer orders</p>
</div>

<div class="filter-tabs">
    <a href="{{ route('seller.orders.index') }}" 
       class="filter-tab {{ !request('status') ? 'active' : '' }}">
        All Orders
    </a>
    <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" 
       class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('seller.orders.index', ['status' => 'processing']) }}" 
       class="filter-tab {{ request('status') == 'processing' ? 'active' : '' }}">
        Processing
    </a>
    <a href="{{ route('seller.orders.index', ['status' => 'completed']) }}" 
       class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">
        Completed
    </a>
</div>

<div class="orders-table">
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->buyer->name }}</td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('seller.orders.show', $order) }}" class="btn btn-primary btn-small">
                            View Details
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px 20px; color: var(--color-tertiary);">
                        <div style="font-size: 3rem; margin-bottom: 15px;">📭</div>
                        <p>No orders found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $orders->links() }}
    </div>
@endif

</x-seller-layout>

