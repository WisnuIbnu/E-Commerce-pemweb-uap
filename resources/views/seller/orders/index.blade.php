<!-- resources/views/seller/orders/index.blade.php -->
@extends('layouts.app')
@section('title', 'Orders - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Orders Management</h2>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->code }}</strong></td>
                        <td>{{ $order->buyer->user->name }}</td>
                        <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ url('/seller/orders/' . $order->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No orders</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
