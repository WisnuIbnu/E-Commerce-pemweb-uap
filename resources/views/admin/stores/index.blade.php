@extends('admin.layouts.main')

@section('content')
<h2 class="mb-3">Store Verification</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Store</th>
            <th>Pemilik</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($stores as $store)
        <tr>
            <td>{{ $store->name }}</td>
            <td>{{ $store->user->name }}</td>
            <td>{{ $store->description }}</td>
            <td>
                @if($store->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($store->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </td>
            <td>
                @if($store->status == 'pending')
                    <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>

                    <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                @else
                    <em>Tindakan selesai</em>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
