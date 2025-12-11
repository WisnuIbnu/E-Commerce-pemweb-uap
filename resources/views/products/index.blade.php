{{-- resources/views/products/index.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 space-y-8">

        {{-- HEADER + INFO --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Semua Produk
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Temukan kebutuhan sembako kamu di sini. 
                    Menampilkan <span class="font-semibold">{{ $products->total() }}</span> produk.
                </p>
            </div>

            {{-- Tombol kembali ke beranda --}}
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 text-sm text-orange-600 hover:text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M10.5 19.5L3 12l7.5-7.5M21 12H3"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        {{-- FILTER BAR --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-white rounded-2xl shadow-sm px-4 py-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                <span>Produk siap dikirim dari berbagai toko terpercaya.</span>
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Urutkan:</span>
                <select
                    class="border border-gray-200 rounded-lg text-sm px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 bg-gray-50">
                    <option>Terbaru</option>
                    <option>Harga Terendah</option>
                    <option>Harga Tertinggi</option>
                </select>
            </div>
        </div>

        {{-- LIST PRODUK --}}
        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition hover:-translate-y-1 overflow-hidden flex flex-col">

                        {{-- Gambar Produk --}}
                        <div class="relative">

                            @php
                                $firstImage = $product->productImages->first();
                            @endphp

                            @if($firstImage)
                                {{-- Jika produk punya gambar --}}
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
                                <span class="absolute top-2 left-2 bg-white/90 text-[10px] px-2 py-1 rounded-full text-gray-700 shadow">
                                    {{ $product->productCategory->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Info Produk --}}
                        <div class="p-3 flex-1 flex flex-col">
                            <p class="text-[11px] text-gray-500 mb-1">
                                {{ $product->store->name ?? 'Toko Tidak Diketahui' }}
                            </p>

                            <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                {{ $product->name }}
                            </p>

                            <p class="text-sm font-bold text-orange-600 mt-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            @isset($product->stock)
                                <p class="text-[11px] text-gray-400 mt-1">
                                    Stok: {{ $product->stock }}
                                </p>
                            @endisset

                            <div class="mt-3">
                                <span class="inline-flex items-center text-[11px] font-medium text-orange-600">
                                    Lihat Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>

        @else
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 7h14M10 21a1 1 0 100-2 1 1 0 000 2zm8 1a1 1 0 100-2 1 1 0 000 2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800 mb-1">Belum ada produk</h2>
                <p class="text-sm text-gray-500 max-w-sm">
                    Produk belum tersedia atau habis. Silakan kembali lagi nanti atau cek kategori lainnya.
                </p>
            </div>
        @endif

    </div>
</x-app-layout>
