{{-- resources/views/seller/orders/index.blade.php --}}
<x-seller-layout>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#f97316',
                });
            });
        </script>
    @endif

    <div class="py-6">
        <div class="max-w-6xl mx-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola pesanan yang masuk ke toko
                        <span class="font-semibold">{{ $store->name }}</span>.
                    </p>
                </div>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-200 p-8 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Belum ada pesanan</h2>
                    <p class="text-sm text-gray-500">
                        Pesanan pelanggan akan tampil di sini setelah mereka checkout produk Anda.
                    </p>
                </div>
            @else
                {{-- WRAPPER LIST PESANAN --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 md:max-h-[600px] md:overflow-y-auto">

                    {{-- MOBILE: kartu --}}
                    <div class="md:hidden divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            @php
                                $statusMap = [
                                    'pending' => [
                                        'label' => 'Menunggu Pembayaran',
                                        'class' => 'bg-yellow-50 text-yellow-700',
                                    ],
                                    'waiting_confirmation' => [
                                        'label' => 'Menunggu Konfirmasi Admin',
                                        'class' => 'bg-orange-50 text-orange-700',
                                    ],
                                    'paid' => [
                                        'label' => 'Sudah Dibayar',
                                        'class' => 'bg-green-50 text-green-700',
                                    ],
                                    'processing' => [
                                        'label' => 'Sedang Diproses Toko',
                                        'class' => 'bg-blue-50 text-blue-700',
                                    ],
                                    'shipped' => [
                                        'label' => 'Dalam Pengiriman',
                                        'class' => 'bg-indigo-50 text-indigo-700',
                                    ],
                                    'delivered' => [
                                        'label' => 'Telah Diterima',
                                        'class' => 'bg-green-100 text-green-700',
                                    ],
                                    'completed' => [
                                        'label' => 'Selesai',
                                        'class' => 'bg-gray-100 text-gray-600',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Dibatalkan',
                                        'class' => 'bg-red-50 text-red-600',
                                    ],
                                ];

                                // pakai kolom payment_status
                                $status = $statusMap[$order->payment_status] ?? null;
                            @endphp

                            <a href="{{ route('seller.orders.show', $order) }}" class="block p-4 hover:bg-gray-50">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            #{{ $order->code ?? $order->id }} • {{ $order->buyer->user->name ?? 'Pembeli' }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>

                                    @if($status)
                                        <span
                                            class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-2 text-xs text-gray-600 flex justify-between">
                                    <span>
                                        Total:
                                        <span class="font-semibold text-gray-900">
                                            Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}
                                        </span>
                                    </span>
                                    <span>
                                        Item: {{ optional($order->details)->sum('qty') ?? '-' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- DESKTOP: tabel --}}
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pesanan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pembeli
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    @php
                                        $statusMap = [
                                            'pending' => [
                                                'label' => 'Menunggu Pembayaran',
                                                'class' => 'bg-yellow-50 text-yellow-700',
                                            ],
                                            'waiting_confirmation' => [
                                                'label' => 'Menunggu Konfirmasi Admin',
                                                'class' => 'bg-orange-50 text-orange-700',
                                            ],
                                            'paid' => [
                                                'label' => 'Sudah Dibayar',
                                                'class' => 'bg-green-50 text-green-700',
                                            ],
                                            'processing' => [
                                                'label' => 'Sedang Diproses Toko',
                                                'class' => 'bg-blue-50 text-blue-700',
                                            ],
                                            'shipped' => [
                                                'label' => 'Dalam Pengiriman',
                                                'class' => 'bg-indigo-50 text-indigo-700',
                                            ],
                                            'delivered' => [
                                                'label' => 'Telah Diterima',
                                                'class' => 'bg-green-100 text-green-700',
                                            ],
                                            'completed' => [
                                                'label' => 'Selesai',
                                                'class' => 'bg-gray-100 text-gray-600',
                                            ],
                                            'cancelled' => [
                                                'label' => 'Dibatalkan',
                                                'class' => 'bg-red-50 text-red-600',
                                            ],
                                        ];

                                        $status = $statusMap[$order->payment_status] ?? null;
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                #{{ $order->code ?? $order->id }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $order->details->sum('qty') ?? 0 }} item •
                                                {{ $order->details->pluck('product.name')->join(', ') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $order->buyer->user->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($status)
                                                <span
                                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $status['class'] }}">
                                                    {{ $status['label'] }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('seller.orders.show', $order) }}"
                                               class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- PAGINATION --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-seller-layout>
