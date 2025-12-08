<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('All Products') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/default.png') }}" 
                         alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2 rounded">
                    <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                    <p class="text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <p class="text-blue-700 font-semibold">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="mt-2 inline-block text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                       View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
