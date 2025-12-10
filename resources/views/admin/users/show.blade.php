@extends('admin.layouts.layout')

@section('title', 'Detail User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.users.index') }}" 
                class="text-sm text-gray-400 hover:text-white inline-flex items-center mb-2 transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar User
            </a>
            <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
        </div>
        <div class="flex items-center space-x-3">
            @if($user->role == 'admin')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Admin</span>
            @elseif($user->role == 'seller')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Seller</span>
            @else
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Customer</span>
            @endif
            
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi User</h2>
                
                <div class="flex items-start space-x-4 mb-6">
                    <div class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white">{{ $user->name }}</h3>
                        <p class="text-gray-400 mt-1">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Member sejak {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="border-t border-zinc-800 my-6"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Role</label>
                        <p class="text-white">{{ ucfirst($user->role) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Email Verified</label>
                        <p>
                            @if($user->email_verified_at)
                            <span class="text-green-400 font-medium">Terverifikasi</span>
                            @else
                            <span class="text-red-400 font-medium">Belum Terverifikasi</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Terdaftar Sejak</label>
                        <p class="text-white">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Terakhir Diupdate</label>
                        <p class="text-white">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Store Information (if seller) -->
            @if($user->store)
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi Toko</h2>
                
                <div class="flex items-start space-x-4">
                    @if($user->store->logo)
                    <img src="{{ Storage::url($user->store->logo) }}" alt="{{ $user->store->name }}" 
                        class="h-16 w-16 rounded-lg object-cover border-2 border-zinc-700">
                    @else
                    <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold text-xl">
                        {{ substr($user->store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-bold text-white">{{ $user->store->name }}</h3>
                            @if($user->store->is_verified)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Verified</span>
                            @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pending</span>
                            @endif
                        </div>
                        <p class="text-gray-400 mt-1">{{ Str::limit($user->store->description, 100) }}</p>
                        <a href="{{ route('admin.stores.show', $user->store->id) }}" 
                            class="text-sm text-blue-400 hover:text-blue-300 font-medium mt-2 inline-block transition-colors">
                            Lihat Detail Toko →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Buyer Information -->
            @if($user->buyer)
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi Pembeli</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($user->buyer->address)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Alamat</label>
                        <p class="text-white">{{ $user->buyer->address }}</p>
                    </div>
                    @endif

                    @if($user->buyer->phone)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Nomor Telepon</label>
                        <p class="text-white">{{ $user->buyer->phone }}</p>
                    </div>
                    @endif

                    @if($user->buyer->city)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Kota</label>
                        <p class="text-white">{{ $user->buyer->city }}</p>
                    </div>
                    @endif

                    @if($user->buyer->postal_code)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Kode Pos</label>
                        <p class="text-white">{{ $user->buyer->postal_code }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Transaction History -->
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Riwayat Transaksi</h2>
                
                @if($user->transactions && $user->transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Invoice</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Toko</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Total</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->transactions->take(10) as $transaction)
                            <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                                <td class="py-3 px-4 font-medium text-white">{{ $transaction->invoice }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $transaction->store->name }}</td>
                                <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    @if($transaction->payment_status == 'delivered')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Selesai</span>
                                    @elseif($transaction->payment_status == 'shipped')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Dikirim</span>
                                    @elseif($transaction->payment_status == 'processing')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Diproses</span>
                                    @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">{{ ucfirst($transaction->payment_status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-400">{{ $transaction->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($user->transactions->count() > 10)
                <p class="text-sm text-gray-400 mt-4 text-center">
                    Dan {{ $user->transactions->count() - 10 }} transaksi lainnya
                </p>
                @endif
                @else
                <p class="text-gray-400 text-center py-8">Belum ada transaksi</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Statistik</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Status</span>
                        @if($user->role == 'admin')
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Admin</span>
                        @elseif($user->role == 'seller')
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Seller</span>
                        @else
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Customer</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Total Transaksi</span>
                        <span class="text-sm font-medium text-white">{{ $user->transactions ? $user->transactions->count() : 0 }}</span>
                    </div>

                    @if($user->store)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Produk Toko</span>
                        <span class="text-sm font-medium text-white">{{ $user->store->products->count() }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Member Sejak</span>
                        <span class="text-sm font-medium text-white">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Aksi</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit User
                    </a>

                    @if($user->role != 'admin')
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Data tidak dapat dikembalikan!')">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection