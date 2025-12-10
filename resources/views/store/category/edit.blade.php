@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="mb-8">
            <a href="{{ route('store.categories.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Kategori
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Edit Kategori</h1>
            <p class="text-tumbloo-gray">Update informasi kategori</p>
        </div>

        <div class="card p-8">
            <form action="{{ route('store.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="label">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                        class="input-field @error('name') border-red-500 @enderror" 
                        placeholder="contoh: Electronics"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Parent Kategori (Opsional)</label>
                    <select name="parent_id" class="select-field @error('parent_id') border-red-500 @enderror">
                        <option value="">Tidak ada (Main Category)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-tumbloo-gray mt-1">Pilih parent jika ini adalah sub-kategori</p>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($category->image)
                <div class="mb-6">
                    <label class="label">Gambar Saat Ini</label>
                    <img src="{{ Storage::url($category->image) }}" 
                        alt="{{ $category->name }}"
                        class="w-32 h-32 object-cover rounded-lg">
                </div>
                @endif

                <div class="mb-6">
                    <label class="label">Gambar Kategori Baru (Opsional)</label>
                    <input type="file" name="image" 
                        class="input-field @error('image') border-red-500 @enderror" 
                        accept="image/jpeg,image/png,image/jpg">
                    <p class="text-xs text-tumbloo-gray mt-1">Format: JPG, PNG (Max: 2MB). Kosongkan jika tidak ingin mengganti.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Tagline (Opsional)</label>
                    <input type="text" name="tagline" 
                        class="input-field @error('tagline') border-red-500 @enderror" 
                        placeholder="Tagline singkat untuk kategori"
                        value="{{ old('tagline', $category->tagline) }}">
                    @error('tagline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="4"
                        class="textarea-field @error('description') border-red-500 @enderror" 
                        placeholder="Deskripsi kategori...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">
                        Update Kategori
                    </button>
                    <a href="{{ route('store.categories.index') }}" class="btn-secondary flex-1">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection