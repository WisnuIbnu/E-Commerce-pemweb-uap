<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
     @include('layouts.user.store-navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('products') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- FILTERS (LEFT) --}}
            <aside class="lg:col-span-3">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-24">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Filters</h2>

                    {{-- Category --}}
                    <div class="mb-8">
                        <h3 class="text-sm font-semibold mb-3 text-gray-700 uppercase tracking-wider">Category</h3>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-3 text-sm cursor-pointer hover:text-blue-600 transition-colors">
                                <input type="radio" name="category" value="Top" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 rounded-full" 
                                    {{ request('category') == 'Top' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Top</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm cursor-pointer hover:text-blue-600 transition-colors">
                                <input type="radio" name="category" value="Bottom" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 rounded-full" 
                                     {{ request('category') == 'Bottom' ? 'checked' : '' }}
                                     onchange="this.form.submit()">
                                <span>Bottom</span>
                            </label>
                            @if(request('category'))
                                <a href="{{ route('products', request()->except('category')) }}" class="text-xs text-red-500 hover:text-red-700 font-medium mt-1 inline-block">Clear Category</a>
                            @endif
                        </div>
                    </div>

                    {{-- Availability --}}
                    <div>
                        <h3 class="text-sm font-semibold mb-3 text-gray-700 uppercase tracking-wider">Availability</h3>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-3 text-sm cursor-pointer hover:text-blue-600 transition-colors">
                                <input type="checkbox" name="availability[]" value="available" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 rounded"
                                    {{ in_array('available', (array)request('availability')) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Available</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm cursor-pointer hover:text-blue-600 transition-colors">
                                <input type="checkbox" name="availability[]" value="out_of_stock" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 rounded"
                                    {{ in_array('out_of_stock', (array)request('availability')) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Out of Stock</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="lg:col-span-9">

                {{-- Search --}}
                <div class="relative mb-8">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-12 p-3 shadow-sm transition-shadow" />
                </div>

                {{-- PRODUCT GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($products as $product)
                        <div class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="w-full h-64 bg-gray-50 relative overflow-hidden">
                                     @if($product->productImages->first())
                                        <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $product->name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                            <span class="text-xs uppercase font-bold tracking-widest text-gray-300">No Image</span>
                                        </div>
                                    @endif
                                    @if($product->stock == 0)
                                        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                            Sold Out
                                        </div>
                                    @elseif($product->created_at->diffInDays(now()) < 7)
                                         <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                            New
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <div class="text-xs text-gray-500 mb-1 uppercase tracking-wide">
                                        {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-lg mb-2 truncate group-hover:text-blue-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div class="text-gray-900 font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                            <div class="text-gray-300 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                            <p class="text-gray-500 mt-1">Try adjusting your search or filters.</p>
                            <a href="{{ route('products') }}" class="mt-4 text-blue-600 hover:underline">Clear all filters</a>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-10">
                    {{ $products->links() }}
                </div>

            </main>
        </form>
    </div>

    </div>

</body>

</html>