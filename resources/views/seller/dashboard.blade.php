<x-seller-layout>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Toko Berhasil Dibuat',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#f97316',
                });
            });
        </script>
    @endif

    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Dashboard Toko</h1>

        {{-- 1. BELUM PUNYA TOKO --}}
        @if (!$store)
            <div class="rounded-xl bg-orange-50 border border-orange-200 px-4 py-4">
                <p class="text-orange-800 font-medium">
                    Anda belum memiliki toko.
                </p>
                <p class="text-orange-700 text-sm mt-1">
                    Silakan lakukan pendaftaran toko terlebih dahulu.
                </p>
                <a href="{{ route('seller.form') }}"
                   class="inline-flex mt-3 px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-medium hover:bg-orange-600">
                    Daftarkan Toko Sekarang
                </a>
            </div>

        {{-- 2. STATUS PENDING --}}
        @elseif ($store->status === 'pending')
            <div class="rounded-xl bg-yellow-50 border border-yellow-200 px-4 py-4 mb-6">
                <p class="font-semibold text-yellow-800">
                    Toko Anda sedang menunggu verifikasi admin.
                </p>
                <p class="text-yellow-700 text-sm mt-1">
                    Admin akan memeriksa data toko Anda. Setelah disetujui, fitur penuh Seller akan aktif.
                </p>
            </div>

            {{-- Info singkat toko --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-lg mb-4">Informasi Toko</h2>
                <p><span class="font-medium">Nama Toko:</span> {{ $store->name }}</p>
                <p><span class="font-medium">Kota:</span> {{ $store->city }}</p>
                <p><span class="font-medium">Alamat:</span> {{ $store->address }}</p>
                <p><span class="font-medium">Status:</span>
                    <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800">
                        Pending Verifikasi
                    </span>
                </p>
            </div>

        {{-- 3. STATUS REJECTED --}}
        @elseif ($store->status === 'rejected')
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-4 mb-6">
                <p class="font-semibold text-red-800">
                    Toko Anda ditolak oleh admin.
                </p>
                <p class="text-red-700 text-sm mt-1">
                    Silakan periksa kembali data toko Anda atau hubungi admin untuk informasi lebih lanjut.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-lg mb-4">Informasi Toko</h2>
                <p><span class="font-medium">Nama Toko:</span> {{ $store->name }}</p>
                <p><span class="font-medium">Kota:</span> {{ $store->city }}</p>
                <p><span class="font-medium">Alamat:</span> {{ $store->address }}</p>
                <p><span class="font-medium">Status:</span>
                    <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800">
                        Ditolak
                    </span>
                </p>
            </div>

        {{-- 4. STATUS APPROVED / VERIFIED --}}
        @else
            {{-- Alert verifikasi --}}
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-4 mb-6">
                <p class="font-semibold text-emerald-800">
                    Toko Anda sudah diverifikasi 🎉
                </p>
                <p class="text-emerald-700 text-sm mt-1">
                    Anda sekarang dapat mengelola produk, menerima pesanan, dan menarik saldo.
                </p>
            </div>

            {{-- Kartu statistik: 3 kolom --}}
            <div class="grid md:grid-cols-3 gap-4 mb-6">
                {{-- Kartu Produk Aktif --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Produk Aktif</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">
                        {{ $productCount }}
                    </p>
                </div>

                {{-- Kartu Pesanan Hari Ini --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Pesanan Hari Ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">
                        {{ $todayOrders }}
                    </p>
                </div>

                {{-- Kartu Saldo Toko --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Saldo Toko</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">
                        Rp {{ number_format($saldoToko, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-[11px] text-gray-500">
                        Saldo yang dapat ditarik.
                    </p>
                </div>
            </div>

            {{-- Info Toko --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-lg mb-4">Informasi Toko</h2>
                <p><span class="font-medium">Nama Toko:</span> {{ $store->name }}</p>
                <p><span class="font-medium">Kota:</span> {{ $store->city }}</p>
                <p><span class="font-medium">Alamat:</span> {{ $store->address }}</p>
                <p><span class="font-medium">Status:</span>
                    <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-800">
                        Terverifikasi
                    </span>
                </p>
            </div>
        @endif
    </div>
</x-seller-layout>
