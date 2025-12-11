@extends('admin.layout')

@section('content')

<h2 style="font-size:22px; font-weight:600; margin-bottom:20px;">
    Edit User Role
</h2>

<div style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

<form action="{{ route('admin.users.update',$user->id) }}" method="POST">
    @csrf @method('PUT')

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <label style="margin-top:20px; display:block;">Role</label>
    <select name="role"
        style="width:100%; padding:12px; margin:10px 0;
               border-radius:6px; border:1px solid #ccc;">
        <option value="buyer" @selected($user->role=='buyer')>Buyer</option>
        <option value="seller" @selected($user->role=='seller')>Seller</option>
        <option value="admin" @selected($user->role=='admin')>Admin</option>
    </select>

    {{-- ⛔ ERROR DITAMPILKAN DI SINI --}}
    @error('role')
        <div style="color:red; font-size:13px; margin-bottom:10px;">
            {{ $message }}
        </div>
    @enderror

    <button style="
        padding:10px 18px;
        background:#ff7a00;
        color:white;
        border:none;
        border-radius:6px;
        cursor:pointer;
        margin-top:10px;
    ">
        Update Role
    </button>
</form>

{{-- Jika user memiliki toko --}}
@if($user->store)
<br><hr><br>

<h3 style="font-size:18px; font-weight:600; margin-bottom:10px;">Informasi Toko</h3>

<p><strong>Nama Toko:</strong> {{ $user->store->name }}</p>
<p><strong>Status:</strong> {{ $user->store->status }}</p>

<a href="{{ route('admin.stores.edit', $user->store->id) }}"
   style="display:inline-block; margin-top:10px;
          padding:10px 15px; background:#ff7a00;
          color:white; border-radius:6px; text-decoration:none;">
   Kelola Toko
</a>
@endif

</div>

@endsection
