<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.app')
@section('title', 'User Management - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">User Management</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-primary">{{ $user->role }}</span></td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        @if($user->role !== 'admin')
                        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection