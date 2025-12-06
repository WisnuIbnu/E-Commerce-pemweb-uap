@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('store.products.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Produk
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Tambah Produk</h1>
            <p class="text-tumbloo-gray">Tambahkan produk baru ke toko Anda</p>
        </div>

        <!-- Form -->
        <div class="card p-8">
            <form action="{{ route('store.products.store') }}" method="POST">
                @csrf

                <!-- Product Name -->
                <div class="mb-6">
                    <label class="label">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                        class="input-field @error('name') border-red-500 @enderror" 
                        placeholder="Nama produk yang menarik"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="label">Kategori <span class="text-red-500">*</span></label>
                    <select name="product_category_id" 
                        class="select-field @error('product_category_id') border-red-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- About -->
                <div class="mb-6">
                    <label class="label">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="about" rows="5"
                        class="textarea-field @error('about') border-red-500 @enderror" 
                        placeholder="Jelaskan detail produk Anda..." required>{{ old('about') }}</textarea>
                    @error('about')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Weight -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" 
                            class="input-field @error('price') border-red-500 @enderror" 
                            placeholder="100000" min="0" step="1000"
                            value="{{ old('price') }}" required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Berat (gram) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" 
                            class="input-field @error('weight') border-red-500 @enderror" 
                            placeholder="500" min="0" step="1"
                            value="{{ old('weight') }}" required>
                        @error('weight')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock and Condition -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" 
                            class="input-field @error('stock') border-red-500 @enderror" 
                            placeholder="10" min="0"
                            value="{{ old('stock') }}" required>
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Kondisi <span class="text-red-500">*</span></label>
                        <select name="condition" 
                            class="select-field @error('condition') border-red-500 @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mb-6">
                    <p class="text-sm">
                        💡 <strong>Tips:</strong> Setelah membuat produk, jangan lupa untuk menambahkan foto produk agar lebih menarik!
                    </p>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">
                        Simpan Produk
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