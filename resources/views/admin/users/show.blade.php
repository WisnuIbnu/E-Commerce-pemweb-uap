@extends('admin.layouts.main')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-sweet-700">Detail User</h2>

<div class="bg-white p-6 rounded-lg shadow-soft-lg border-l-4 border-sweet-400">

    <p class="mb-2">
        <strong>Nama:</strong> {{ $user->name }}
    </p>

    <p class="mb-2">
        <strong>Email:</strong> {{ $user->email }}
    </p>

    <p class="mb-2">
        <strong>Role:</strong> {{ $user->role }}
    </p>

</div>

<a href="{{ route('admin.users.index') }}"
   class="inline-block mt-4 px-4 py-2 bg-sweet-500 hover:bg-sweet-600 text-white rounded">
   Kembali
</a>

@endsection
