@extends('admin.layouts.layout')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-tumbloo-black">Kelola User</h1>
        <p class="text-tumbloo-gray mt-1">Kelola semua pengguna yang terdaftar di platform</p>
    </div>

    <!-- Filters -->
    <div class="card p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau email..." class="input-field">
            </div>
            <div>
                <select name="role" class="select-field">
                    <option value="">Semua Role</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-sm px-8">
                <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-sm px-8">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total User</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $users->total() }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List -->
    @if($users->count() > 0)
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-tumbloo-black">{{ $user->name }}</p>
                                    @if($user->store)
                                    <p class="text-sm text-tumbloo-gray">Toko: {{ $user->store->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-tumbloo-gray">{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                            <span class="badge badge-danger">Admin</span>
                            @elseif($user->role == 'seller')
                            <span class="badge badge-info">Seller</span>
                            @else
                            <span class="badge badge-success">Customer</span>
                            @endif
                        </td>
                        <td class="text-sm text-tumbloo-gray">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                    class="text-tumbloo-black hover:text-tumbloo-dark" title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                @if($user->role != 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" 
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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="card p-12 text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-tumbloo-offwhite p-6 rounded-full">
                <svg class="h-16 w-16 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-tumbloo-black mb-2">Tidak Ada User Ditemukan</h3>
        <p class="text-tumbloo-gray">
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