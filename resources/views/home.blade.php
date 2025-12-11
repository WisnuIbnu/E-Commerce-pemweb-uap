<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Sidebar: Categories --}}
                <aside class="bg-white p-4 rounded shadow-sm">
                    <h3 class="font-semibold mb-3">Categories</h3>

                    {{-- DROPDOWN --}}
                    <div x-data="{ open: false }" class="mb-3">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center px-3 py-2 border rounded bg-gray-100 hover:bg-gray-200">
                            <span>All Categories</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                :class="open ? 'rotate-180' : ''"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- DROPDOWN LIST --}}
                        <ul x-show="open" x-transition class="mt-2 border rounded bg-white">
                            <li>
                                <a href="{{ route('home') }}"
                                    class="block px-3 py-2 hover:bg-gray-100">
                                    All Categories
                                </a>
                            </li>

                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('category.show', $cat->slug) }}"
                                        class="block px-3 py-2 hover:bg-gray-100">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                {{-- Product Grid --}}
                <main class="lg:col-span-3">
                    {{-- search / sort bar (optional) --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600">
                            Showing <strong>{{ $products->total() ?? $products->count() }}</strong> products
                        </div>
                        <div>
                            {{-- placeholder for sort/select --}}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded shadow-sm overflow-hidden">
                                @php
                                    $img = $product->productImages->first()->image ?? null;
                                @endphp

                                <a href="{{ route('product.show', $product->slug) }}" class="block">
                                    <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden">
                                        @if($img)
                                            <img src="{{ asset('storage/products/'.$img) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                                        @else
                                            <div class="text-gray-400">No image</div>
                                        @endif
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-medium text-lg">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <a href="{{ route('category.show', $product->productCategory->slug) }}"
                                               class="text-indigo-600 hover:underline">
                                                {{ $product->productCategory->name }}
                                            </a>
                                        </p>

                                        <div class="mt-3 flex items-center justify-between">
                                            <div class="text-xl font-bold text-indigo-600">
                                                Rp {{ number_format($product->price,0,',','.') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Stock: {{ $product->stock }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </main>
            </div>

        </div>
    </div>
</x-app-layout>