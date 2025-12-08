@extends('layouts.admin')

@section('title', 'Manage Users - FlexSport Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="container">
        <div class="page-header">
            <h1>MANAGE USERS</h1>
            <p>Access control for all registered accounts.</p>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge badge-admin">ADMIN</span>
                            @elseif($user->role == 'member')
                                <span class="badge badge-member">MEMBER</span>
                            @else
                                <span class="badge">{{ strtoupper($user->role) }}</span>
                            @endif
                        </td>
                        <td>{{ date('d M Y', strtotime($user->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection