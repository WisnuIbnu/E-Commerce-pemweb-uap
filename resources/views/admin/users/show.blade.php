@extends('admin.layouts.main')

@section('content')
<h2>Detail User</h2>

<div class="card p-4 shadow-sm">

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role }}</p>

</div>

<a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
