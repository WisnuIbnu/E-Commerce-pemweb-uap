
<!-- resources/views/seller/products/index.blade.php -->
<x-seller-layout>
<x-slot name="title">My Products - SORAÉ</x-slot>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 2.5rem;
    color: var(--color-primary);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.product-card {
    background: var(--color-white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
    transition: transform 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.product-info {
    padding: 20px;
}

.product-title {
    font-size: 1.2rem;
    color: var(--color-primary);
    margin-bottom: 10px;
}

.product-price {
    font-size: 1.4rem;
    color: var(--color-secondary);
    font-weight: 700;
    margin-bottom: 15px;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: var(--color-tertiary);
    margin-bottom: 15px;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.btn-small {
    flex: 1;
    padding: 8px 15px;
    font-size: 0.9rem;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.empty-state-icon {
    font-size: 5rem;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: var(--color-primary);
    margin-bottom: 15px;
}
</style>

<div class="page-header">
    <div>
        <h1>My Products</h1>
        <p style="color: var(--color-secondary);">Manage your product listings</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
        ➕ Add New Product
    </a>
</div>

<div class="products-grid">
    @forelse($products as $product)
        <div class="product-card">
            <img src="{{ $product->images->first()?->image_url ?? asset('images/placeholder.jpg') }}" 
                 alt="{{ $product->name }}" 
                 class="product-image">
            
            <div class="product-info">
                <h3 class="product-title">{{ $product->name }}</h3>
                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <div class="product-meta">
                    <span>Stock: {{ $product->stock }}</span>
                    <span>{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>

                <div class="product-actions">
                    <a href="{{ route('seller.products.edit', $product) }}" 
                       class="btn btn-primary btn-small">
                        ✏️ Edit
                    </a>
                    <form method="POST" action="{{ route('seller.products.destroy', $product) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this product?')"
                          style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-small" style="width: 100%;">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h3>No Products Yet</h3>
            <p style="color: var(--color-secondary); margin-bottom: 20px;">
                Start adding products to your store
            </p>
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                Add Your First Product
            </a>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
@endif

</x-seller-layout>

<!-- resources/views/seller/products/create.blade.php -->
<x-seller-layout>
<x-slot name="title">Add Product - SORAÉ</x-slot>

<style>
.product-form {
    max-width: 900px;
    background: var(--color-white);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.form-section {
    margin-bottom: 35px;
}

.form-section-title {
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

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    color: var(--color-primary);
    font-weight: 500;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--color-tertiary);
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--color-primary);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.image-upload-zone {
    border: 2px dashed var(--color-tertiary);
    border-radius: 8px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}

.image-upload-zone:hover {
    border-color: var(--color-primary);
    background: var(--color-light);
}

.image-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 8px;
    overflow: hidden;
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div style="margin-bottom: 30px;">
    <a href="{{ route('seller.products.index') }}" style="color: var(--color-secondary); text-decoration: none;">
        ← Back to Products
    </a>
</div>

<div class="product-form">
    <h1 style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 30px;">
        Add New Product
    </h1>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h2 class="form-section-title">Basic Information</h2>
            
            <div class="form-group">
                <label class="form-label required">Product Name</label>
                <input type="text" name="name" class="form-input" 
                       value="{{ old('name') }}" 
                       placeholder="e.g., Premium Cotton T-Shirt" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label required">Season</label>
                    <select name="season" class="form-select" required>
                        <option value="">Select Season</option>
                        <option value="all" {{ old('season') == 'all' ? 'selected' : '' }}>All Season</option>
                        <option value="summer" {{ old('season') == 'summer' ? 'selected' : '' }}>Summer</option>
                        <option value="winter" {{ old('season') == 'winter' ? 'selected' : '' }}>Winter</option>
                        <option value="spring" {{ old('season') == 'spring' ? 'selected' : '' }}>Spring</option>
                        <option value="fall" {{ old('season') == 'fall' ? 'selected' : '' }}>Fall</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Description</label>
                <textarea name="description" class="form-textarea" 
                          placeholder="Describe your product in detail..." required>{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h2 class="form-section-title">Pricing & Inventory</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Price (Rp)</label>
                    <input type="number" name="price" class="form-input" 
                           value="{{ old('price') }}" 
                           placeholder="50000" 
                           min="0" 
                           step="1000" required>
                </div>

                <div class="form-group">
                    <label class="form-label required">Stock</label>
                    <input type="number" name="stock" class="form-input" 
                           value="{{ old('stock', 0) }}" 
                           placeholder="100" 
                           min="0" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h2 class="form-section-title">Product Images</h2>
            
            <input type="file" name="images[]" id="product-images" 
                   accept="image/*" multiple style="display: none;">
            
            <label for="product-images" class="image-upload-zone">
                <div style="font-size: 3rem; margin-bottom: 15px;">📷</div>
                <h3 style="color: var(--color-primary); margin-bottom: 10px;">
                    Upload Product Images
                </h3>
                <p style="color: var(--color-secondary);">
                    Click to select images (PNG, JPG - max 2MB each)
                </p>
            </label>

            <div id="image-preview" class="image-preview-grid"></div>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 15px; font-size: 1.1rem;">
                ✅ Create Product
            </button>
            <a href="{{ route('seller.products.index') }}" 
               class="btn btn-secondary" 
               style="flex: 1; padding: 15px; font-size: 1.1rem; text-align: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('product-images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush

</x-seller-layout>
