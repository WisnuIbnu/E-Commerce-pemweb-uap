@extends('layouts.admin')

@section('title', 'Daftar Store')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Daftar Store</h3>
        <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">+ Tambah Store</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Toko</th>
                <th>Pemilik</th>
                <th>Status Verifikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stores as $store)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->user->name }}</td>
                    <td>
                        @if ($store->is_verified == 0)
                            <span class="badge bg-secondary">Pending</span>
                        @elseif($store->is_verified == 1)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Unknown</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.stores.show', $store->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.stores.approve', $store->id) }}" class="btn btn-success btn-sm">Setujui</a>


                        <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus store ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada store</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $stores->links() }}
@endsection
