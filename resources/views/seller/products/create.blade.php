@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Add Product</h1>

    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <p class="font-semibold mb-2">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded-md px-3 py-2 @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
            <textarea id="description" name="description" class="mt-1 w-full border rounded-md px-3 py-2 @error('description') border-red-500 @enderror" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="product_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="product_category_id" name="product_category_id" class="mt-1 w-full border rounded-md px-3 py-2 @error('product_category_id') border-red-500 @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('product_category_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                <input type="text" id="price_display" class="mt-1 w-full border rounded-md px-3 py-2 pl-10 @error('price') border-red-500 @enderror" required placeholder="200.000" value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}">
                <input type="hidden" id="price" name="price" value="{{ old('price') }}">
            </div>
            @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Gunakan titik untuk pemisah ribuan (contoh: 200.000)</p>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="text" inputmode="numeric" pattern="[0-9]*" id="stock" name="stock" value="{{ old('stock') }}" class="mt-1 w-full border rounded-md px-3 py-2 @error('stock') border-red-500 @enderror" required placeholder="10">
            @error('stock')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
            <input type="file" id="image" name="image" class="mt-1 w-full border rounded-md px-3 py-2 @error('image') border-red-500 @enderror" accept="image/*">
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Simpan Produk</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceDisplay = document.getElementById('price_display');
    const priceHidden = document.getElementById('price');

    // Format number with thousand separator
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Remove all non-numeric characters
    function unformatNumber(str) {
        return str.replace(/\D/g, '');
    }

    priceDisplay.addEventListener('input', function(e) {
        let value = unformatNumber(e.target.value);
        
        if (value) {
            // Format for display
            e.target.value = formatNumber(value);
            // Set raw number for form submission
            priceHidden.value = value;
        } else {
            e.target.value = '';
            priceHidden.value = '';
        }
    });

    // Handle paste
    priceDisplay.addEventListener('paste', function(e) {
        e.preventDefault();
        let pastedText = (e.clipboardData || window.clipboardData).getData('text');
        let value = unformatNumber(pastedText);
        
        if (value) {
            e.target.value = formatNumber(value);
            priceHidden.value = value;
        }
    });
});
</script>
@endsection
