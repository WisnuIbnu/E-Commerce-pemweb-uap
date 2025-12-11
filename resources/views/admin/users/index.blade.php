@extends('admin.layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">User Management</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th width="220px">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>

            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">Edit</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST" class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-delete">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@endsection
