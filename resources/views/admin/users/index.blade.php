@extends('admin.layouts.layout')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-white">Kelola User</h1>
        <p class="text-gray-400 mt-1">Kelola semua pengguna yang terdaftar di platform</p>
    </div>

    <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau email..." 
                    class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <select name="role" class="px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-blue-500">
                    <option value="">Semua Role</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}" class="px-8 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-zinc-900 rounded-xl p-4 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total User</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $users->total() }}</p>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($users->count() > 0)
    <div class="bg-zinc-900 rounded-xl border border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-zinc-800">
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">User</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Email</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Role</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Terdaftar</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-tumbloo-gray flex items-center justify-center text-white font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-white">{{ $user->name }}</p>
                                    @if($user->store)
                                    <p class="text-sm text-gray-400">Toko: {{ $user->store->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-300">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if($user->role == 'admin')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Admin</span>
                            @elseif($user->role == 'seller')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Seller</span>
                            @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Customer</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                    class="text-gray-400 hover:text-white transition-colors" title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                @if($user->role != 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Data tidak dapat dikembalikan!')" 
                                        title="Hapus">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @else
    <div class="bg-zinc-900 rounded-xl p-12 text-center border border-zinc-800">
        <div class="flex justify-center mb-4">
            <div class="bg-zinc-800 p-6 rounded-full">
                <svg class="h-16 w-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Tidak Ada User Ditemukan</h3>
        <p class="text-gray-400">
            @if(request('search') || request('role'))
            Coba ubah filter pencarian Anda
            @else
            Belum ada user yang terdaftar
            @endif
        </p>
    </div>
    @endif
</div>
@endsection