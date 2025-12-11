{{-- resources/views/transactions/index.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Riwayat Transaksi
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Lihat riwayat pembayaran pesanan Anda.
                </p>
            </div>

            @if($transactions->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-200 p-8 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Belum ada transaksi</h2>
                    <p class="text-sm text-gray-500">
                        Transaksi Anda akan muncul di sini setelah melakukan pembayaran.
                    </p>
                </div>
            @else

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block overflow-x-auto bg-white shadow rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-600">Total</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-600">Status</th>
                                <th class="px-6 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($transactions as $trx)
                                @php
                                    $statusMap = [
                                        'pending'              => ['Menunggu Pembayaran', 'bg-yellow-100 text-yellow-700'],
                                        'waiting_confirmation' => ['Menunggu Konfirmasi', 'bg-orange-100 text-orange-700'],
                                        'paid'                 => ['Sudah Dibayar', 'bg-green-100 text-green-700'],
                                        'failed'               => ['Gagal', 'bg-red-100 text-red-700'],
                                    ];
                                    $map = $statusMap[$trx->payment_status] ?? ['-', 'bg-gray-100 text-gray-600'];
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $trx->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 whitespace-nowrap">
                                        Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs rounded-full {{ $map[1] }}">
                                            {{ $map[0] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('transactions.show', $trx->id) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE CARD VERSION --}}
                <div class="md:hidden space-y-3">
                    @foreach ($transactions as $trx)
                        @php
                            $statusMap = [
                                'pending'              => ['Menunggu Pembayaran', 'bg-yellow-100 text-yellow-700'],
                                'waiting_confirmation' => ['Menunggu Konfirmasi', 'bg-orange-100 text-orange-700'],
                                'paid'                 => ['Sudah Dibayar', 'bg-green-100 text-green-700'],
                                'failed'               => ['Gagal', 'bg-red-100 text-red-700'],
                            ];
                            $map = $statusMap[$trx->payment_status] ?? ['-', 'bg-gray-100 text-gray-600'];
                        @endphp

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $trx->code }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $trx->created_at->format('d M Y H:i') }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-700">
                                        Total:
                                        <span class="font-semibold">
                                            Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                        </span>
                                    </p>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs {{ $map[1] }}">
                                    {{ $map[0] }}
                                </span>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('transactions.show', $trx->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
