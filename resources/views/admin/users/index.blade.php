@extends('admin.layout')

@section('title', 'User Management')

@section('content')

@if (session('success'))
    <div class="mb-4 rounded-lg border border-blue-500 bg-blue-500 bg-opacity-20 px-4 py-3 text-sm text-blue-100 shadow">
        {{ session('success') }}
    </div>
@endif

{{-- USER LIST --}}
<div class="mb-10 relative overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 shadow-2xl">
    <div class="absolute inset-0 opacity-30 bg-gradient-to-br from-blue-600 via-transparent to-blue-900"></div>

    <div class="relative p-4 sm:p-6 border-b border-gray-700">
        <h3 class="text-xl font-semibold text-gray-100">All Users</h3>
        <p class="mt-1 text-xs sm:text-sm text-gray-400">
            Kelola akun pengguna yang terdaftar di ElecTrend.
        </p>
    </div>

    <div class="relative overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-200">
            <thead class="bg-gray-900 border-b border-gray-700 text-xs uppercase tracking-wide text-gray-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                        <td class="px-4 py-3 text-gray-100">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-200">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ ucfirst($user->role) }}</td>

                        <td class="px-4 py-3 text-center">
                            @if($user->role !== 'admin')
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="inline-flex items-center justify-center rounded-full bg-red-500 px-4 py-1 text-xs font-medium text-white shadow hover:bg-red-400 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center justify-center rounded-full bg-blue-500 px-3 py-1 text-[11px] font-semibold text-white uppercase tracking-wide">
                                    Super Admin
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- STORE LIST --}}
<div class="relative overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 shadow-2xl">
    <div class="absolute inset-0 opacity-25 bg-gradient-to-br from-blue-500 via-transparent to-blue-800"></div>

    <div class="relative p-4 sm:p-6 border-b border-gray-700">
        <h3 class="text-xl font-semibold text-gray-100">Stores</h3>
        <p class="mt-1 text-xs sm:text-sm text-gray-400">
            Lihat status verifikasi toko yang terhubung dengan pengguna.
        </p>
    </div>

    <div class="relative overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-200">
            <thead class="bg-gray-900 border-b border-gray-700 text-xs uppercase tracking-wide text-gray-400">
                <tr>
                    <th class="px-4 py-3">Store</th>
                    <th class="px-4 py-3">Owner</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($stores as $store)
                    <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                        <td class="px-4 py-3 text-gray-100">{{ $store->name }}</td>
                        <td class="px-4 py-3 text-gray-200">{{ $store->user->name }}</td>
                        <td class="px-4 py-3">
                            @if ($store->is_verified)
                                <span class="inline-flex items-center rounded-full bg-green-500 px-3 py-1 text-xs font-medium text-white">
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-yellow-400 px-3 py-1 text-xs font-medium text-gray-900">
                                    Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
