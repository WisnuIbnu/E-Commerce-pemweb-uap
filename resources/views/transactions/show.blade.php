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

            @php
                $subtotalProduk = $transaction->transactionDetails->sum('subtotal');
                $ongkir         = $transaction->shipping_cost ?? 0;
            @endphp

            {{-- 📦 PRODUK + 🧾 RINGKASAN PEMBAYARAN --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">

                {{-- 📦 PRODUK --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Produk</h2>

                    <div class="border-t pt-2 space-y-2 text-sm">
                        @foreach ($transaction->transactionDetails as $detail)
                            <div class="flex justify-between">
                                <div>
                                    <p class="font-medium">
                                        {{ $detail->product->name ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $detail->qty }} x
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        @if($detail->product?->store)
                                            · {{ $detail->product->store->name }}
                                        @endif
                                    </p>
                                </div>
                                <p class="font-semibold">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>

                            @if(!$loop->last)
                                <hr class="border-dashed">
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- 🧾 RINGKASAN PEMBAYARAN --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Ringkasan Pembayaran</h2>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal Produk</span>
                            <span class="font-medium">
                                Rp {{ number_format($subtotalProduk, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span class="font-medium">
                                Rp {{ number_format($ongkir, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Biaya Lainnya</span>
                            <span class="font-medium">Rp 0</span>
                        </div>

                        <hr class="my-2">

                        <div class="flex justify-between text-base md:text-lg font-semibold text-orange-600">
                            <span>Total Pembayaran</span>
                            <span>
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- BAGIAN PEMBAYARAN --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                @if ($transaction->payment_status === \App\Models\Transaction::STATUS_PENDING)
                    <h2 class="text-lg font-semibold mb-3">Pembayaran</h2>

                    @php
                        $method = $transaction->payment_method;
                    @endphp

                    <div class="space-y-2 text-sm text-gray-700">

                        {{-- BCA VA --}}
                        @if ($method === 'BCA_VA')
                            <p>Metode pembayaran yang dipilih: <strong>BCA Virtual Account</strong></p>

                            <div class="mt-3 p-4 border rounded-lg bg-gray-50 inline-block">
                                <p class="text-sm">Silakan transfer ke nomor VA berikut:</p>

                                <p class="mt-2 font-mono text-lg text-orange-600">
                                    88012{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                </p>

                                <p class="text-xs text-gray-600 mt-1">
                                    a.n <strong>Sembako Mart</strong>
                                </p>
                            </div>

                        {{-- BNI VA --}}
                        @elseif ($method === 'BNI_VA')
                            <p>Metode pembayaran yang dipilih: <strong>BNI Virtual Account</strong></p>

                            <div class="mt-3 p-4 border rounded-lg bg-gray-50 inline-block">
                                <p class="text-sm">Nomor VA:</p>

                                <p class="mt-2 font-mono text-lg text-orange-600">
                                    82017{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                </p>

                                <p class="text-xs text-gray-600 mt-1">
                                    a.n <strong>Sembako Mart</strong>
                                </p>
                            </div>

                        {{-- BRI VA --}}
                        @elseif ($method === 'BRI_VA')
                            <p>Metode pembayaran yang dipilih: <strong>BRI Virtual Account</strong></p>

                            <div class="mt-3 p-4 border rounded-lg bg-gray-50 inline-block">
                                <p class="text-sm">Nomor VA:</p>

                                <p class="mt-2 font-mono text-lg text-orange-600">
                                    22551{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                </p>

                                <p class="text-xs text-gray-600 mt-1">
                                    a.n <strong>Sembako Mart</strong>
                                </p>
                            </div>

                        {{-- MANDIRI VA --}}
                        @elseif ($method === 'MANDIRI_VA')
                            <p>Metode pembayaran yang dipilih: <strong>Mandiri Virtual Account</strong></p>

                            <div class="mt-3 p-4 border rounded-lg bg-gray-50 inline-block">
                                <p class="text-sm">Nomor VA:</p>

                                <p class="mt-2 font-mono text-lg text-orange-600">
                                    89600{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                </p>

                                <p class="text-xs text-gray-600 mt-1">
                                    a.n <strong>Sembako Mart</strong>
                                </p>
                            </div>

                        {{-- QRIS --}}
                        @elseif ($method === 'QRIS')
                            <p>Metode pembayaran yang dipilih: <strong>QRIS</strong></p>

                            {{-- CARD QRIS TENGAH --}}
                            <div class="mt-4 flex justify-center">
                                <div class="p-5 border rounded-xl bg-gray-50 shadow-sm text-center" style="width: 330px;">

                                    {{-- Logo + Merchant --}}
                                    <div class="flex flex-col items-center mb-3">
                                        <img
                                            src="{{ asset('images/qris-logo.png') }}"
                                            alt="Logo QRIS"
                                            class="h-8 mb-1 object-contain"
                                        >
                                        <p class="text-xs text-gray-600">
                                            Nama Merchant:
                                            <span class="font-semibold">Sembako Mart</span>
                                        </p>
                                    </div>

                                    {{-- QR IMAGE --}}
                                    <img
                                        id="qris-image"
                                        src="{{ asset('images/qris-dummy.png') }}"
                                        alt="QRIS Dummy"
                                        class="w-56 h-56 rounded-md mx-auto mb-3"
                                    >

                                    {{-- Countdown & Download --}}
                                    <p class="text-sm mb-1">
                                        Waktu pembayaran tersisa:
                                        <span id="qris-countdown" class="font-mono text-orange-600">60:00</span>
                                    </p>

                                    <p class="text-xs text-gray-500 mb-2">
                                        Ini QRIS dummy hanya untuk simulasi, tidak memproses transaksi nyata.
                                    </p>

                                    <button
                                        type="button"
                                        id="qris-download-btn"
                                        class="px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium bg-white hover:bg-gray-100 transition"
                                    >
                                        Download QR
                                    </button>
                                </div>
                            </div>

                            {{-- Script QRIS: countdown & download --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var countdownEl = document.getElementById('qris-countdown');
                                    var remaining = 60 * 60; // 60 menit

                                    function formatTime(sec) {
                                        var m = Math.floor(sec / 60);
                                        var s = sec % 60;
                                        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                                    }

                                    function tick() {
                                        if (!countdownEl) return;
                                        countdownEl.textContent = formatTime(remaining);
                                        if (remaining > 0) {
                                            remaining--;
                                        } else {
                                            countdownEl.textContent = '00:00';
                                            countdownEl.classList.remove('text-orange-600');
                                            countdownEl.classList.add('text-red-600');
                                            clearInterval(timer);
                                        }
                                    }

                                    tick(); // set awal
                                    var timer = setInterval(tick, 1000);

                                    // Tombol download QR
                                    var downloadBtn = document.getElementById('qris-download-btn');
                                    var img = document.getElementById('qris-image');

                                    if (downloadBtn && img) {
                                        downloadBtn.addEventListener('click', function () {
                                            var link = document.createElement('a');
                                            link.href = img.src;
                                            link.download = 'qris-{{ $transaction->id }}.png';
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        });
                                    }
                                });
                            </script>

                        {{-- COD --}}
                        @elseif ($method === 'COD')
                            <p>Metode pembayaran yang dipilih: <strong>Bayar di Tempat (COD)</strong></p>

                            <div class="mt-3 p-4 border rounded-lg bg-amber-50 inline-block">
                                <p class="text-sm">
                                    Silakan siapkan uang tunai sebesar:
                                </p>
                                <p class="mt-2 font-semibold text-lg">
                                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    Bayar langsung ke kurir saat pesanan diterima.
                                </p>
                            </div>

                        {{-- DEFAULT --}}
                        @else
                            <p>Metode pembayaran: <strong>{{ $method ?? 'Belum ditentukan' }}</strong></p>
                            <p>Ikuti instruksi pembayaran yang dikirim oleh admin.</p>
                        @endif
                    </div>

                    {{-- Tidak ada lagi tombol "Saya sudah bayar" --}}
                    {{-- User hanya bisa melihat pesanan, verifikasi dilakukan admin --}}

                    <div class="mt-4">
                        <a
                            href="{{ route('transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 
                                   text-white rounded-md font-semibold text-xs uppercase tracking-widest
                                   shadow transition"
                        >
                            Lihat Pesanan
                        </a>
                    </div>
                @else
                    <div class="rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                        Pembayaran sudah diterima. Terima kasih! 🎉
                    </div>

                    <div class="mt-4">
                        <a
                            href="{{ route('transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 
                                   text-white rounded-md font-semibold text-xs uppercase tracking-widest
                                   shadow transition"
                        >
                            Lihat Pesanan
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
