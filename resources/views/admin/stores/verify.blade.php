@extends('admin.layouts.admin')


@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-pink-600 mb-6">
        Verifikasi Toko
    </h1>

    <table class="w-full bg-white rounded-lg shadow border border-gray-200">
        <thead>
            <tr class="bg-blue-100 text-left">
                <th class="p-3 font-semibold">Nama Toko</th>
                <th class="p-3 font-semibold">Pemilik</th>
                <th class="p-3 font-semibold">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($stores as $store)
                <tr class="border-t">
                    <td class="p-3">{{ $store->name }}</td>
                    <td class="p-3">{{ $store->user->name }}</td>
                    <td class="p-3 space-x-2">

                        <form action="{{ route('admin.stores.approve', $store->id) }}" 
                              method="POST" class="inline-block">
                            @csrf
                            <button class="px-3 py-1 bg-green-400 hover:bg-green-500 rounded text-white">
                                Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.stores.reject', $store->id) }}" 
                              method="POST" class="inline-block">
                            @csrf
                            <button class="px-3 py-1 bg-red-400 hover:bg-red-500 rounded text-white">
                                Reject
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-600">
                        Tidak ada toko yang menunggu verifikasi.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>
@endsection
