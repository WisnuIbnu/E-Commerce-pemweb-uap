@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-6">
        <a href="{{ route('products') }}" class="text-sm text-gray-500 hover:text-black mb-6 inline-block">&larr; Back to Products</a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Product Images --}}
            <div class="space-y-4">
                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden">
                    @if($product->productImages->where('is_thumbnail', true)->first())
                        <img src="{{ asset('storage/' . $product->productImages->where('is_thumbnail', true)->first()->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @elseif($product->productImages->first())
                        <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Image Available
                        </div>
                    @endif
                </div>
                {{-- Thumbnails (Optional, if multiple images) --}}
                @if($product->productImages->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->productImages as $image)
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded overflow-hidden cursor-pointer hover:ring-2 hover:ring-black">
                         <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Product Details --}}
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-2xl font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    
                    {{-- Rating --}}
                    <div class="flex items-center text-yellow-500 text-sm">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                        <span class="text-gray-400 ml-2">(4.5)</span> {{-- Hardcoded rating for now as review logic is complex --}}
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-6">
                    @if($product->stock > 0)
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Available</span>
                        <span class="text-sm text-gray-500 ml-2">{{ $product->stock }} items left</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Out of Stock</span>
                    @endif
                </div>

                {{-- Description --}}
                <div class="prose prose-sm text-gray-600 mb-8">
                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                {{-- Quantity Selector --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <div class="flex items-center border border-gray-300 rounded w-max">
                        <button type="button" onclick="updateQuantity(-1)" class="px-3 py-2 hover:bg-gray-100 text-gray-600 focus:outline-none">-</button>
                        <input type="text" inputmode="numeric" id="visible-quantity" value="1" 
                               class="w-16 text-center border-none focus:ring-0 text-gray-900" 
                               onchange="syncQuantity(this.value)"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <button type="button" onclick="updateQuantity(1)" class="px-3 py-2 hover:bg-gray-100 text-gray-600 focus:outline-none">+</button>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4">
                    {{-- Buy Now Form --}}
                    <form action="{{ route('cart.buy', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="quantity" id="buy-quantity" value="1">
                        <button type="submit" class="w-full bg-black text-white px-8 py-3 rounded hover:bg-gray-800 transition font-medium">
                            Buy Now
                        </button>
                    </form>

                    {{-- Add to Cart Form --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="quantity" id="cart-quantity" value="1">
                        <button type="submit" class="w-full border border-black text-black px-8 py-3 rounded hover:bg-gray-50 transition font-medium">
                            Add to Cart
                        </button>
                    </form>
                </div>

                <script>
                    function updateQuantity(change) {
                        const input = document.getElementById('visible-quantity');
                        let newValue = parseInt(input.value) + change;
                        
                        // Validate bounds
                        const max = {{ $product->stock }};
                        if (newValue < 1) newValue = 1;
                        if (newValue > max) newValue = max;
                        
                        input.value = newValue;
                        syncQuantity(newValue);
                    }

                    function syncQuantity(value) {
                        // Ensure value is within bounds
                        const max = {{ $product->stock }};
                        if (value < 1) value = 1;
                        if (value > max) value = max;

                        document.getElementById('visible-quantity').value = value;
                        document.getElementById('buy-quantity').value = value;
                        document.getElementById('cart-quantity').value = value;
                    }
                </script>

                 {{-- Store Info --}}
                 <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-xl font-bold">
                        {{ substr($product->store->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Sold by</div>
                        <div class="font-semibold text-gray-900">{{ $product->store->name }}</div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
