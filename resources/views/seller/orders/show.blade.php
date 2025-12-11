<!-- resources/views/seller/orders/show.blade.php -->
@extends('layouts.app')
@section('title', 'Order Detail - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Order #{{ $order->code }}</h2>
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h5>Order Items</h5></div>
            <div class="card-body">
                @foreach($order->details as $detail)
                <div class="d-flex mb-3">
                    <img src="{{ $detail->product->images->first() ? asset('storage/' . $detail->product->images->first()->image) : '' }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                    <div class="ms-3">
                        <h6>{{ $detail->product->name }}</h6>
                        <p class="mb-0">Qty: {{ $detail->qty }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</p>
                        <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Update Status -->
        <div class="card">
            <div class="card-header"><h5>Update Order Status</h5></div>
            <div class="card-body">
                <form action="{{ url('/seller/orders/' . $order->id . '/update-status') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <select name="status" class="form-control">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->payment_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->payment_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </div>
                </form>
                
                <form action="{{ url('/seller/orders/' . $order->id . '/shipping') }}" method="POST">
                    @csrf
                    <label class="form-label">Tracking Number</label>
                    <div class="input-group">
                        <input type="text" name="tracking_number" class="form-control" 
                               value="{{ $order->tracking_number }}" placeholder="Enter tracking number">
                        <button type="submit" class="btn btn-success">Update Tracking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><h5>Customer Info</h5></div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->buyer->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->buyer->user->email }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $order->buyer->phone_number ?? '-' }}</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header"><h5>Shipping Address</h5></div>
            <div class="card-body">
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->postal_code }}</p>
                <p class="mb-0"><strong>Method:</strong> {{ ucfirst($order->shipping_type) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection