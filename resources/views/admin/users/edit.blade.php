@extends('admin.layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit User</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-semibold mb-1">Nama</label>
        <input type="text" name="name" value="{{ $user->name }}"
               class="w-full border-2 border-blue-300 p-2 rounded-lg">
    </div>

    <div>
        <label class="block font-semibold mb-1">Email</label>
        <input type="email" name="email" value="{{ $user->email }}"
               class="w-full border-2 border-blue-300 p-2 rounded-lg">
    </div>

    <div>
        <label class="block font-semibold mb-1">Role</label>
        <select name="role" class="w-full border-2 border-blue-300 p-2 rounded-lg">
            <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member</option>
            <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div class="flex space-x-3 mt-4">
        <button class="btn btn-approve">Save</button>

        <a href="{{ route('admin.users.index') }}" class="btn btn-reject">
            Kembali
        </a>
    </div>
</form>
@endsection
