<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

        @if(session('error'))
            <div class="mb-4 rounded-md bg-amber-100 px-4 py-3 text-sm text-amber-800">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() == 0)
            <p class="text-gray-600">Keranjang kamu kosong.</p>
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
                    Pilih tombol <strong>"Checkout"</strong> di toko yang ingin kamu bayar dulu.
                </div>
            @endif

            <div class="space-y-6">
                @foreach($groupedByStore as $storeId => $items)
                    @php
                        $storeName = optional($items->first()->product->store)->name ?? 'Toko Tidak Diketahui';
                        $storeSubtotal = $items->sum(fn($item) => $item->product->price * $item->qty);
                    @endphp

                    <div class="bg-white rounded-xl shadow-md p-5">
                        {{-- Header toko --}}
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-sm text-gray-500">Toko</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $storeName }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase">Subtotal Toko</p>
                                <p class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format($storeSubtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="border-t pt-3 space-y-3">
                            @foreach($items as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . ($item->product->productImages->first()->image ?? 'default.jpg')) }}"
                                             class="w-16 h-16 object-cover rounded-lg">

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $item->product->name }}
                                            </p>

                                            <p class="text-orange-600 font-bold">
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>

                                            <form action="{{ route('cart.update', $item->id) }}"
                                                  method="POST"
                                                  class="flex items-center mt-1">
                                                @csrf
                                                <input
                                                    type="number"
                                                    name="qty"
                                                    min="1"
                                                    value="{{ $item->qty }}"
                                                    class="w-16 border rounded-lg px-2 py-1 text-sm"
                                                >
                                                <button
                                                    class="ml-2 inline-flex items-center px-3 py-1 bg-orange-500 hover:bg-orange-600
                                                           text-white rounded-lg text-xs font-semibold transition"
                                                >
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-sm text-red-600 hover:text-red-700 hover:underline font-semibold"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        {{-- Tombol checkout untuk toko ini --}}
                        <div class="mt-4 flex justify-between items-center">
                            <p class="text-xs text-gray-500">
                                Checkout hanya produk dari toko <span class="font-semibold">{{ $storeName }}</span>.
                            </p>
                            <form method="GET" action="{{ route('checkout.index') }}">
                                <input type="hidden" name="store_id" value="{{ $storeId }}">
                                <button
                                    class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-4 py-2
                                           rounded-lg font-semibold text-sm shadow-md transition"
                                >
                                    Checkout →
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total keseluruhan (opsional) --}}
            <div class="mt-8 p-6 bg-white shadow-lg rounded-xl">
                <h2 class="text-sm text-gray-500 uppercase tracking-wide">Total Semua Produk di Keranjang</h2>
                <p class="text-2xl font-bold text-gray-900">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Total ini dari semua toko. Checkout tetap dilakukan per toko.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
