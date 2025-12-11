@extends('layouts.admin')

@section('title', 'Manajemen User & Toko')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    {{-- HEADER ATAS --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <i class="fa-solid fa-bag-shopping text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2"></h1>
            <p class="text-indigo-100 text-sm">
                
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                    {{-- HEADER CARD + SEARCH --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Manajemen User & Toko</h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Lihat dan kelola role user serta toko yang mereka miliki.
                            </p>
                        </div>

                        {{-- Search UI (belum ada logic, hanya tampilan) --}}
                        <div class="w-full md:w-72">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                                </span>
                                <input type="text"
                                       placeholder="Cari nama atau email..."
                                       class="w-full pl-9 pr-3 h-10 rounded-full border border-slate-200 text-sm
                                              focus:ring-primary focus:border-primary placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>

                    {{-- TABEL USER --}}
                    <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-50">
                                <tr class="border-b border-slate-200">
                                    <th class="py-3 px-4 font-semibold text-slate-600">Nama Pengguna</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600">Email</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600">Role</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600">Toko</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600 text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="border-b last:border-0 border-slate-100 hover:bg-slate-50/60 transition">
                                        {{-- Nama --}}
                                        <td class="py-3 px-4 align-middle">
                                            <div class="font-medium text-slate-800">{{ $user->name }}</div>
                                        </td>

                                        {{-- Email --}}
                                        <td class="py-3 px-4 align-middle text-slate-600">
                                            {{ $user->email }}
                                        </td>

                                        {{-- Role (badge dengan warna beda) --}}
                                        <td class="py-3 px-4 align-middle">
                                            @php
                                                $role = $user->role;
                                                $roleConfig = [
                                                    'admin'  => ['bg' => 'bg-rose-50',   'text' => 'text-rose-700',   'label' => 'Admin'],
                                                    'seller' => ['bg' => 'bg-emerald-50','text' => 'text-emerald-700','label' => 'Seller'],
                                                    'member' => ['bg' => 'bg-blue-50',  'text' => 'text-blue-700',   'label' => 'Member'],
                                                ];

                                                $cfg = $roleConfig[$role] ?? ['bg' => 'bg-slate-100','text' => 'text-slate-700','label' => ucfirst($role)];
                                            @endphp

                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                                                {{ $cfg['label'] }}
                                            </span>
                                        </td>

                                        {{-- Toko --}}
                                        <td class="py-3 px-4 align-middle text-slate-700">
                                            {{ $user->store->name ?? '-' }}
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 px-4 align-middle text-right">
                                            <a href="{{ route('admin.user.edit', $user->id) }}"
                                               class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600
                                                      text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm">
                                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-gray-500 text-center py-6 text-sm">
                                            Tidak ada data pengguna.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
