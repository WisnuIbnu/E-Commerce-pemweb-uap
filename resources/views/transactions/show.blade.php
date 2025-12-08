{{-- resources/views/transactions/show.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-2xl font-semibold mb-4">
                Transaksi {{ $transaction->code ?? ('#'.$transaction->id) }}
            </h1>

            {{-- INFO UTAMA --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <p class="text-sm text-gray-600">
                            Tanggal: {{ $transaction->created_at?->format('d-m-Y H:i') }}
                        </p>
                        <p class="mt-1">
                            <span class="text-sm text-gray-600">Total:</span>
                            <span class="font-semibold">
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">Status Pembayaran:</p>
                        <span class="{{ $transaction->status_badge_class }}">
                            {{ $transaction->status_label }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-semibold mb-1">Alamat Pengiriman</p>
                    <p class="text-sm text-gray-700">
                        {{ $transaction->address }}<br>
                        {{ $transaction->city }} {{ $transaction->postal_code }}
                    </p>
                </div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-3">Detail Produk</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left">Produk</th>
                                <th class="px-3 py-2 text-left">Toko</th>
                                <th class="px-3 py-2 text-center">Qty</th>
                                <th class="px-3 py-2 text-right">Harga</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transactionDetails as $detail)
                                <tr class="border-b">
                                    <td class="px-3 py-2">
                                        {{ $detail->product->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $detail->product->store->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        {{ $detail->qty }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- BAGIAN PEMBAYARAN --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                @if ($transaction->payment_status === \App\Models\Transaction::STATUS_PENDING)
                    <h2 class="text-lg font-semibold mb-3">Pembayaran</h2>

                    <p class="text-sm text-gray-700 mb-2">
                        Silakan transfer ke rekening berikut:
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-800 mb-4">
                        <li><strong>BCA</strong> 1234 5678 90 a.n. Toko Contoh</li>
                    </ul>

                    <p class="text-sm text-gray-700 mb-4">
                        Setelah melakukan transfer, klik tombol di bawah untuk konfirmasi bahwa Anda sudah membayar.
                    </p>

                    <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST">
                        @csrf
                        {{-- kalau mau pilih metode pembayaran, bisa tambahkan input hidden di sini --}}
                        {{-- <input type="hidden" name="payment_method" value="bank_transfer"> --}}

                        <button
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 
                                text-white rounded-md font-semibold shadow transition">
                            Saya sudah bayar
                        </button>
                    </form>
                @else
                    <div class="rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                        Pembayaran sudah diterima. Terima kasih! 🎉
                    </div>
                @endif

                <div class="mt-4">
                    <a
                        href="{{ route('transactions.index') }}"
                        class="text-sm text-orange-500 hover:text-orange-600"
                    >
                        ← Kembali ke Riwayat Transaksi
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
