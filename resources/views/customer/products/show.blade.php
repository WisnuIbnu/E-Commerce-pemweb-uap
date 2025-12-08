<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/default.png') }}" 
                 alt="{{ $product->name }}" class="w-full h-64 object-cover mb-4 rounded">
            <h3 class="font-bold text-xl mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mb-2">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
            <p class="text-blue-700 font-semibold mb-2">Price: ${{ number_format($product->price, 2) }}</p>
            <p class="mb-4">Condition: {{ ucfirst($product->condition) }}</p>
            <p class="mb-4">{{ $product->description }}</p>

            <!-- Add to Cart Button -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <label for="quantity" class="block mb-1 font-semibold">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="border rounded p-1 w-20 mb-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add to Cart
                </button>
            </form>

            <!-- Reviews -->
            @if($product->reviews->count())
                <h4 class="mt-6 font-bold text-lg">Reviews:</h4>
                @foreach($product->reviews as $review)
                    <div class="border-t mt-2 pt-2">
                        <p class="font-semibold">{{ $review->user->name }}:</p>
                        <p>{{ $review->comment }}</p>
                        <p class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                @endforeach
            @else
                <p class="mt-4 text-gray-600">No reviews yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
