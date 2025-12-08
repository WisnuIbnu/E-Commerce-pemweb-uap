{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

            {{-- RINGKASAN KERANJANG --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-3">Ringkasan Keranjang</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left">Produk</th>
                                <th class="px-3 py-2 text-center">Qty</th>
                                <th class="px-3 py-2 text-right">Harga</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr class="border-b">
                                    <td class="px-3 py-2">
                                        {{ $item->product->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        Rp {{ number_format(($item->product->price ?? 0) * $item->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="px-3 py-2 text-right">Total</th>
                                <th class="px-3 py-2 text-right">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- FORM ALAMAT / PENGIRIMAN / PEMBAYARAN --}}
            <div class="bg-white shadow-sm rounded-lg p-4 space-y-6">
                <h2 class="text-lg font-semibold mb-1">Data Pengiriman</h2>

                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- ALAMAT --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Alamat</label>
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address', $buyer->address ?? '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            required
                        >
                        @error('address')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Kota</label>
                            <input
                                type="text"
                                name="city"
                                value="{{ old('city', $buyer->city ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                required
                            >
                            @error('city')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Kode Pos</label>
                            <input
                                type="text"
                                name="postal_code"
                                value="{{ old('postal_code', $buyer->postal_code ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                required
                            >
                            @error('postal_code')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- JASA PENGIRIMAN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Jasa Pengiriman</label>
                            <select
                                name="shipping"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                required
                            >
                                <option value="">-- Pilih Jasa Pengiriman --</option>
                                <option value="JNE" {{ old('shipping') === 'JNE' ? 'selected' : '' }}>JNE</option>
                                <option value="J&T" {{ old('shipping') === 'J&T' ? 'selected' : '' }}>J&amp;T</option>
                                <option value="SiCepat" {{ old('shipping') === 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                                <option value="POS" {{ old('shipping') === 'POS' ? 'selected' : '' }}>POS Indonesia</option>
                                <option value="TIKI" {{ old('shipping') === 'TIKI' ? 'selected' : '' }}>TIKI</option>
                            </select>
                            @error('shipping')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- JENIS PENGIRIMAN (DENGAN HARGA ONGKIR) --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Jenis Pengiriman</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            {{-- REG --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1
                                           @if(old('shipping_type') === 'REG') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold">REG</span>
                                    <input
                                        type="radio"
                                        name="shipping_type"
                                        value="REG"
                                        class="text-orange-500 focus:ring-orange-500"
                                        {{ old('shipping_type', 'REG') === 'REG' ? 'checked' : '' }}
                                    >
                                </div>
                                <p class="text-xs text-gray-500">Reguler</p>
                                <p class="text-sm font-semibold text-gray-900">Rp 20.000</p>
                            </label>

                            {{-- EXP --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1
                                           @if(old('shipping_type') === 'EXPRESS') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold">EXP</span>
                                    <input
                                        type="radio"
                                        name="shipping_type"
                                        value="EXPRESS"
                                        class="text-orange-500 focus:ring-orange-500"
                                        {{ old('shipping_type') === 'EXPRESS' ? 'checked' : '' }}
                                    >
                                </div>
                                <p class="text-xs text-gray-500">Express</p>
                                <p class="text-sm font-semibold text-gray-900">Rp 35.000</p>
                            </label>

                            {{-- SAME DAY / SDS --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1
                                           @if(old('shipping_type') === 'SDS') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold">SDS</span>
                                    <input
                                        type="radio"
                                        name="shipping_type"
                                        value="SDS"
                                        class="text-orange-500 focus:ring-orange-500"
                                        {{ old('shipping_type') === 'SDS' ? 'checked' : '' }}
                                    >
                                </div>
                                <p class="text-xs text-gray-500">Same Day</p>
                                <p class="text-sm font-semibold text-gray-900">Rp 50.000</p>
                            </label>
                        </div>
                        @error('shipping_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            {{-- BCA VA --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex items-center gap-2
                                           @if(old('payment_method') === 'BCA_VA') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="BCA_VA"
                                    class="text-orange-500 focus:ring-orange-500"
                                    {{ old('payment_method', 'BCA_VA') === 'BCA_VA' ? 'checked' : '' }}
                                >
                                <div>
                                    <p class="text-sm font-semibold">BCA Virtual Account</p>
                                    <p class="text-xs text-gray-500">Transfer via VA BCA</p>
                                </div>
                            </label>

                            {{-- BNI VA --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex items-center gap-2
                                           @if(old('payment_method') === 'BNI_VA') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="BNI_VA"
                                    class="text-orange-500 focus:ring-orange-500"
                                    {{ old('payment_method') === 'BNI_VA' ? 'checked' : '' }}
                                >
                                <div>
                                    <p class="text-sm font-semibold">BNI Virtual Account</p>
                                    <p class="text-xs text-gray-500">Transfer via VA BNI</p>
                                </div>
                            </label>

                            {{-- QRIS --}}
                            <label class="border rounded-xl p-3 cursor-pointer flex items-center gap-2
                                           @if(old('payment_method') === 'QRIS') border-orange-500 bg-orange-50 @else border-gray-200 @endif">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="QRIS"
                                    class="text-orange-500 focus:ring-orange-500"
                                    {{ old('payment_method') === 'QRIS' ? 'checked' : '' }}
                                >
                                <div>
                                    <p class="text-sm font-semibold">QRIS</p>
                                    <p class="text-xs text-gray-500">Scan QR untuk pembayaran</p>
                                </div>
                            </label>

                        </div>
                        @error('payment_method')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700
                                   border border-transparent rounded-md font-semibold text-xs text-white uppercase
                                   tracking-widest focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition"
                        >
                            Buat Pesanan &amp; Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
