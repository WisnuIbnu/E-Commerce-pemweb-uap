@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Product</h1>

    <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="mt-1 w-full border rounded-md px-3 py-2" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="product_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="product_category_id" name="product_category_id" class="mt-1 w-full border rounded-md px-3 py-2" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                <input type="text" id="price_display" class="mt-1 w-full border rounded-md px-3 py-2 pl-10" required placeholder="200.000" value="{{ number_format(old('price', $product->price), 0, ',', '.') }}">
                <input type="hidden" id="price" name="price" value="{{ old('price', $product->price) }}">
            </div>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="text" inputmode="numeric" pattern="[0-9]*" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
            @if($product->productImages->where('is_thumbnail', true)->first())
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->productImages->where('is_thumbnail', true)->first()->image) }}" class="w-20 h-20 object-cover rounded">
                </div>
            @endif
            <input type="file" id="image" name="image" class="mt-1 w-full border rounded-md px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image.</p>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Product</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceDisplay = document.getElementById('price_display');
    const priceHidden = document.getElementById('price');

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function unformatNumber(str) {
        return str.replace(/\D/g, '');
    }

    priceDisplay.addEventListener('input', function(e) {
        let value = unformatNumber(e.target.value);
        
        if (value) {
            e.target.value = formatNumber(value);
            priceHidden.value = value;
        } else {
            e.target.value = '';
            priceHidden.value = '';
        }
    });

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
