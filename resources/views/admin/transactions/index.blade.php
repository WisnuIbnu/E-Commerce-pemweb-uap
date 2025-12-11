@extends('admin.layout')

@section('content')
    <h1 style="font-size: 20px; font-weight: 600; margin-bottom: 15px;">Transactions</h1>

    <div class="card">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f3f4f6; color:#6b7280; text-align:left;">
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">ID</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">Kode</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">Buyer</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">Toko</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:right;">Total</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:center;">Status</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            {{ $t->id }}
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            <span style="font-family:monospace; font-size:11px; background:#f3f4f6; padding:3px 6px; border-radius:4px;">
                                {{ $t->code }}
                            </span>
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            {{ $t->buyer->user->name ?? '-' }}
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            {{ $t->store->name ?? '-' }}
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:right;">
                            Rp {{ number_format($t->grand_total ?? 0, 0, ',', '.') }}
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:center;">
                            <span class="status-pill {{ $t->payment_status }}">
                                {{ $t->status_label }}
                            </span>
                        </td>

                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:center;">
                            <a href="{{ route('admin.transactions.show', $t->id) }}"
                               style="display:inline-block; padding:4px 8px; font-size:12px; border-radius:6px; border:1px solid #d1d5db; color:#374151; text-decoration:none;">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:10px; text-align:center; font-size:13px; color:#6b7280;">
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- pagination kalau pakai paginate() di controller --}}
        @if(method_exists($transactions, 'links'))
            <div style="margin-top:10px;">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@endsection
