@extends('layouts.admin')

@section('title', 'Kelola Users - Admin FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-users.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="container">
        <div class="page-header">
            <h1>👥 Kelola Users</h1>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td><strong>{{ $user['name'] }}</strong></td>
                        <td>{{ $user['email'] }}</td>
                        <td><span class="badge badge-{{ $user['role'] }}">{{ strtoupper($user['role']) }}</span></td>
                        <td>{{ date('d M Y', strtotime($user['created_at'])) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection