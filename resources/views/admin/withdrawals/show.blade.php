{{-- resources/views/admin/withdrawals/show.blade.php --}}
@extends('admin.layout') {{-- Sesuaikan lagi dengan layout admin kamu --}}

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <h1 style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">
        Detail Withdrawal #{{ $withdrawal->id }}
    </h1>
    <p style="font-size: 13px; color:#6b7280; margin-bottom:15px;">
        Permintaan penarikan dari toko
        <strong>{{ $withdrawal->storeBalance->store->name ?? '-' }}</strong>
    </p>

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

    <div style="font-size:13px; color:#111827; display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:15px;">
        <div>
            <div style="font-size:11px; color:#6b7280;">Toko</div>
            <div style="font-weight:600;">
                {{ $withdrawal->storeBalance->store->name ?? '-' }}
            </div>
            <div style="font-size:11px; color:#6b7280;">
                Seller: {{ $withdrawal->storeBalance->store->user->name ?? '-' }}
            </div>
        </div>
        <div>
            <div style="font-size:11px; color:#6b7280;">Tanggal Pengajuan</div>
            <div style="font-weight:500;">
                {{ $withdrawal->created_at->format('d M Y H:i') }}
            </div>
        </div>
        <div>
            <div style="font-size:11px; color:#6b7280;">Nominal</div>
            <div style="font-size:18px; font-weight:700;">
                Rp {{ number_format($withdrawal->amount ?? 0, 0, ',', '.') }}
            </div>
        </div>
        <div>
            <div style="font-size:11px; color:#6b7280;">Status</div>
            @php
                $status = $withdrawal->status;
                $badgeStyle = match ($status) {
                    'pending'  => 'background:#fef3c7;color:#92400e;',
                    'approved' => 'background:#dbeafe;color:#1d4ed8;',
                    'rejected' => 'background:#fee2e2;color:#b91c1c;',
                    'paid'     => 'background:#dcfce7;color:#166534;',
                    default    => 'background:#f3f4f6;color:#4b5563;',
                };
            @endphp
            <span style="display:inline-block; padding:3px 8px; border-radius:999px; font-size:11px; font-weight:600; {{ $badgeStyle }}">
                {{ ucfirst($status ?? '-') }}
            </span>
        </div>
    </div>

    <div style="border-top:1px solid #e5e7eb; padding-top:10px; margin-top:5px; font-size:13px;">
        <div style="font-size:11px; color:#6b7280; margin-bottom:4px;">Rekening Tujuan</div>
        <div style="margin-bottom:3px;">
            Bank: <strong>{{ $withdrawal->bank_name ?? '-' }}</strong>
        </div>
        <div style="margin-bottom:3px;">
            No. Rekening:
            <span style="font-family:monospace;">
                {{ $withdrawal->bank_account ?? $withdrawal->bank_account_number ?? '-' }}
            </span>
        </div>
        <div style="margin-bottom:3px;">
            Atas Nama: <strong>{{ $withdrawal->bank_account_name ?? '-' }}</strong>
        </div>
    </div>

    @if($withdrawal->note)
        <div style="border-top:1px solid #e5e7eb; padding-top:10px; margin-top:5px; font-size:13px;">
            <div style="font-size:11px; color:#6b7280; margin-bottom:4px;">Catatan Seller</div>
            <div>{{ $withdrawal->note }}</div>
        </div>
    @endif

    @if($withdrawal->status === 'pending')
        <div style="margin-top:15px; display:flex; gap:8px;">
            <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="approved">
                <button type="submit"
                        style="padding:6px 12px; border:none; border-radius:6px; background:#3b82f6; color:white; font-size:13px; cursor:pointer;">
                    Approve
                </button>
            </form>

            <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <button type="submit"
                        style="padding:6px 12px; border:none; border-radius:6px; background:#ef4444; color:white; font-size:13px; cursor:pointer;">
                    Reject
                </button>
            </form>
        </div>
    @endif

    <div style="margin-top:15px;">
        <a href="{{ route('admin.withdrawals.index') }}" style="font-size:13px; color:#f97316; text-decoration:none;">
            &larr; Kembali ke daftar withdrawal
        </a>
    </div>
</div>
@endsection
