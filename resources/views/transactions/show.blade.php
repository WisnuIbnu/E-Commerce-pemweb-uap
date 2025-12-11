@extends('layouts.app')

@section('title', 'Order Details - SORAE')

@section('content')
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Order #{{ $transaction->code }}</h4>
            </div>
            <div class="card-body">
                <!-- Status Timeline -->
                <div class="mb-4">
                    <h5 style="color: var(--primary-color);">Order Status</h5>
                    <div class="progress" style="height: 30px;">
                        @php
                            $statusWidth = 0;
                            switch($transaction->payment_status) {
                                case 'pending': $statusWidth = 25; break;
                                case 'processing': $statusWidth = 50; break;
                                case 'shipped': $statusWidth = 75; break;
                                case 'completed': $statusWidth = 100; break;
                            }
                        @endphp
                        <div class="progress-bar" style="width: {{ $statusWidth }}%; background: var(--primary-color);">
                            {{ ucfirst($transaction->payment_status) }}
                        </div>
                    </div>
                </div>
                
                <!-- Products -->
                <h5 style="color: var(--primary-color);">Products</h5>
                @foreach($transaction->details as $detail)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if($detail->product->images->first())
                                <img src="{{ asset('storage/' . $detail->product->images->first()->image) }}" 
                                     alt="{{ $detail->product->name }}" 
                                     class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6>{{ $detail->product->name }}</h6>
                                <p class="text-muted mb-0">Qty: {{ $detail->qty }}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h5 style="color: var(--primary-color);">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </h5>
                                
                                @if($transaction->payment_status === 'completed')
                                    @php
                                        $hasReview = $detail->product->reviews()
                                            ->where('transaction_id', $transaction->id)
                                            ->exists();
                                    @endphp
                                    
                                    @if(!$hasReview)
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#reviewModal{{ $detail->product->id }}">
                                        <i class="fas fa-star"></i> Review
                                    </button>
                                    
                                    <!-- Review Modal -->
                                    <div class="modal fade" id="reviewModal{{ $detail->product->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ url('/transactions/' . $transaction->id . '/review') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $detail->product->id }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Review Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Rating</label>
                                                            <div class="rating-input">
                                                                @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $detail->product->id }}_{{ $i }}" required>
                                                                <label for="rating{{ $detail->product->id }}_{{ $i }}">
                                                                    <i class="fas fa-star"></i>
                                                                </label>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Review</label>
                                                            <textarea name="review" class="form-control" rows="4" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="badge bg-success">Reviewed</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->details->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong style="color: var(--primary-color);">
                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </div>
        
        <!-- Shipping Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Shipping Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Address:</strong><br>{{ $transaction->address }}</p>
                <p class="mb-2"><strong>City:</strong> {{ $transaction->city }}</p>
                <p class="mb-2"><strong>Postal Code:</strong> {{ $transaction->postal_code }}</p>
                <p class="mb-2"><strong>Shipping Type:</strong> {{ ucfirst($transaction->shipping_type) }}</p>
                @if($transaction->tracking_number)
                <p class="mb-0"><strong>Tracking:</strong> {{ $transaction->tracking_number }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 10px;
}

.rating-input input {
    display: none;
}

.rating-input label {
    cursor: pointer;
    font-size: 2rem;
    color: #ddd;
}

.rating-input input:checked ~ label,
.rating-input label:hover,
.rating-input label:hover ~ label {
    color: #ffc107;
}
</style>
@endsection