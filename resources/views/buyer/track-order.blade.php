@extends('layouts.app')

@section('title', 'Track Order #' . $transaction->code . ' - FlexSport')

@push('styles')
<style>
    .tracking-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 0 1rem;
    }

    .tracking-card {
        background: var(--darkl);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .tracking-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .tracking-number {
        font-family: 'Orbitron', sans-serif;
        color: var(--primary);
        font-size: 1.5rem;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    /* Progress Bar */
    .progress-track {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 3rem 0;
    }

    .progress-track::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #333;
        z-index: 1;
    }

    .step {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 25%;
    }

    .step-circle {
        width: 34px;
        height: 34px;
        background: #1a1a1a;
        border: 4px solid #333;
        border-radius: 50%;
        margin: 0 auto 10px;
        transition: all 0.3s;
    }

    .step.active .step-circle {
        border-color: var(--primary);
        background: var(--primary);
        box-shadow: 0 0 15px var(--primary);
    }

    .step.completed .step-circle {
        border-color: var(--primary);
        background: var(--primary);
    }

    .step-label {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .step.active .step-label {
        color: white;
        text-shadow: 0 0 10px rgba(255,255,255,0.3);
    }

    /* Status Details */
    .status-details {
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .label { color: var(--text-muted); }
    .value { font-weight: 600; color: white; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        text-decoration: none;
        margin-bottom: 1rem;
        transition: color 0.3s;
    }

    .btn-back:hover { color: white; }
</style>
@endpush

@section('content')
<div class="tracking-container">
    <a href="{{ route('transaction.history') }}" class="btn-back">
        ← Back to Orders
    </a>

    <div class="tracking-card">
        <div class="tracking-header">
            <div>
                <div class="tracking-number">TRACKING DETAIL</div>
                <div style="color: var(--text-muted);">Invoice: {{ $transaction->code }}</div>
            </div>
            <div style="text-align: right;">
                <div class="value" style="font-size: 1.1rem;">{{ $transaction->shipping }} - {{ $transaction->shipping_type }}</div>
                @if($transaction->tracking_number)
                <div style="color: var(--primary); margin-top: 0.5rem; font-family: monospace; font-size: 1.1rem;">
                    #{{ $transaction->tracking_number }}
                </div>
                @else
                <div style="color: var(--warning); margin-top: 0.5rem; font-size: 0.9rem;">
                    No Receipt Number Yet
                </div>
                @endif
            </div>
        </div>

        @php
            $status = $transaction->order_status; // pending, processing, shipped, delivered, cancelled
            $steps = ['pending', 'processing', 'shipped', 'delivered'];
            $currentStepIndex = array_search($status, $steps);
            if ($currentStepIndex === false && $status == 'cancelled') $currentStepIndex = -1;
        @endphp

        @if($status == 'cancelled')
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 1.5rem; border-radius: 12px; text-align: center;">
                <h3>ORDER CANCELLED</h3>
                <p>This order has been cancelled.</p>
            </div>
        @else
            <div class="progress-track">
                @foreach($steps as $index => $step)
                <div class="step {{ $index <= $currentStepIndex ? ($index == $currentStepIndex ? 'active' : 'completed') : '' }}">
                    <div class="step-circle"></div>
                    <div class="step-label">{{ ucfirst($step) }}</div>
                </div>
                @endforeach
            </div>

            <div class="status-details">
                <div class="detail-row">
                    <span class="label">Current Status</span>
                    <span class="value" style="text-transform: uppercase; color: var(--primary);">{{ $status }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Order Date</span>
                    <span class="value">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Shipping Address</span>
                    <span class="value" style="text-align: right; max-width: 60%;">
                        {{ $transaction->address }}, {{ $transaction->city }} {{ $transaction->postal_code }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Total Amount</span>
                    <span class="value">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        @endif

        <div style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
            <h3 style="margin-bottom: 1rem;">Items</h3>
            @foreach($transaction->transactionDetails as $detail)
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                <img src="{{ $detail->product->productImages->first()->image ?? '' }}" 
                     style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; background: #333;">
                <div>
                    <div style="font-weight: 600;">{{ $detail->product->name }}</div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">
                        {{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
