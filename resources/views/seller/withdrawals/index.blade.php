<!-- resources/views/seller/withdrawals/index.blade.php -->
@extends('layouts.app')
@section('title', 'Withdrawals - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Withdrawals</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Request Withdrawal</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <p class="text-muted mb-1">Available Balance</p>
                    <h3 style="color: var(--primary-color);">
                        Rp {{ number_format($store->balance->balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                
                <form action="{{ url('/seller/withdrawals') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" 
                               min="50000" max="{{ $store->balance->balance ?? 0 }}" required>
                        <small class="text-muted">Minimum: Rp 50.000</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" 
                               value="{{ session('bank_name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="bank_account_name" class="form-control" 
                               value="{{ session('bank_account_name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="bank_account_number" class="form-control" 
                               value="{{ session('bank_account_number') }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Withdrawal History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Bank Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                                <td><strong>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    {{ $withdrawal->bank_name }}<br>
                                    <small class="text-muted">
                                        {{ $withdrawal->bank_account_name }}<br>
                                        {{ $withdrawal->bank_account_number }}
                                    </small>
                                </td>
                                <td>
                                    @if($withdrawal->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($withdrawal->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No withdrawal requests</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $withdrawals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

<!-- ===================================================== -->