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
     @include('layouts.store-navbar')

    {{-- PAGE WRAPPER --}}
    <div class="px-16 py-8 grid grid-cols-12 gap-10">

        {{-- FILTERS (LEFT) --}}
        <aside class="col-span-3">
            <h2 class="text-lg font-semibold mb-4">Filters</h2>

            {{-- Size --}}
            <div class="mb-8">
                <h3 class="text-sm font-semibold mb-2">Size</h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (['XS', 'S', 'M', 'L', 'XL', '2X'] as $size)
                    <button class="border px-3 py-1 hover:bg-gray-100 text-sm">
                        {{ $size }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Availability --}}
            <div class="mb-8">
                <h3 class="text-sm font-semibold mb-2">Availability</h3>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" class="h-4 w-4 border-gray-400">
                    <span>Available (20)</span>
                </label>

                <label class="flex items-center gap-2 text-sm mt-2">
                    <input type="checkbox" class="h-4 w-4 border-gray-400">
                    <span>Out of Stock (4)</span>
                </label>
            </div>

            <hr class="my-6 border-gray-300">

            {{-- Other filter labels --}}
            @foreach (['Category', 'Colors', 'Price Range', 'Collections', 'Tags', 'Ratings'] as $item)
            <div class="flex items-center justify-between py-3 border-b">
                <span class="text-sm font-semibold">{{ $item }}</span>
                <span class="text-sm">›</span>
            </div>
            @endforeach
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="col-span-9">

            {{-- Search --}}
            <div class="flex items-center bg-gray-200 rounded-md px-4 py-3 mb-6 w-full">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>

                <input type="text" placeholder="Search"
                    class="ml-3 w-full bg-transparent text-sm text-gray-600 focus:outline-none" />
            </div>

            {{-- Category Filter Tags --}}
            <div class="flex gap-3 flex-wrap mb-8">
                @foreach ([
                'NEW', 'SHIRTS', 'POLO SHIRTS', 'SHORTS',
                'BEST SELLERS', 'T-SHIRTS', 'JEANS', 'JACKETS'
                ] as $tag)
                <button class="border px-4 py-2 text-sm hover:bg-gray-100">
                    {{ $tag }}
                </button>
                @endforeach
            </div>

            {{-- PRODUCT GRID --}}
            <div class="grid grid-cols-3 gap-8">

                {{-- Product Card --}}
                @for ($i = 0; $i < 6; $i++)
                    <div>
                    <img src="{{ asset('images/white-man-sit.png') }}"
                        class="w-full h-80 object-cover rounded">

                    <div class="text-sm text-gray-500 mt-2">Cotton T Shirt</div>
                    <div class="font-semibold text-lg">Basic Slim Fit T-Shirt</div>
                    <div class="text-gray-800 mt-1">$ 199</div>
            </div>
            @endfor

    </div>

    </main>

    </div>

</body>

</html>