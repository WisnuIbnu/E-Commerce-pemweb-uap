@extends('layouts.app')

@section('title', 'Edit Category - DrizStuff')

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
    max-width: 800px;
}

.form-section {
    margin-bottom: var(--spacing-xl);
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: var(--spacing-lg);
}

.current-image {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: var(--radius-md);
    margin-bottom: var(--spacing-md);
    border: 2px solid var(--border);
}

.image-upload-area {
    border: 2px dashed var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--light-gray);
}

.image-upload-area:hover {
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
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="seller-layout">
        <!-- Sidebar -->
        @include('seller.partials.sidebar', ['activeMenu' => 'categories'])

        <!-- Main Content -->
        <main class="form-content">
            <h1 class="mb-xl">✏️ Edit Category</h1>

            <form method="POST" action="{{ route('seller.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">📋 Basic Information</h3>

                    <div class="form-group">
                        <label for="name" class="form-label">Category Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            value="{{ old('name', $category->name) }}"
                            class="form-control @error('name') error @enderror">
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Category (Optional)</label>
                        <select 
                            id="parent_id" 
                            name="parent_id" 
                            class="form-control @error('parent_id') error @enderror">
                            <option value="">None (Main Category)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tagline" class="form-label">Tagline (Optional)</label>
                        <input 
                            type="text" 
                            id="tagline" 
                            name="tagline" 
                            value="{{ old('tagline', $category->tagline) }}"
                            class="form-control @error('tagline') error @enderror">
                        @error('tagline')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description *</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            required
                            rows="4"
                            class="form-control @error('description') error @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Category Image -->
                <div class="form-section">
                    <h3 class="section-title">📷 Category Image</h3>

                    @if($category->image)
                        <div class="form-group">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img 
                                    src="{{ asset('storage/' . $category->image) }}" 
                                    alt="{{ $category->name }}"
                                    class="current-image">
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">{{ $category->image ? 'Update Image (Optional)' : 'Upload Image (Optional)' }}</label>
                        <div class="image-upload-area" onclick="document.getElementById('image').click()">
                            <div class="upload-icon">🖼️</div>
                            <p><strong>Click to upload new image</strong></p>
                            <p style="font-size: 12px; color: var(--gray);">
                                PNG, JPG up to 2MB
                            </p>
                        </div>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                            style="display: none;"
                            class="@error('image') error @enderror">
                        @error('image')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-md">
                    <button type="submit" class="btn btn-primary btn-lg">
                        💾 Save Changes
                    </button>
                    <a href="{{ route('seller.categories.index') }}" class="btn btn-outline btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection