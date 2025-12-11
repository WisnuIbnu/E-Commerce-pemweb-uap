{{-- resources/views/orders/index.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Aktif</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Lacak pesanan yang masih dalam proses dan pengiriman.
                </p>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white border border-dashed border-gray-200 rounded-xl p-8 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada pesanan aktif saat ini.</h2>
                    <p class="text-sm text-gray-500 mb-3">
                        Yuk belanja lagi kebutuhan harianmu di Sembako Mart.
                    </p>
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center text-sm font-medium text-orange-500 hover:text-orange-600">
                        Belanja sekarang →
                    </a>
                </div>
            @else
                @php
                    // Badge payment
                    $paymentMap = [
                        'pending'              => ['label' => 'pending', 'class' => 'bg-yellow-50 text-yellow-700'],
                        'waiting_confirmation' => ['label' => 'menunggu konfirmasi', 'class' => 'bg-orange-50 text-orange-700'],
                        'paid'                 => ['label' => 'paid', 'class' => 'bg-green-50 text-green-700'],
                        'failed'               => ['label' => 'gagal', 'class' => 'bg-red-50 text-red-700'],
                    ];

                    // Badge shipping
                    $shippingMap = [
                        'processing' => ['label' => 'Diproses', 'class' => 'bg-blue-50 text-blue-700'],
                        'packed'     => ['label' => 'Dikemas', 'class' => 'bg-blue-50 text-blue-700'],
                        'shipped'    => ['label' => 'Dikirim', 'class' => 'bg-indigo-50 text-indigo-700'],
                        'delivered'  => ['label' => 'Diterima', 'class' => 'bg-green-50 text-green-700'],
                    ];
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- MOBILE: CARD LIST --}}
                    <div class="divide-y divide-gray-100 md:hidden">
                        @foreach ($orders as $order)
                            @php
                                $payment = $paymentMap[$order->payment_status] ?? ['label' => $order->payment_status, 'class' => 'bg-gray-100 text-gray-600'];
                                $shipKey = $order->shipping ?: 'processing';
                                $shipping = $shippingMap[$shipKey] ?? ['label' => ucfirst($shipKey), 'class' => 'bg-gray-100 text-gray-600'];
                            @endphp

                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            #{{ $order->code ?? $order->id }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                        <p class="mt-2 text-xs text-gray-600">
                                            Total:
                                            <span class="font-semibold text-gray-900">
                                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-2">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium {{ $payment['class'] }}">
                                            {{ $payment['label'] }}
                                        </span>
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium {{ $shipping['class'] }}">
                                            {{ $order->shipping ?? $order->shipping_type ?? 'Kurir' }}
                                        </span>

                                        <a href="{{ route('orders.track', $order->id) }}"
                                           class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-orange-500 text-white hover:bg-orange-600">
                                            Lacak Pesanan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- DESKTOP: TABLE --}}
                    <div class="hidden md:block">
                        <table class="min-w-full text-sm divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pembayaran
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengiriman
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    @php
                                        $payment = $paymentMap[$order->payment_status] ?? ['label' => $order->payment_status, 'class' => 'bg-gray-100 text-gray-600'];
                                        $shipKey = $order->shipping ?: 'processing';
                                        $shipping = $shippingMap[$shipKey] ?? ['label' => ucfirst($shipKey), 'class' => 'bg-gray-100 text-gray-600'];
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            #{{ $order->code ?? $order->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $payment['class'] }}">
                                                {{ $payment['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $shipping['class'] }}">
                                                {{ $order->shipping ?? $order->shipping_type ?? 'Kurir' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('orders.track', $order->id) }}"
                                               class="inline-flex items-center px-3 py-1 text-xs rounded-lg bg-orange-500 text-white hover:bg-orange-600">
                                                Lacak Pesanan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
