@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Withdrawals</h1>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Saldo Tersedia untuk Penarikan -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-medium text-gray-900">Saldo Tersedia</h3>
        @if($store->balance)
            <p class="text-xl font-semibold text-gray-800">Rp {{ number_format($store->balance->balance ?? 0, 0, ',', '.') }}</p>
        @else
            <p class="text-sm text-gray-500">Balance not initialized yet.</p>
        @endif
    </div>

    <!-- Form Penarikan Dana -->
    <form method="POST" action="{{ route('seller.withdrawals.store') }}">
        @csrf
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Penarikan (Min: Rp 10.000)</label>
            <input type="number" name="amount" class="mt-1 w-full border rounded-md px-3 py-2" min="10000" max="{{ $store->balance ? $store->balance->balance : 0 }}" placeholder="Contoh: 50000" required>
            <p class="text-xs text-gray-500 mt-1">Masukkan nominal tanpa titik atau koma.</p>
        </div>

        <div class="mb-4">
            <label for="bank" class="block text-sm font-medium text-gray-700">Pilih Bank</label>
            <select name="bank" class="mt-1 w-full border rounded-md px-3 py-2" required>
                <option value="" disabled selected>Pilih Bank Tujuan</option>
                <option value="BCA">BCA</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
                <option value="CIMB Niaga">CIMB Niaga</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="account_number" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
            <input type="text" name="account_number" class="mt-1 w-full border rounded-md px-3 py-2" placeholder="Contoh: 1234567890" required>
        </div>

        <div class="mb-4">
            <label for="account_name" class="block text-sm font-medium text-gray-700">Nama Rekening</label>
            <input type="text" name="account_name" class="mt-1 w-full border rounded-md px-3 py-2" placeholder="Contoh: John Doe" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" {{ !$store->balance ? 'disabled' : '' }}>
            Ajukan Penarikan
        </button>
    </form>

    <!-- Riwayat Penarikan Dana -->
    <h2 class="text-xl font-semibold mb-4 mt-8">Riwayat Penarikan Dana</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Bank & Rekening</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-4 py-2">{{ $withdrawal->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $withdrawal->bank_name }} - {{ $withdrawal->bank_account_number }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat penarikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
