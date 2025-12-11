<x-seller-layout>
    @php
    $availableBalance = $availableBalance ?? 0; // fallback biar aman
    @endphp

    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#f97316',
            });
        });
    </script>
    @endif

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
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Penarikan Saldo</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Ajukan penarikan dan lihat riwayat withdrawal untuk toko
                    <span class="font-semibold">{{ $store->name ?? '' }}</span>.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">

                {{-- KARTU SALDO + FORM --}}
                <div class="space-y-4">

                    {{-- Saldo --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <p class="text-sm text-gray-500">Saldo Tersedia</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            Rp {{ number_format($availableBalance, 0, ',', '.') }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            Minimal penarikan Rp 50.000.
                        </p>
                    </div>

                    {{-- Form Withdrawal --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3">Ajukan Penarikan</h2>

                        <form action="{{ route('seller.withdrawals.store') }}" method="POST" class="space-y-3">
                            @csrf

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    Nominal Penarikan
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">Rp</span>
                                    <input type="number" name="amount" min="10000" step="1000"
                                        value="{{ old('amount') }}"
                                        class="w-full pl-8 pr-3 py-2 rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                        placeholder="Misal: 100000">
                                </div>
                                @error('amount')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    Catatan (opsional)
                                </label>
                                <textarea name="note" rows="2"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                    placeholder="Misal: tarik untuk kebutuhan operasional">{{ old('note') }}</textarea>
                                @error('note')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Info Bank (read only dari profil toko) --}}
                            <div class="bg-gray-50 rounded-lg px-4 py-3 text-xs text-gray-600 space-y-1">
                                <p class="font-semibold text-gray-700">Rekening Tujuan</p>
                                <p>Bank: <span class="font-medium">{{ $store->bank_name ?? '-' }}</span></p>
                                <p>No. Rekening: <span class="font-mono">{{ $store->bank_account_number ?? '-' }}</span></p>
                                <p>Atas Nama: <span class="font-medium">{{ $store->bank_account_name ?? '-' }}</span></p>
                                <p class="text-[11px] text-gray-400 mt-1">
                                    Ubah data bank di halaman <span class="font-medium">Pengaturan Toko</span>.
                                </p>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm rounded-lg font-semibold
                                  bg-orange-500 text-white hover:bg-orange-600
                                    disabled:opacity-50 disabled:cursor-not-allowed"
                                    @if($availableBalance < 50000) disabled @endif>
                                    Ajukan Penarikan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- RIWAYAT PENARIKAN --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Riwayat Penarikan</h2>

                    @if($withdrawals->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada riwayat penarikan.</p>
                    @else
                    <div class="overflow-x-auto text-sm">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-xs text-gray-500 border-b">
                                    <th class="py-2 pr-2 text-left">Tanggal</th>
                                    <th class="py-2 px-2 text-right">Nominal</th>
                                    <th class="py-2 px-2 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($withdrawals as $wd)
                                @php
                                $status = $wd->status;
                                $badgeClass = match ($status) {
                                'pending' => 'bg-yellow-50 text-yellow-700',
                                'approved' => 'bg-blue-50 text-blue-700',
                                'rejected' => 'bg-red-50 text-red-700',
                                'paid' => 'bg-green-50 text-green-700',
                                default => 'bg-gray-100 text-gray-600',
                                };
                                @endphp
                                <tr>
                                    <td class="py-2 pr-2 align-top">
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ $wd->created_at->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $wd->created_at->format('H:i') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-2 px-2 text-right align-top">
                                        Rp {{ number_format($wd->amount ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-2 text-center align-top">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $badgeClass }}">
                                            {{ ucfirst($status ?? '-') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $withdrawals->links() }}
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-seller-layout>