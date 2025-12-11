{{-- resources/views/admin/withdrawals/index.blade.php --}}
@extends('admin.layout') {{-- GANTI ini sesuai layout yang kamu pakai di halaman admin lain --}}

@section('content')
<div class="card">
    <h1 style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">
        Withdrawals
    </h1>
    <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
        Kelola permintaan penarikan dana dari semua toko.
    </p>

    {{-- Flash message --}}
    @if(session('success'))
        <div style="padding: 8px 10px; background:#dcfce7; color:#166534; font-size:13px; border-radius:6px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 8px 10px; background:#fee2e2; color:#b91c1c; font-size:13px; border-radius:6px; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter status --}}
    <form method="GET" style="margin-bottom: 15px; font-size: 13px; display:flex; align-items:center; gap:6px;">
        <label for="status" style="color:#444;">Filter status:</label>
        <select id="status" name="status"
                style="border:1px solid #ddd; border-radius:6px; padding:4px 8px; font-size:13px;"
                onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="pending"  {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f3f4f6; color:#6b7280; text-align:left;">
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">Tanggal</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb;">Toko</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:right;">Nominal</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:center;">Status</th>
                    <th style="padding:8px; border-bottom:1px solid #e5e7eb; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $wd)
                    @php
                        $status = $wd->status;
                        $badgeStyle = match ($status) {
                            'pending'  => 'background:#fef3c7;color:#92400e;',
                            'approved' => 'background:#dbeafe;color:#1d4ed8;',
                            'rejected' => 'background:#fee2e2;color:#b91c1c;',
                            'paid'     => 'background:#dcfce7;color:#166534;',
                            default    => 'background:#f3f4f6;color:#4b5563;',
                        };
                    @endphp
                    <tr>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            <div style="font-weight:500; color:#111827;">
                                {{ $wd->created_at->format('d M Y') }}
                            </div>
                            <div style="font-size:11px; color:#6b7280;">
                                {{ $wd->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6;">
                            <div style="font-weight:500; color:#111827;">
                                {{ $wd->storeBalance->store->name ?? '-' }}
                            </div>
                            <div style="font-size:11px; color:#6b7280;">
                                {{ $wd->storeBalance->store->user->name ?? '' }}
                            </div>
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:right;">
                            Rp {{ number_format($wd->amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:center;">
                            <span style="display:inline-block; padding:3px 8px; border-radius:999px; font-size:11px; font-weight:600; {{ $badgeStyle }}">
                                {{ ucfirst($status ?? '-') }}
                            </span>
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f4f6; text-align:center;">
                            <a href="{{ route('admin.withdrawals.show', $wd) }}"
                               style="display:inline-block; padding:4px 8px; font-size:11px; border-radius:6px; border:1px solid #d1d5db; color:#374151; text-decoration:none; margin-right:4px;">
                                Detail
                            </a>

                            @if($wd->status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.withdrawals.update', $wd) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit"
                                            style="padding:4px 8px; font-size:11px; border-radius:6px; border:none; background:#3b82f6; color:white; cursor:pointer; margin-right:3px;">
                                        Approve
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ route('admin.withdrawals.update', $wd) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit"
                                            style="padding:4px 8px; font-size:11px; border-radius:6px; border:none; background:#ef4444; color:white; cursor:pointer;">
                                        Reject
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:12px; text-align:center; font-size:13px; color:#6b7280;">
                            Belum ada data withdrawal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:10px;">
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
