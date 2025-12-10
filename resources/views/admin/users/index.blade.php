@extends('admin.layouts.main')

@section('content')
<h2 class="mb-3">Manajemen User</h2>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
                @if($user->role == 'admin')
                    <span class="badge bg-primary">Admin</span>
                @elseif($user->role == 'seller')
                    <span class="badge bg-success">Seller</span>
                @else
                    <span class="badge bg-secondary">Member</span>
                @endif
            </td>

            <td>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">Detail</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
