@extends('layouts.app')

@section('title', 'Edit Product - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.form-content {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-2xl);
    box-shadow: var(--shadow-sm);
}

.form-section {
    margin-bottom: var(--spacing-xl);
    padding-bottom: var(--spacing-xl);
    border-bottom: 1px solid var(--border);
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: var(--spacing-lg);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-md);
}

.current-images {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-md);
}

.current-image-item {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid var(--border);
}

.current-image-item.thumbnail {
    border-color: var(--primary);
}

.current-image {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.image-actions {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    padding: 4px;
    display: flex;
    gap: 4px;
}

.image-action-btn {
    flex: 1;
    padding: 4px;
    border: none;
    background: var(--white);
    color: var(--dark);
    font-size: 10px;
    cursor: pointer;
    border-radius: var(--radius-sm);
}

.image-action-btn:hover {
    background: var(--light-gray);
}

.images-upload-area {
    border: 2px dashed var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--light-gray);
}

.images-upload-area:hover {
    border-color: var(--primary);
    background: var(--primary-light);
}

.upload-icon {
    font-size: 32px;
    margin-bottom: var(--spacing-sm);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
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
        <main class="form-content">
            <h1 class="mb-xl">✏️ Edit Product</h1>

            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">📋 Basic Information</h3>

                    <div class="form-group">
                        <label for="name" class="form-label">Product Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            value="{{ old('name', $product->name) }}"
                            class="form-control @error('name') error @enderror">
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_category_id" class="form-label">Category *</label>
                        <select 
                            id="product_category_id" 
                            name="product_category_id" 
                            required
                            class="form-control @error('product_category_id') error @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_category_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description *</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            required
                            rows="6"
                            class="form-control @error('description') error @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="form-section">
                    <h3 class="section-title">💰 Pricing & Stock</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price" class="form-label">Price (Rp) *</label>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                required
                                min="0"
                                step="0.01"
                                value="{{ old('price', $product->price) }}"
                                class="form-control @error('price') error @enderror">
                            @error('price')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">Stock *</label>
                            <input 
                                type="number" 
                                id="stock" 
                                name="stock" 
                                required
                                min="0"
                                value="{{ old('stock', $product->stock) }}"
                                class="form-control @error('stock') error @enderror">
                            @error('stock')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight (grams) *</label>
                            <input 
                                type="number" 
                                id="weight" 
                                name="weight" 
                                required
                                min="1"
                                value="{{ old('weight', $product->weight) }}"
                                class="form-control @error('weight') error @enderror">
                            @error('weight')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="condition" class="form-label">Condition *</label>
                            <select 
                                id="condition" 
                                name="condition" 
                                required
                                class="form-control @error('condition') error @enderror">
                                <option value="">Select Condition</option>
                                <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                <option value="second" {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Second</option>
                            </select>
                            @error('condition')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="form-section">
                    <h3 class="section-title">📷 Product Images</h3>

                    @if($product->productImages->count() > 0)
                        <div class="form-group">
                            <label class="form-label">Current Images</label>
                            <div class="current-images">
                                @foreach($product->productImages as $image)
                                    <div class="current-image-item {{ $image->is_thumbnail ? 'thumbnail' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image" class="current-image">
                                        <div class="image-actions">
                                            @if(!$image->is_thumbnail)
                                                <form method="POST" action="{{ route('seller.products.images.thumbnail', $image) }}" style="flex: 1;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="image-action-btn">
                                                        ⭐ Set Main
                                                    </button>
                                                </form>
                                            @else
                                                <span style="flex: 1; padding: 4px; background: var(--primary); color: var(--white); font-size: 10px; border-radius: var(--radius-sm); text-align: center;">
                                                    ⭐ Main
                                                </span>
                                            @endif
                                            <form method="POST" action="{{ route('seller.products.images.destroy', $image) }}" style="flex: 1;" onsubmit="return confirm('Delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="image-action-btn">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Add More Images (Optional)</label>
                        <div class="images-upload-area" onclick="document.getElementById('images').click()">
                            <div class="upload-icon">📷</div>
                            <p><strong>Click to add more images</strong></p>
                            <p style="font-size: 12px; color: var(--gray);">
                                PNG, JPG up to 2MB each
                            </p>
                        </div>
                        <input 
                            type="file" 
                            id="images" 
                            name="images[]" 
                            accept="image/*"
                            multiple
                            style="display: none;"
                            class="@error('images') error @enderror">
                        @error('images')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-md">
                    <button type="submit" class="btn btn-primary btn-lg">
                        💾 Save Changes
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="btn btn-outline btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection