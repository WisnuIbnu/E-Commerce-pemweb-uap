@extends('admin.layout')

@section('title', 'Kelola User')

@section('content')
<h2 class="text-3xl font-bold mb-6">👥 Kelola User</h2>

{!! $table_html !!}
{{-- atau paste seluruh tabel user kamu di sini --}}
<table class="w-full bg-white shadow rounded-lg">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Role</th>
            <th class="p-3 text-left">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->role }}</td>
                <td class="p-3">
                    <a href="#" class="text-blue-600">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
