{{-- resources/views/seller/balance/index.blade.php --}}
<x-seller-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto">

            {{-- HEADER --}}
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Saldo Toko</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola saldo dan riwayat pemasukan untuk toko
                        <span class="font-semibold">{{ $store->name }}</span>.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('seller.withdrawals.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Riwayat Penarikan
                    </a>
                    <a href="{{ route('seller.withdrawals.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600">
                        Ajukan Penarikan
                    </a>
                </div>
            </div>

            {{-- KARTU RINGKASAN --}}
            <div class="grid gap-4 md:grid-cols-3 mb-6">

                {{-- Saldo utama --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Saldo Toko</p>
                        <p class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                            Rp {{ number_format($balance, 0, ',', '.') }}
                        </p>
                    </div>
                    <p class="mt-3 text-xs text-gray-400">
                        Saldo ini berdasarkan transaksi yang sudah berstatus
                        <span class="font-semibold text-gray-600">dibayar</span>.
                    </p>
                </div>

                {{-- Pemasukan hari ini --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Pemasukan Hari Ini</p>
                    <p class="mt-2 text-xl font-semibold text-gray-900">
                        Rp {{ number_format($todayIncome, 0, ',', '.') }}
                    </p>
                    <p class="mt-2 text-xs text-gray-400">
                        Total transaksi yang masuk ke saldo pada hari ini.
                    </p>
                </div>

                {{-- Total order paid --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Transaksi Dibayar</p>
                    <p class="mt-2 text-xl font-semibold text-gray-900">
                        {{ $totalOrdersPaid }}
                    </p>
                    <p class="mt-2 text-xs text-gray-400">
                        Jumlah pesanan dengan status pembayaran
                        <span class="font-semibold text-green-600">paid</span>.
                    </p>
                </div>
            </div>

            {{-- TABEL RIWAYAT SALDO (dari transaksi) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">
                        Riwayat Pemasukan
                    </h2>
                    <p class="text-xs text-gray-400">
                        Transaksi yang sudah dibayar.
                    </p>
                </div>

                @if ($transactions->isEmpty())
                    <div class="p-8 text-center text-sm text-gray-500">
                        Belum ada transaksi yang masuk ke saldo toko Anda.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pembeli
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Pembayaran
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $trx->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $trx->buyer->user->name ?? 'Pembeli' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-900">
                                        Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $trx->payment_status === 'paid'
                                                ? 'bg-green-50 text-green-700'
                                                : 'bg-yellow-50 text-yellow-700' }}">
                                            {{ $trx->payment_status === 'paid' ? 'Sudah Dibayar' : ucfirst($trx->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('seller.orders.show', $trx) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-700 hover:bg-gray-50">
                                            Lihat Pesanan
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-seller-layout>
