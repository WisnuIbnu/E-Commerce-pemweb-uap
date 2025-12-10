{{-- resources/views/admin/store.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Daftar Pengajuan Toko</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Toko</th>
                <th>Nama Pemilik</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->owner->name }}</td>
                    <td>{{ $store->owner->email }}</td>
                    <td>
                        @if($store->is_verified)
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-warning">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        @if(!$store->is_verified)
                            <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada pengajuan toko.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
