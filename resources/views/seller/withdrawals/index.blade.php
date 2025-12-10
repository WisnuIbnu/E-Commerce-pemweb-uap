@extends('layouts.app')

@section('title', 'Withdrawals - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Withdrawal Management</h1>

    <div class="card">
        <h2 class="card-header">Request Withdrawal</h2>
        
        <form action="{{ route('seller.withdrawals.request') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Amount (Rp) *</label>
                <input type="number" name="amount" class="form-control" min="50000" step="1000" required>
                <small style="color: #666;">Minimum withdrawal: Rp 50,000</small>
                @error('amount')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Bank Name *</label>
                <input type="text" name="bank_name" class="form-control" required>
                @error('bank_name')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Account Name *</label>
                <input type="text" name="bank_account_name" class="form-control" required>
                @error('bank_account_name')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Account Number *</label>
                <input type="text" name="bank_account_number" class="form-control" required>
                @error('bank_account_number')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Withdrawal Request</button>
        </form>
    </div>

    <div class="card">
        <h2 class="card-header">Withdrawal History</h2>
        
        @if($withdrawals->isEmpty())
            <p style="text-align: center; color: #666; padding: 2rem;">No withdrawal requests yet</p>
        @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Bank</th>
                            <th>Account</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                            <td><strong>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong></td>
                            <td>{{ $withdrawal->bank_name }}</td>
                            <td>
                                {{ $withdrawal->bank_account_name }}<br>
                                <small>{{ $withdrawal->bank_account_number }}</small>
                            </td>
                            <td>
                                @if($withdrawal->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($withdrawal->status == 'approved')
                                    <span class="badge badge-info">Approved</span>
                                @elseif($withdrawal->status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection