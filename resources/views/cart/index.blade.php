{{-- resources/views/cart/index.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-0">

        <h1 class="text-2xl sm:text-3xl font-bold mb-6">Keranjang Belanja</h1>

        @if(session('error'))
            <div class="mb-4 rounded-md bg-amber-100 px-4 py-3 text-sm text-amber-800">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() === 0)
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-700 font-semibold mb-1">Keranjang kamu kosong</p>
                    <p class="text-sm text-gray-500">Yuk cari produk kebutuhan harian di halaman produk.</p>
                </div>
                <a href="{{ route('products.index') ?? '#' }}"
                   class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold shadow">
                    Belanja Sekarang
                </a>
            </div>
        @else
            @php
                // group item berdasarkan toko
                $groupedByStore = $cartItems->groupBy(function ($item) {
                    return optional($item->product->store)->id;
                });

                $storeCount = $groupedByStore->count();
            @endphp

            @if($storeCount > 1)
                <div class="mb-4 rounded-md bg-amber-50 px-4 py-3 text-sm text-amber-800 border border-amber-200">
                    Keranjangmu berisi produk dari <strong>beberapa toko</strong>.
                    Checkout hanya bisa <strong>satu toko sekali</strong>.
                    Klik tombol <strong>"Checkout"</strong> di toko yang ingin kamu bayar dulu.
                </div>
            @endif

            <div class="space-y-5">
                @foreach($groupedByStore as $storeId => $items)
                    @php
                        $storeName = optional($items->first()->product->store)->name ?? 'Toko Tidak Diketahui';
                        $storeSubtotal = $items->sum(fn($item) => $item->product->price * $item->qty);
                    @endphp

                    {{-- KARTU TOKO --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        {{-- Header toko --}}
                        <div class="flex items-center justify-between px-5 py-3 border-b">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-xs font-bold text-orange-600">
                                    {{ strtoupper(substr($storeName, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Toko</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $storeName }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-[11px] text-gray-400 uppercase tracking-wide">Subtotal Toko</p>
                                <p class="text-base sm:text-lg font-bold text-gray-900">
                                    Rp {{ number_format($storeSubtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Daftar produk di toko ini --}}
                        <div class="px-5 py-4 space-y-4">
                            @foreach($items as $item)
                                @php
                                    $product = $item->product;
                                    $price   = $product->price;
                                    $stock   = $product->stock ?? 999999;
                                    $qty     = $item->qty; // biarkan sesuai DB; batas stok di handle form / controller
                                    $subtotal = $price * $qty;

                                    $imagePath = optional($product->productImages->first())->image;
                                    $imageUrl  = $imagePath
                                                ? asset('storage/' . $imagePath)
                                                : asset('images/default-product.png'); // default
                                @endphp

                                <div class="flex items-start justify-between gap-4 border-b last:border-b-0 pb-4 last:pb-0">
                                    <div class="flex items-start gap-4 flex-1">
                                        {{-- Gambar Produk --}}
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 border flex items-center justify-center">

                                            @php
                                                $img = $item->product->productImages->first()->image ?? null;
                                            @endphp

                                            @if ($img)
                                                {{-- Jika ada foto produk --}}
                                                <img 
                                                    src="{{ asset('storage/' . $img) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-contain"
                                                >
                                            @else
                                                {{-- Jika TIDAK ada foto → tampilkan ikon shopping bag --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    class="w-10 h-10 text-gray-400"
                                                    viewBox="0 0 24 24" fill="none" 
                                                    stroke="currentColor" stroke-width="2" 
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    
                                                    <path d="M6 2L3 7v13a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-3-5z"/>
                                                    <path d="M3 7h18"/>
                                                    <path d="M16 11a4 4 0 0 1-8 0"/>
                                                </svg>
                                            @endif
                                        </div>

                                        {{-- Info produk --}}
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 leading-snug">
                                                {{ $product->name }}
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Harga:
                                                <span class="text-orange-600 font-bold">
                                                    Rp {{ number_format($price, 0, ',', '.') }}
                                                </span>
                                            </p>

                                            {{-- Qty ala Shopee: - [qty] + + stok di samping --}}
                                            <form method="POST"
                                                  action="{{ route('cart.update', $item->id) }}"
                                                  class="mt-2 flex items-center gap-3">
                                                @csrf

                                                <div class="inline-flex items-center overflow-hidden rounded-2xl bg-gray-50 border border-gray-200">
                                                    {{-- Minus --}}
                                                    <button
                                                        type="button"
                                                        class="qty-btn px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-200 select-none"
                                                        data-target="qty-{{ $item->id }}"
                                                        data-step="-1">
                                                        −
                                                    </button>

                                                    {{-- Qty (readonly) --}}
                                                    <input
                                                        id="qty-{{ $item->id }}"
                                                        type="number"
                                                        name="qty"
                                                        value="{{ $qty }}"
                                                        min="1"
                                                        data-max="{{ $stock }}"
                                                        class="w-16 sm:w-16 text-center text-sm bg-white border-x border-gray-200
                                                               focus:outline-none pointer-events-none
                                                               appearance-none [-moz-appearance:textfield]"
                                                        style="font-variant-numeric: tabular-nums;"
                                                        readonly
                                                    >

                                                    {{-- Plus --}}
                                                    <button
                                                        type="button"
                                                        class="qty-btn px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-200 select-none"
                                                        data-target="qty-{{ $item->id }}"
                                                        data-step="1"
                                                    >
                                                        +
                                                    </button>
                                                </div>

                                                <span class="text-[11px] text-gray-400">
                                                    Stok: {{ $stock }}
                                                </span>
                                            </form>

                                            <p class="mt-1 text-sm text-gray-600">
                                                Subtotal:
                                                <span class="font-semibold">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Hapus --}}
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-xs sm:text-sm text-red-500 hover:text-red-600 hover:underline font-semibold"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        {{-- Footer toko: checkout --}}
                        <div class="px-5 py-3 bg-gray-50 rounded-b-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <p class="text-xs text-gray-500">
                                Checkout hanya produk dari toko
                                <span class="font-semibold">{{ $storeName }}</span>.
                            </p>
                            <form method="GET" action="{{ route('checkout.index') }}">
                                <input type="hidden" name="store_id" value="{{ $storeId }}">
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-semibold
                                           bg-orange-500 text-white hover:bg-orange-600 shadow-sm transition"
                                >
                                    Checkout →
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total keseluruhan (semua toko) --}}
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xs text-gray-500 uppercase tracking-wide">
                            Total Semua Produk di Keranjang
                        </h2>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Total ini dari semua toko. Checkout tetap dilakukan per toko.
                        </p>
                    </div>
                    <div class="hidden sm:block text-xs text-gray-400">
                        Pilih toko di atas untuk mulai checkout.
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Script + / - : auto submit & batas stok --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.qty-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.dataset.target;
                    const step = parseInt(this.dataset.step || '1', 10);
                    const input = document.getElementById(targetId);
                    if (!input) return;

                    const max = parseInt(input.dataset.max || '999999', 10);
                    let current = parseInt(input.value || '1', 10);
                    if (isNaN(current) || current < 1) current = 1;

                    let next = current + step;

                    // minimal 1
                    if (next < 1) next = 1;

                    // maksimal stok
                    if (next > max) {
                        next = max;
                        alert('Jumlah tidak boleh melebihi stok (' + max + ').');
                    }

                    if (next === current) return;

                    input.value = next;

                    // auto submit form
                    const form = this.closest('form');
                    if (form) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
