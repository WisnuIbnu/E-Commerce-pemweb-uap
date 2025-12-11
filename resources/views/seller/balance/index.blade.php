@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Store Balance</h1>

    <!-- Saldo Toko Saat Ini -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-medium text-gray-900">Saldo Toko Saat Ini</h3>
        @if($store->balance)
            <p class="text-xl font-semibold text-gray-800">Rp {{ number_format($store->balance->balance ?? 0, 0, ',', '.') }}</p>
        @else
            <p class="text-sm text-gray-500">Balance not initialized yet.</p>
        @endif
    </div>

    <!-- Riwayat Saldo -->
    <h2 class="text-xl font-semibold mb-4">Riwayat Saldo</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Nominal</th>
                    <th class="px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($history as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded {{ $item->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($item->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $item->remarks }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
