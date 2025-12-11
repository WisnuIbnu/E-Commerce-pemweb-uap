<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search Info -->
            <div class="mb-6">
                <h3 class="text-lg text-gray-700">
                    Search results for: <span class="font-bold">"{{ $query }}"</span>
                </h3>
                <p class="text-sm text-gray-500">Found {{ $products->total() }} products</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form action="{{ route('products.search') }}" method="GET" class="flex gap-2">
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}"
                           placeholder="Search products..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Search
                    </button>
                </form>
            </div>

            @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <a href="{{ route('product.show', $product->slug) }}">
                        @php
                            $thumbnail = $product->productImages->where('is_thumbnail', true)->first();
                        @endphp
                        @if($thumbnail)
                        <img src="{{ asset('storage/' . $thumbnail->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover" />
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-4xl">📦</span>
                        </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 truncate">
                            <a href="{{ route('product.show', $product->slug) }}" class="hover:text-blue-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $product->store->name }}</p>
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-sm text-gray-600 ml-1">
                                {{ number_format($product->productReviews->avg('rating') ?? 0, 1) }} 
                                ({{ $product->productReviews->count() }})
                            </span>
                        </div>
                        <p class="text-lg font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
            @else
            <!-- No Results -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No products found</h3>
                <p class="text-gray-600 mb-6">Try searching with different keywords</p>
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Back to Home
                </a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>