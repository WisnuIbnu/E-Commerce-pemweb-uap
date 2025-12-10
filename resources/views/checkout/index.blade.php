{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $storeName = optional($cartItems->first()->product->store)->name ?? 'Toko';
            @endphp

            <h1 class="text-2xl font-semibold mb-1">
                Checkout - {{ $storeName }}
            </h1>

            @if(isset($storesInCart) && $storesInCart->count() > 1)
                <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 px-3 py-2 rounded mb-4">
                    Saat ini kamu hanya akan checkout produk dari toko
                    <strong>{{ $storeName }}</strong>.
                    Produk dari toko lain tetap ada di keranjang dan bisa kamu checkout nanti.
                </p>
            @else
                <div class="mb-4"></div>
            @endif

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

                    {{-- store_id dari controller --}}
                    <input type="hidden" name="store_id" value="{{ $storeId }}">

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

                    {{-- JENIS PENGIRIMAN (DENGAN HARGA ONGKIR + ESTIMASI) --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Jenis Pengiriman</label>

                        @php
                            $shippingTypeOld = old('shipping_type', 'REG');
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            {{-- REG --}}
                            <div>
                                <input
                                    type="radio"
                                    name="shipping_type"
                                    id="shipping_reg"
                                    value="REG"
                                    class="peer hidden"
                                    {{ $shippingTypeOld === 'REG' ? 'checked' : '' }}
                                >
                                <label for="shipping_reg"
                                    class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1 border-gray-200
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold">REG</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Reguler</p>
                                    <p class="text-xs text-gray-500">Estimasi 2 - 4 hari kerja</p>
                                    <p class="text-sm font-semibold text-gray-900">Rp 20.000</p>
                                </label>
                            </div>

                            {{-- EXP --}}
                            <div>
                                <input
                                    type="radio"
                                    name="shipping_type"
                                    id="shipping_exp"
                                    value="EXP"
                                    class="peer hidden"
                                    {{ $shippingTypeOld === 'EXP' ? 'checked' : '' }}
                                >
                                <label for="shipping_exp"
                                    class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1 border-gray-200
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold">EXP</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Express</p>
                                    <p class="text-xs text-gray-500">Estimasi 1 - 2 hari kerja</p>
                                    <p class="text-sm font-semibold text-gray-900">Rp 35.000</p>
                                </label>
                            </div>

                            {{-- SDS --}}
                            <div>
                                <input
                                    type="radio"
                                    name="shipping_type"
                                    id="shipping_sds"
                                    value="SDS"
                                    class="peer hidden"
                                    {{ $shippingTypeOld === 'SDS' ? 'checked' : '' }}
                                >
                                <label for="shipping_sds"
                                    class="border rounded-xl p-3 cursor-pointer flex flex-col gap-1 border-gray-200
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold">SDS</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Same Day</p>
                                    <p class="text-xs text-gray-500">Estimasi di hari yang sama</p>
                                    <p class="text-sm font-semibold text-gray-900">Rp 50.000</p>
                                </label>
                            </div>
                        </div>
                        @error('shipping_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>

                        @php
                            $paymentOld = old('payment_method', 'BCA_VA');

                            $paymentMethods = [
                                [
                                    'value' => 'BCA_VA',
                                    'label' => 'BCA Virtual Account',
                                    'desc'  => 'Transfer via VA BCA',
                                    'type'  => 'bank',
                                    'logo'  => 'https://static.openfintech.io/payment_methods/bank_central_asia/logo.svg?w=200',
                                ],
                                [
                                    'value' => 'BNI_VA',
                                    'label' => 'BNI Virtual Account',
                                    'desc'  => 'Transfer via VA BNI',
                                    'type'  => 'bank',
                                    'logo'  => 'https://static.openfintech.io/payment_methods/bank_negara_indonesia/logo.svg?w=200',
                                ],
                                [
                                    'value' => 'BRI_VA',
                                    'label' => 'BRI Virtual Account',
                                    'desc'  => 'Transfer via VA BRI',
                                    'type'  => 'bank',
                                    'logo'  => 'https://static.openfintech.io/payment_methods/bank_rakyat_indonesia/logo.svg?w=200',
                                ],
                                [
                                    'value' => 'MANDIRI_VA',
                                    'label' => 'Mandiri Virtual Account',
                                    'desc'  => 'Transfer via VA Mandiri',
                                    'type'  => 'bank',
                                    'logo'  => 'https://static.openfintech.io/payment_methods/mandiri_bank/logo.svg?w=200',
                                ],
                                [
                                    'value' => 'QRIS',
                                    'label' => 'QRIS',
                                    'desc'  => 'Scan QR semua e-wallet & bank',
                                    'type'  => 'special',
                                    'short' => 'QR',
                                    'color' => 'bg-black',
                                ],
                                [
                                    'value' => 'COD',
                                    'label' => 'Bayar di Tempat (COD)',
                                    'desc'  => 'Bayar tunai saat barang diterima',
                                    'type'  => 'special',
                                    'short' => 'COD',
                                    'color' => 'bg-amber-500',
                                ],
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($paymentMethods as $pm)
                                <div>
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        id="payment_{{ $pm['value'] }}"
                                        value="{{ $pm['value'] }}"
                                        class="peer hidden"
                                        {{ $paymentOld === $pm['value'] ? 'checked' : '' }}
                                    >
                                    <label for="payment_{{ $pm['value'] }}"
                                        class="border rounded-xl p-3 cursor-pointer flex items-center gap-3 border-gray-200
                                               peer-checked:border-orange-500 peer-checked:bg-orange-50">

                                        {{-- BANK: pakai logo SVG --}}
                                        @if($pm['type'] === 'bank')
                                            <img
                                                src="{{ $pm['logo'] }}"
                                                alt="{{ $pm['label'] }} Logo"
                                                class="h-6 w-6 object-contain"
                                            >
                                        @else
                                            {{-- QRIS & COD: kotak warna dengan teks (seperti contoh) --}}
                                            <div class="w-9 h-9 rounded-md flex items-center justify-center text-[10px] font-bold text-white {{ $pm['color'] }}">
                                                {{ $pm['short'] }}
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-sm font-semibold">{{ $pm['label'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $pm['desc'] }}</p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
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
