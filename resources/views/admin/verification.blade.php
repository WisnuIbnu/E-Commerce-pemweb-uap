{{-- resources/views/admin/verification.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Verifikasi Seller</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Email</th>
                <th>Status Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($requests as $req)
                <tr>
                    <td>{{ $req->user->name }}</td>
                    <td>{{ $req->user->email }}</td>
                    <td>
                        @if(!$req->is_verified)
                            <span class="badge bg-warning">Menunggu</span>
                        @else
                            <span class="badge bg-success">Disetujui</span>
                        @endif
                    </td>
                    <td>
                        @if(!$req->is_verified)
                            <form action="{{ route('admin.stores.approve', $req->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('admin.stores.reject', $req->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">Sudah diverifikasi</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pengajuan verifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
