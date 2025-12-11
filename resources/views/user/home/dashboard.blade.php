<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
 
<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
   {{-- NAVBAR --}}
@include('layouts.user.store-navbar')


    {{-- SEARCH --}}
    <!-- <div class="w-full flex justify-center mt-2 mb-10">
        <div class="flex items-center bg-gray-200 rounded-md px-4 py-3 w-1/2 max-w-lg">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>

            <input type="text" placeholder="Search"
                class="ml-3 w-full bg-transparent text-sm text-gray-600 focus:outline-none" />
        </div>
    </div> -->

    {{-- MAIN CONTENT --}}
    <section class="px-16 mt-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        {{-- Left Text --}}
        <div class="flex flex-col justify-center">
            <h1 class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                MPRUY<br>STORE
            </h1>

            <p class="mt-4 text-sm text-gray-600 leading-tight">
                Winter<br>2025
            </p>
        </div>

        {{-- Middle Image --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/white-man-sit.png') }}"
                class="rounded-lg shadow-sm object-cover w-[450px] h-[520px]">
        </div>

        {{-- Right Image --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/black-man-stand.png') }}"
                class="rounded-lg shadow-sm object-cover w-[450px] h-[520px]">
        </div>

    </section>

    {{-- NEW ARRIVALS SECTION --}}
    <section class="max-w-7xl mx-auto px-16 mt-20 mb-16">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-3xl font-serif font-bold text-gray-800">New Arrivals</h2>
            <a href="{{ route('products') }}" class="text-sm font-medium text-black hover:underline">View All &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($newArrivals as $product)
                <div class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="w-full h-64 bg-gray-50 relative overflow-hidden">
                                @if($product->productImages->where('is_thumbnail', true)->first())
                                <img src="{{ asset('storage/' . $product->productImages->where('is_thumbnail', true)->first()->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    alt="{{ $product->name }}">
                            @elseif($product->productImages->first())
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    <span class="text-xs uppercase font-bold tracking-widest text-gray-300">No Image</span>
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
                            <div class="text-gray-900 font-bold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    No new arrivals yet.
                </div>
            @endforelse
        </div>
    </section>

</body>

</html>