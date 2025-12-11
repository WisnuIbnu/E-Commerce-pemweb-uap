{{-- resources/views/seller/orders/show.blade.php --}}
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
        {{-- tambah px-4 biar nggak terlalu mepet di kiri-kanan --}}
        <div class="max-w-5xl mx-auto px-4 lg:px-0 space-y-4">
            {{-- BREADCRUMB --}}
            <div class="text-sm text-gray-500 mb-2">
                <a href="{{ route('seller.orders.index') }}" class="hover:text-orange-500">Pesanan Masuk</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700 font-medium">Detail Pesanan</span>
            </div>

            {{-- HEADER --}}
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">
                        Pesanan #{{ $order->id }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Pembeli:
                        <span class="font-semibold text-gray-700">
                            {{ $order->buyer->user->name ?? '-' }}
                        </span>
                    </p>
                </div>

                @php
                    // gunakan kolom payment_status dari tabel transactions
                    $status = $order->payment_status;
                    $badgeClass = match ($status) {
                        'pending'    => 'bg-yellow-50 text-yellow-700',
                        'processing' => 'bg-blue-50 text-blue-700',
                        'shipped'    => 'bg-indigo-50 text-indigo-700',
                        'completed'  => 'bg-green-50 text-green-700',
                        'cancelled'  => 'bg-red-50 text-red-700',
                        default      => 'bg-gray-100 text-gray-600',
                    };
                @endphp

                <div class="flex flex-col items-start md:items-end gap-2">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                        {{ ucfirst($status) }}
                    </span>

                    @if (!empty($order->tracking_number))
                        <p class="text-xs text-gray-500">
                            Resi: <span class="font-mono">{{ $order->tracking_number }}</span>
                        </p>
                    @endif
                </div>
            </div>

            {{-- konten utama --}}
            <div class="grid md:grid-cols-3 gap-6">
                {{-- DETAIL ITEM --}}
                <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Produk dalam pesanan</h2>

                    <div class="divide-y divide-gray-100">
                        @forelse ($order->details as $item)
                            <div class="py-3 flex gap-3">
                                @if ($item->product?->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         class="w-12 h-12 rounded-lg object-cover bg-gray-100 flex-shrink-0"
                                         alt="{{ $item->product->name }}">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 flex-shrink-0">
                                        No Image
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex justify-between gap-2">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $item->product->name ?? 'Produk' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Qty: {{ $item->qty }} × Rp
                                                {{ number_format($item->price ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            Rp
                                            {{ number_format($item->qty * ($item->price ?? 0), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Tidak ada item dalam pesanan ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- RINGKASAN + FORM STATUS --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3">Ringkasan</h2>

                        <dl class="space-y-2 text-sm">
                            @php
                                $subtotal = $order->details->sum(function ($item) {
                                    return $item->qty * ($item->price ?? 0);
                                });
                            @endphp

                            <div class="flex justify-between">
                                <dt class="text-gray-500">Subtotal</dt>
                                <dd class="text-gray-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </dd>
                            </div>

                            <div class="flex justify-between">
                                <dt class="text-gray-500">Ongkir</dt>
                                <dd class="text-gray-900">
                                    Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}
                                </dd>
                            </div>

                            <div class="border-t pt-2 mt-2 flex justify-between font-semibold">
                                <dt class="text-gray-800">Total</dt>
                                <dd class="text-gray-900">
                                    Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3">Update Status</h2>

                        <form action="{{ route('seller.orders.update', $order) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    Status Pesanan
                                </label>
                                <select name="status"
                                        class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm">
                                    @foreach ([
                                        'pending'    => 'Menunggu',
                                        'processing' => 'Diproses',
                                        'shipped'    => 'Dikirim',
                                        'completed'  => 'Selesai',
                                        'cancelled'  => 'Dibatalkan',
                                    ] as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected($order->payment_status == $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    Nomor Resi (opsional)
                                </label>
                                <input type="text" name="tracking_number"
                                       value="{{ old('tracking_number', $order->tracking_number) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                       placeholder="Misal: JP123456789ID">
                                @error('tracking_number')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit"
                                        class="px-4 py-2 text-sm rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-seller-layout>
