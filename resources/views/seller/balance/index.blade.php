<!-- resources/views/seller/balance/index.blade.php -->
@extends('layouts.app')
@section('title', 'Balance - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Store Balance</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-wallet fa-4x mb-3" style="color: var(--primary-color);"></i>
                <h3 style="color: var(--primary-color);">Rp {{ number_format($balance->balance, 0, ',', '.') }}</h3>
                <p class="text-muted mb-0">Available Balance</p>
                <a href="{{ url('/seller/withdrawals') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-money-bill-wave"></i> Withdraw
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Transaction History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->type === 'credit' ? 'success' : 'danger' }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($item->reference_type) }} #{{ $item->reference_id }}</td>
                                <td>
                                    <strong style="color: {{ $item->type === 'credit' ? 'green' : 'red' }};">
                                        {{ $item->type === 'credit' ? '+' : '-' }}Rp {{ number_format($item->amount, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>{{ $item->remarks }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No transaction history</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $history->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

<!-- ===================================================== -->