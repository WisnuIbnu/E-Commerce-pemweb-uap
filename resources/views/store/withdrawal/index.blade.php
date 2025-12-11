@extends('layouts.app')
@section('content')
<div class="bg-tumbloo-dark min-h-screen">
    <div class="container-custom">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Penarikan Saldo</h1>
            <p class="text-gray-400">Request penarikan dan kelola informasi bank Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg p-4 mb-6">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg p-4 mb-6">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <p class="text-sm text-gray-400 mb-2">Saldo Tersedia</p>
                <p class="text-3xl font-bold text-white mb-4">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500">Minimum penarikan: Rp 50.000</p>
            </div>

            <div class="lg:col-span-2 bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-6">Request Penarikan</h2>
                <form action="{{ route('store.withdrawal.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-sm font-medium text-gray-300 block mb-2">Nama Bank</label>
                            <input type="text" name="bank_name" 
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('bank_name') border-red-500 @enderror" 
                                placeholder="contoh: Bank BCA"
                                value="{{ old('bank_name', session('bank_account.bank')) }}" required>
                            @error('bank_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-300 block mb-2">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_account_name" 
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('bank_account_name') border-red-500 @enderror" 
                                placeholder="Nama sesuai rekening"
                                value="{{ old('bank_account_name', session('bank_account.name')) }}" required>
                            @error('bank_account_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-300 block mb-2">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" 
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('bank_account_number') border-red-500 @enderror" 
                                placeholder="1234567890"
                                value="{{ old('bank_account_number', session('bank_account.number')) }}" required>
                            @error('bank_account_number')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-300 block mb-2">Jumlah Penarikan</label>
                            <input type="number" name="amount" 
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('amount') border-red-500 @enderror" 
                                placeholder="50000" min="50000" step="1000"
                                value="{{ old('amount') }}" required>
                            @error('amount')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <button type="submit" class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Request Penarikan
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <h2 class="text-xl font-bold text-white mb-6">Riwayat Penarikan</h2>
            @if($withdrawals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">ID</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Bank</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">No. Rekening</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Jumlah</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Status</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals as $withdrawal)
                            <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                                <td class="py-4 px-4 font-semibold text-white">#WD{{ $withdrawal->id }}</td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="font-semibold text-white">{{ $withdrawal->bank_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $withdrawal->bank_account_name }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-gray-300">{{ $withdrawal->bank_account_number }}</td>
                                <td class="py-4 px-4 font-semibold text-white">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($withdrawal->status == 'completed') bg-green-500/10 text-green-400 border border-green-500/20
                                        @elseif($withdrawal->status == 'pending') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                                        @elseif($withdrawal->status == 'rejected') bg-red-500/10 text-red-400 border border-red-500/20
                                        @else bg-blue-500/10 text-blue-400 border border-blue-500/20
                                        @endif">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-400">{{ $withdrawal->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $withdrawals->links() }}</div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-400">Belum ada riwayat penarikan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection