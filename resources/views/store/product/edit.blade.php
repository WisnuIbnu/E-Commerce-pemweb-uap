@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="mb-8">
            <a href="{{ route('store.products.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Produk
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Edit Produk</h1>
            <p class="text-tumbloo-gray">Update informasi produk</p>
        </div>

        <div class="card p-8">
            <form action="{{ route('store.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="label">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                        class="input-field @error('name') border-red-500 @enderror" 
                        placeholder="Nama produk yang menarik"
                        value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Kategori <span class="text-red-500">*</span></label>
                    <select name="product_category_id" 
                        class="select-field @error('product_category_id') border-red-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="about" rows="5"
                        class="textarea-field @error('about') border-red-500 @enderror" 
                        placeholder="Jelaskan detail produk Anda..." required>{{ old('about', $product->about) }}</textarea>
                    @error('about')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" 
                            class="input-field @error('price') border-red-500 @enderror" 
                            placeholder="100000" min="0" step="1000"
                            value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Berat (gram) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" 
                            class="input-field @error('weight') border-red-500 @enderror" 
                            placeholder="500" min="0" step="1"
                            value="{{ old('weight', $product->weight) }}" required>
                        @error('weight')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" 
                            class="input-field @error('stock') border-red-500 @enderror" 
                            placeholder="10" min="0"
                            value="{{ old('stock', $product->stock) }}" required>
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Kondisi <span class="text-red-500">*</span></label>
                        <select name="condition" 
                            class="select-field @error('condition') border-red-500 @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">
                        Update Produk
                    </button>
                    <a href="{{ route('store.products.index') }}" class="btn-secondary flex-1">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection