<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>

        {{-- List produk di cart --}}
        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Belanja</h2>

            @foreach($cartItems as $item)
                <div class="flex justify-between items-center border-b py-3">
                    <div>
                        <p class="font-semibold">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-500">
                            Toko: {{ $item->product->store->name ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->qty }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-orange-600 font-bold">
                            Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center mt-4">
                <span class="font-semibold text-lg">Total</span>
                <span class="font-bold text-2xl text-orange-600">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Form alamat & pengiriman --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Detail Pengiriman</h2>

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3"
                              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500"
                              required>@if($buyer){{ $buyer->address ?? '' }}@endif</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                        <input type="text" name="city"
                               value="{{ $buyer->city ?? '' }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code"
                               value="{{ $buyer->postal_code ?? '' }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500"
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ekspedisi</label>
                        <input type="text" name="shipping"
                               placeholder="JNE / J&T / SiCepat"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                        <select name="shipping_type"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500"
                                required>
                            <option value="REG">REG</option>
                            <option value="YES">YES</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
