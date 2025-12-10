<!-- resources/views/admin/stores/verification.blade.php -->
@extends('layouts.app')
@section('title', 'Store Verification - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Store Verification</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingStores as $store)
                <tr>
                    <td><strong>{{ $store->name }}</strong></td>
                    <td>{{ $store->user->name }}</td>
                    <td>{{ $store->phone }}</td>
                    <td>{{ $store->city }}</td>
                    <td>{{ $store->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ url('/admin/stores/' . $store->id . '/verify') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Verify</button>
                        </form>
                        <form action="{{ url('/admin/stores/' . $store->id . '/reject') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this store?')">Reject</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No pending stores</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $pendingStores->links() }}
    </div>
</div>
@endsection
