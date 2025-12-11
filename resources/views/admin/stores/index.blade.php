@extends('admin.layout')

@section('title', 'Store Verification')

@section('content')

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-blue-500 bg-blue-500 bg-opacity-20 px-4 py-3 text-sm text-blue-100 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 shadow-2xl">
        <div class="absolute inset-0 opacity-30 bg-gradient-to-br from-blue-600 via-transparent to-blue-900"></div>

        <div class="relative p-4 sm:p-6 border-b border-gray-700 flex items-center justify-between">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-100">
                    Store Verification
                </h2>
                <p class="mt-1 text-xs sm:text-sm text-gray-400">
                    Tinjau dan verifikasi pengajuan toko untuk menjaga kualitas ekosistem ElecTrend.
                </p>
            </div>
        </div>

        <div class="relative overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-200">
                <thead class="bg-gray-900 border-b border-gray-700 text-xs uppercase tracking-wide text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Store Name</th>
                        <th class="px-4 py-3">Owner</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($stores as $store)
                        <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-3 text-gray-100">
                                {{ $store->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-200">
                                {{ $store->user->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-300">
                                {{ $store->phone }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    {{-- Verify: biru --}}
                                    <form method="POST" action="{{ route('admin.stores.verify', $store->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            class="inline-flex items-center gap-1 rounded-full bg-blue-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-blue-400 transition-colors">
                                            ✔ Verify
                                        </button>
                                    </form>

                                    {{-- Reject: merah --}}
                                    <form method="POST" action="{{ route('admin.stores.reject', $store->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            class="inline-flex items-center gap-1 rounded-full bg-red-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-red-400 transition-colors">
                                            ✖ Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($stores->isEmpty())
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400 text-sm">
                                Belum ada pengajuan toko yang perlu diverifikasi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
