<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/seller_category_form.css') }}">
    @endpush

    <div class="container">
        <div class="page-header">
            <h1>Edit Kategori</h1>
            <p>Perbarui informasi kategori produk</p>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form method="POST" action="{{ route('seller.categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name">Nama Kategori <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $category->name) }}"
                            required
                        >
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div class="form-group">
                        <label for="parent_id">Parent Kategori (Opsional)</label>
                        <select id="parent_id" name="parent_id">
                            <option value="">Tidak Ada (Top Level Category)</option>
                            @foreach($parentCategories as $parent)
                                <option 
                                    value="{{ $parent->id }}"
                                    {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}
                                >
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <small>Pilih parent jika ini adalah sub-kategori</small>
                        @error('parent_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tagline -->
                    <div class="form-group">
                        <label for="tagline">Tagline (Opsional)</label>
                        <input 
                            type="text" 
                            id="tagline" 
                            name="tagline" 
                            value="{{ old('tagline', $category->tagline) }}"
                        >
                        @error('tagline')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Deskripsi <span class="required">*</span></label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="5"
                            required
                        >{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($category->image)
                        <div class="form-group">
                            <label>Gambar Saat Ini</label>
                            <div class="current-image">
                                <img 
                                    src="{{ asset('storage/' . $category->image) }}" 
                                    alt="{{ $category->name }}"
                                >
                            </div>
                        </div>
                    @endif

                    <!-- Category Image -->
                    <div class="form-group">
                        <label for="image">{{ $category->image ? 'Ganti Gambar (Opsional)' : 'Gambar Kategori (Opsional)' }}</label>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                        >
                        <small>Format: JPG, PNG, max 2MB. {{ $category->image ? 'Kosongkan jika tidak ingin mengubah gambar.' : '' }}</small>
                        @error('image')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Info -->
                    @if($category->products->count() > 0)
                        <div class="info-box">
                            <strong>Informasi:</strong>
                            <p>Kategori ini memiliki {{ $category->products->count() }} produk terkait.</p>
                        </div>
                    @endif

                    @if($category->children->count() > 0)
                        <div class="info-box">
                            <strong>Informasi:</strong>
                            <p>Kategori ini memiliki {{ $category->children->count() }} sub-kategori.</p>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('seller.categories.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>