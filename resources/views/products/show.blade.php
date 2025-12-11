{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            {{-- FOTO PRODUK --}}
            <div>
                @php
                    $mainImage = $product->productImages->first();
                @endphp

                @if($mainImage)
                    {{-- Jika ada gambar utama --}}
                    <img src="{{ asset('storage/' . $mainImage->image) }}"
                         class="w-full h-80 object-cover rounded-2xl shadow-lg"
                         alt="{{ $product->name }}">
                @else
                    {{-- DEFAULT FOTO UTAMA --}}
                    <div class="w-full h-80 rounded-2xl shadow-lg bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif

                {{-- Thumbnail kecil (kalau ada) --}}
                <div class="flex gap-3 mt-4 overflow-x-auto">
                    @foreach($product->productImages as $img)
                        <img src="{{ asset('storage/' . $img->image) }}"
                             class="w-20 h-20 rounded-lg object-cover border hover:scale-105 transition cursor-pointer"
                             alt="">
                    @endforeach
                </div>
            </div>

            {{-- INFO PRODUK --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">
                    Kategori: {{ $product->productCategory->name ?? '-' }}
                </p>

                <h1 class="text-3xl font-bold text-gray-800 mb-3">
                    {{ $product->name }}
                </h1>

                <p class="text-2xl font-bold text-orange-600 mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p class="text-sm text-gray-500 mb-4">
                    Toko: {{ $product->store->name ?? '-' }}
                </p>

                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                </p>

                {{-- Tombol tambah ke keranjang --}}
                @auth
                    @if(auth()->user()->role === 'buyer')
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow">
                        Login untuk Belanja
                    </a>
                @endauth
            </div>
        </div>

        {{-- PRODUK TERKAIT --}}
        @if($relatedProducts->count())
            <div class="mt-14">
                <h2 class="text-xl font-bold mb-4">Produk Terkait</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $item)
                        <a href="{{ route('product.show', $item->slug) }}"
                           class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition block">

                            @php
                                $relatedImage = $item->productImages->first();
                            @endphp

                            @if($relatedImage)
                                {{-- Jika produk terkait punya gambar --}}
                                <img src="{{ asset('storage/' . $relatedImage->image) }}"
                                     class="w-full h-32 object-cover" alt="{{ $item->name }}">
                            @else
                                {{-- DEFAULT FOTO PRODUK TERKAIT --}}
                                <div class="w-full h-32 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-3">
                                <p class="text-xs text-gray-500 mb-1">
                                    {{ $item->store->name ?? '-' }}
                                </p>
                                <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                    {{ $item->name }}
                                </p>
                                <p class="text-sm font-bold text-orange-600 mt-1">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
