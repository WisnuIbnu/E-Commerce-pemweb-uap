@extends('layouts.admin')

@section('title', 'Verifikasi Toko')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    {{-- HEADER ATAS --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <i class="fa-solid fa-bag-shopping text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">X</h1>
            <p class="text-indigo-100 text-sm">
                Panel kontrol untuk meninjau dan memverifikasi pengajuan toko baru.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                    {{-- HEADER CARD --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Verifikasi Toko</h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Lihat dan proses pengajuan toko yang masih menunggu persetujuan admin.
                            </p>
                        </div>

                        {{-- Info jumlah pending (UI saja) --}}
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600">
                            <i class="fa-solid fa-clock text-slate-400"></i>
                            <span>{{ $stores->count() }} toko menunggu verifikasi</span>
                        </div>
                    </div>

                    {{-- TABEL VERIFIKASI TOKO --}}
                    <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-50">
                                <tr class="border-b border-slate-200">
                                    <th class="py-3 px-4 font-semibold text-slate-600">Nama Toko</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600">Pemilik</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600">Tanggal Daftar</th>
                                    <th class="py-3 px-4 font-semibold text-slate-600 text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($stores as $store)
                                    <tr class="border-b last:border-0 border-slate-100 hover:bg-slate-50/60 transition">
                                        {{-- Nama toko --}}
                                        <td class="py-3 px-4 align-middle">
                                            <div class="font-semibold text-slate-800">{{ $store->name }}</div>
                                            @if($store->city ?? false)
                                                <div class="text-xs text-slate-500 mt-0.5">
                                                    {{ $store->city }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Pemilik --}}
                                        <td class="py-3 px-4 align-middle text-slate-700">
                                            {{ $store->owner->name ?? '-' }}
                                        </td>

                                        {{-- Tanggal daftar --}}
                                        <td class="py-3 px-4 align-middle text-slate-600">
                                            {{ $store->created_at->format('d M Y') }}
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 px-4 align-middle text-right">
                                            <div class="flex items-center justify-end gap-2">

                                                {{-- Approve --}}
                                                <form action="{{ route('admin.store.verify', $store->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600
                                                                   text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm">
                                                        <i class="fa-solid fa-check text-[11px]"></i>
                                                        Approve
                                                    </button>
                                                </form>

                                                {{-- Reject --}}
                                                <form action="{{ route('admin.store.reject', $store->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 bg-rose-500 hover:bg-rose-600
                                                                   text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm">
                                                        <i class="fa-solid fa-xmark text-[11px]"></i>
                                                        Reject
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-gray-500 text-center py-6 text-sm">
                                            Tidak ada pengajuan toko baru.
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
