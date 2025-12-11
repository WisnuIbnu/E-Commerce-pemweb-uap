{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 space-y-8">

        {{-- Flash message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-2 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-2 rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- FOTO PRODUK --}}
            <div>
                @php
                    $mainImage = $product->productImages->first();
                @endphp

                @if($mainImage)
                    <img src="{{ asset('storage/' . $mainImage->image) }}"
                         class="w-full h-80 object-cover rounded-3xl shadow-lg"
                         alt="{{ $product->name }}">
                @else
                    {{-- DEFAULT FOTO --}}
                    <div class="w-full h-80 rounded-3xl shadow-lg bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                        <svg class="w-24 h-24 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif

                {{-- Thumbnail kecil --}}
                @if($product->productImages->count() > 1)
                    <div class="flex gap-3 mt-4 overflow-x-auto pb-1">
                        @foreach($product->productImages as $img)
                            <img src="{{ asset('storage/' . $img->image) }}"
                                 class="w-20 h-20 rounded-xl object-cover border border-gray-200 hover:border-orange-400 hover:scale-105 transition cursor-pointer"
                                 alt="">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- INFO PRODUK --}}
            <div class="space-y-4">
                {{-- Kategori --}}
                <p class="text-sm text-gray-500">
                    Kategori:
                    <span class="font-medium text-gray-700">
                        {{ $product->productCategory->name ?? '-' }}
                    </span>
                </p>

                {{-- Nama --}}
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                    {{ $product->name }}
                </h1>

                {{-- Rating & jumlah ulasan --}}
                <div class="flex items-center gap-3 text-sm">
                    @php
                        $reviewCountLocal = $product->productReviews->count();
                    @endphp

                    @if($reviewCountLocal > 0)
                        @php
                            $avgLocal = round($product->productReviews->avg('rating'), 1);
                        @endphp
                        <div class="flex items-center gap-1">
                            <div class="text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($avgLocal))
                                        ⭐
                                    @else
                                        <span class="text-gray-300">⭐</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="font-semibold text-gray-800">
                                {{ $avgLocal }}
                            </span>
                            <span class="text-gray-400">
                                ({{ $reviewCountLocal }} ulasan)
                            </span>
                        </div>
                    @else
                        <span class="text-gray-400 italic">
                            Belum ada ulasan
                        </span>
                    @endif
                </div>

                {{-- Harga & Stok --}}
                <div class="flex items-center justify-between gap-3">
                    <p class="text-3xl font-extrabold text-orange-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    @isset($product->stock)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                     {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            Stok tersedia: {{ $product->stock }}
                        </span>
                    @endisset
                </div>

                {{-- Toko --}}
                <p class="text-sm text-gray-500">
                    Toko:
                    <span class="font-medium text-gray-700">
                        {{ $product->store->name ?? '-' }}
                    </span>
                </p>

                {{-- Deskripsi --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-4 text-sm text-gray-700 leading-relaxed shadow-sm">
                    {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                </div>

                {{-- Tombol tambah ke keranjang --}}
                <div class="pt-2">
                    @auth
                        @if(auth()->user()->role === 'buyer')
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-7 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transition">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-7 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transition">
                            Login untuk Belanja
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- ULASAN & KOMENTAR --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mt-4 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-bold text-gray-900">
                    Ulasan & Komentar
                </h2>

                @php
                    $reviewCountHeader = $product->productReviews->count();
                @endphp

                @if($reviewCountHeader > 0)
                    @php
                        $avgHeader = round($product->productReviews->avg('rating'), 1);
                    @endphp
                    <div class="text-xs text-gray-500">
                        Rata-rata:
                        <span class="font-semibold text-gray-800">{{ $avgHeader }}</span>
                        • {{ $reviewCountHeader }} ulasan
                    </div>
                @endif
            </div>

            {{-- LIST ULASAN --}}
            @if($product->productReviews->count())
                <div class="space-y-4">
                    @foreach($product->productReviews as $rev)
                        <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2 text-xs">
                                    <div class="text-yellow-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $rev->rating)
                                                ⭐
                                            @else
                                                <span class="text-gray-300">⭐</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="font-semibold text-gray-700">
                                        {{ $rev->rating }}/5
                                    </span>
                                </div>

                                @if($rev->created_at)
                                    <span class="text-[11px] text-gray-400">
                                        {{ $rev->created_at->format('d M Y') }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ $rev->review }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="border border-dashed border-gray-200 rounded-2xl p-4 text-sm text-gray-500 bg-gray-50">
                    Belum ada ulasan untuk produk ini.
                </div>
            @endif

            {{-- FORM ULASAN: hanya buyer yang SUDAH PERNAH BELI & BELUM PERNAH REVIEW --}}
            @auth
                @if(auth()->user()->role === 'buyer')
                    @if($canReview ?? false)
                        <div class="border-t border-gray-100 pt-4">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">
                                Tulis Ulasan
                            </h3>

                            <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="space-y-3">
                                @csrf

                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Rating</label>
                                    <select name="rating"
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                                            required>
                                        <option value="">Pilih rating</option>
                                        <option value="5">⭐⭐⭐⭐⭐ - Sangat Puas</option>
                                        <option value="4">⭐⭐⭐⭐ - Puas</option>
                                        <option value="3">⭐⭐⭐ - Cukup</option>
                                        <option value="2">⭐⭐ - Kurang</option>
                                        <option value="1">⭐ - Sangat Buruk</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Komentar</label>
                                    <textarea name="review" rows="3"
                                              class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                                              placeholder="Ceritakan pengalaman kamu dengan produk ini..." required>{{ old('review') }}</textarea>
                                </div>

                                <button type="submit"
                                        class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-full shadow">
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @elseif(($hasBought ?? false) && ($alreadyReviewed ?? false))
                        <p class="text-xs text-gray-500 mt-4">
                            Kamu sudah memberikan ulasan untuk produk ini. Terima kasih! 🙌
                        </p>
                    @elseif(!($hasBought ?? false))
                        <p class="text-xs text-gray-500 mt-4">
                            Anda belum pernah membeli produk ini, jadi belum dapat menulis ulasan.
                        </p>
                    @endif
                @endif
            @else
                <p class="text-xs text-gray-500 mt-4">
                    <a href="{{ route('login') }}" class="text-orange-600 font-semibold">Login</a> untuk menulis ulasan.
                </p>
            @endauth
        </div>

        {{-- PRODUK TERKAIT --}}
        @if($relatedProducts->count())
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4">Produk Terkait</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $item)
                        <a href="{{ route('product.show', $item->slug) }}"
                           class="bg-white rounded-2xl shadow-sm hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 block">

                            @php
                                $relatedImage = $item->productImages->first();
                            @endphp

                            @if($relatedImage)
                                <img src="{{ asset('storage/' . $relatedImage->image) }}"
                                     class="w-full h-32 object-cover" alt="{{ $item->name }}">
                            @else
                                <div class="w-full h-32 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-3">
                                <p class="text-[11px] text-gray-500 mb-1">
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
