@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Penarikan Saldo</h1>
            <p class="text-tumbloo-gray">Request penarikan dan kelola informasi bank Anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success fade-in">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error fade-in">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Balance Info -->
            <div class="card p-6">
                <p class="text-sm text-tumbloo-gray mb-2">Saldo Tersedia</p>
                <p class="text-3xl font-bold text-tumbloo-black mb-4">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </p>
                <p class="text-xs text-tumbloo-gray">Minimum penarikan: Rp 50.000</p>
            </div>

            <!-- Withdrawal Form -->
            <div class="lg:col-span-2 card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-6">Request Penarikan</h2>

                <form action="{{ route('store.withdrawal.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="label">Nama Bank</label>
                            <input type="text" name="bank_name" 
                                class="input-field @error('bank_name') border-red-500 @enderror" 
                                placeholder="contoh: Bank BCA"
                                value="{{ old('bank_name', session('bank_account.bank')) }}" required>
                            @error('bank_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_account_name" 
                                class="input-field @error('bank_account_name') border-red-500 @enderror" 
                                placeholder="Nama sesuai rekening"
                                value="{{ old('bank_account_name', session('bank_account.name')) }}" required>
                            @error('bank_account_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" 
                                class="input-field @error('bank_account_number') border-red-500 @enderror" 
                                placeholder="1234567890"
                                value="{{ old('bank_account_number', session('bank_account.number')) }}" required>
                            @error('bank_account_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Jumlah Penarikan</label>
                            <input type="number" name="amount" 
                                class="input-field @error('amount') border-red-500 @enderror" 
                                placeholder="50000" min="50000" step="1000"
                                value="{{ old('amount') }}" required>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Request Penarikan
                    </button>
                </form>
            </div>
        </div>

        <!-- Withdrawal History -->
        <div class="card p-6">
            <h2 class="text-xl font-bold text-tumbloo-black mb-6">Riwayat Penarikan</h2>

            @if($withdrawals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Bank</th>
                                <th>No. Rekening</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td class="font-semibold">#WD{{ $withdrawal->id }}</td>
                                <td>
                                    <div>
                                        <p class="font-semibold">{{ $withdrawal->bank_name }}</p>
                                        <p class="text-xs text-tumbloo-gray">{{ $withdrawal->bank_account_name }}</p>
                                    </div>
                                </td>
                                <td class="font-mono">{{ $withdrawal->bank_account_number }}</td>
                                <td class="font-semibold">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($withdrawal->status == 'completed') badge-success
                                        @elseif($withdrawal->status == 'pending') badge-warning
                                        @elseif($withdrawal->status == 'rejected') badge-danger
                                        @else badge-info
                                        @endif">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td>{{ $withdrawal->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $withdrawals->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-tumbloo-gray">Belum ada riwayat penarikan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection