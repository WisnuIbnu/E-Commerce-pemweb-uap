{{-- resources/views/products/search.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 space-y-8">

        {{-- HEADER --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Hasil Pencarian
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Menampilkan hasil untuk:
                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-md font-medium">
                    "{{ $query }}"
                </span>
            </p>
        </div>

        {{-- LIST PRODUK --}}
        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">

                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition p-0 overflow-hidden block">

                        {{-- GAMBAR PRODUK --}}
                        <div class="relative">

                            @php
                                $firstImage = $product->productImages->first();
                            @endphp

                            @if($firstImage)
                                {{-- Jika ada gambar --}}
                                <img src="{{ asset('storage/' . $firstImage->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-40 object-cover">
                            @else
                                {{-- DEFAULT FOTO --}}
                                <div class="w-full h-40 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                    <svg class="w-14 h-14 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif

                            @if($product->productCategory)
                                <span class="absolute top-2 left-2 bg-white/90 text-[10px] px-2 py-1 rounded-full shadow text-gray-700">
                                    {{ $product->productCategory->name }}
                                </span>
                            @endif
                        </div>

                        {{-- INFO PRODUK --}}
                        <div class="p-3 space-y-1">
                            <p class="text-[11px] text-gray-500">
                                {{ $product->store->name ?? 'Toko Tidak Diketahui' }}
                            </p>

                            <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                {{ $product->name }}
                            </p>

                            <p class="text-sm font-bold text-orange-600 mt-1">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            @if($product->stock)
                                <p class="text-[11px] text-gray-400">
                                    Stok: {{ $product->stock }}
                                </p>
                            @endif
                        </div>

                    </a>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $products->links() }}
            </div>

        @else
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center py-20 text-center">

                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="w-10 h-10 text-orange-400" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 7h14M10 21a1 1 0 100-2 1 1 0 000 2zm8 1a1 1 0 100-2 1 1 0 000 2z"/>
                    </svg>
                </div>

                <h2 class="text-lg font-semibold text-gray-800 mb-1">Tidak ada produk yang cocok</h2>

                <p class="text-gray-500 text-sm max-w-sm">
                    Coba gunakan kata kunci lain atau periksa ejaan pencarian Anda.
                </p>

                <a href="{{ route('products.index') }}"
                   class="mt-6 px-5 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm shadow">
                    Kembali ke Semua Produk
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
