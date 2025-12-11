<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/seller_category_form.css') }}">
    @endpush

    <div class="container">
        <div class="page-header">
            <h1>Tambah Kategori Baru</h1>
            <p>Buat kategori produk untuk toko Anda</p>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form method="POST" action="{{ route('seller.categories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name">Nama Kategori <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            placeholder="Contoh: Elektronik"
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
                                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}
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
                            value="{{ old('tagline') }}"
                            placeholder="Contoh: Temukan gadget terbaik"
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
                            placeholder="Jelaskan kategori ini..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category Image -->
                    <div class="form-group">
                        <label for="image">Gambar Kategori (Opsional)</label>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                        >
                        <small>Format: JPG, PNG, max 2MB</small>
                        @error('image')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('seller.categories.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>