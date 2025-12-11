<!-- resources/views/admin/stores/index.blade.php -->
@extends('layouts.app')
@section('title', 'Store Management - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Store Management</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Store Name</th>
                        <th>Owner</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                    <tr>
                        <td>
                            @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                            <div style="width: 50px; height: 50px; background: var(--secondary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-store" style="color: var(--primary-color);"></i>
                            </div>
                            @endif
                        </td>
                        <td><strong>{{ $store->name }}</strong></td>
                        <td>{{ $store->user->name }}</td>
                        <td><span class="badge bg-info">{{ $store->products_count }}</span></td>
                        <td>
                            @if($store->is_verified)
                            <span class="badge bg-success">Verified</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ url('/admin/stores/' . $store->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete store?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No stores found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $stores->links() }}
    </div>
</div>
@endsection