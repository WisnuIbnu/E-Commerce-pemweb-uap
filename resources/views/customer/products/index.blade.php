<x-app-layout>
    <x-slot name="header">
        <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-8 shadow-xl">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🛒</span>
                    <h2 class="font-semibold text-2xl">
                        All Products
                    </h2>
                </div>
                <p class="text-sm text-blue-100">
                    Jelajahi semua produk elektronik yang tersedia di ElecTrend.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-900 min-h-screen text-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <div class="group bg-gray-900 border border-gray-800 rounded-2xl p-4 shadow-2xl flex flex-col hover:border-blue-500 hover:-translate-y-1 transition-transform duration-200">

                        {{-- Foto card --}}
                        <div class="w-full h-48 flex items-center justify-center overflow-hidden rounded-xl mb-3 bg-gray-800">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">
                                    No Image
                                </div>
                            @endif
                        </div>

                        {{-- Info produk --}}
                        <h3 class="font-semibold text-base text-gray-100 truncate">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">
                            Category: {{ $product->category->name }}
                        </p>
                        <p class="text-sm font-semibold text-blue-300 mt-2">
                            Rp {{ number_format($product->price) }}
                        </p>

                        {{-- Tombol --}}
                        <a href="{{ route('customer.products.show', $product->slug) }}"
                           class="mt-4 inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-3 py-2 rounded-lg text-xs font-medium shadow transition-colors">
                            View Details
                        </a>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-400">
                        No products available.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
