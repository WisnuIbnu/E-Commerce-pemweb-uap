<x-app-layout>
    {{-- HEADER GRADIENT (width & ukuran teks sama My Products) --}}
    <div class="bg-gray-900 pt-6">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-blue-700 to-blue-500 py-8 shadow-xl">

                <div class="relative px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">📦</span>
                        <h2 class="text-2xl font-semibold text-white">
                            Your Orders Overview
                        </h2>
                    </div>

                    <p class="text-sm text-blue-100 mt-2">
                        Manage and track all customer orders efficiently.
                    </p>
                </div>

                <div class="pointer-events-none absolute top-3 right-6 w-32 h-32 bg-blue-300 bg-opacity-20 rounded-full blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-6 left-0 w-40 h-40 bg-white bg-opacity-10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>



    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- CARD CONTENT (mirip My Products) --}}
            <div class="relative overflow-hidden rounded-3xl bg-gray-900 border border-gray-800 shadow-2xl">

                {{-- Header card --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-100">Daftar Pesanan</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-400">
                            Ringkasan semua pesanan yang masuk ke toko kamu.
                        </p>
                    </div>
                </div>

                <div class="px-6 pt-4 pb-6">
                    {{-- ALERT --}}
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-blue-500 bg-opacity-20 border border-blue-400 text-blue-100 rounded-xl font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-400 text-red-100 rounded-xl font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- TABEL --}}
                    @if ($orders->isEmpty())
                        <p class="text-center text-gray-400 text-lg py-6">
                            Belum ada pesanan.
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-200">
                                <thead class="bg-gray-900 border-b border-gray-800 text-xs uppercase tracking-wide text-gray-400">
                                    <tr>
                                        <th class="px-4 py-3">#</th>
                                        <th class="px-4 py-3">Customer</th>
                                        <th class="px-4 py-3">Produk</th>
                                        <th class="px-4 py-3">Total</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $index => $order)
                                        <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                            <td class="px-4 py-3 font-semibold text-gray-100">
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="px-4 py-3 text-gray-200">
                                                {{ $order->customer_name }}
                                            </td>

                                            <td class="px-4 py-3 text-gray-200">
                                                {{ $order->product_name }}
                                            </td>

                                            <td class="px-4 py-3 font-bold text-blue-300">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>

                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($order->status === 'Pending')
                                                        bg-yellow-400 text-gray-900
                                                    @elseif($order->status === 'Completed')
                                                        bg-green-500 text-white
                                                    @else
                                                        bg-gray-600 text-gray-100
                                                    @endif">
                                                    {{ $order->status }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-gray-300">
                                                {{ $order->created_at->format('d M Y') }}
                                            </td>

                                            <td class="px-4 py-3">
                                                <div class="inline-flex items-center gap-2 bg-gray-900 border border-gray-700 rounded-full px-3 py-1">
                                                    <a href="{{ route('seller.orders.show', $order->id) }}"
                                                       class="inline-flex items-center justify-center rounded-full bg-blue-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-blue-400 transition-colors">
                                                        Detail
                                                    </a>

                                                    <a href="{{ route('seller.orders.updateStatus', $order->id) }}"
                                                       class="inline-flex items-center justify-center rounded-full bg-green-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-green-400 transition-colors">
                                                        Update
                                                    </a>
                                                </div>
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
    </div>
</x-app-layout>
