@extends('admin.layout')

@section('content')
    <h1 style="font-size: 20px; font-weight: 600; margin-bottom: 15px;">
        Transaction Detail #{{ $transaction->id }}
    </h1>

    @if(session('success'))
        <div style="margin-bottom:10px; padding:8px 10px; border-radius:6px; background:#dcfce7; color:#166534; font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="font-size: 13px; color:#111827;">

        {{-- INFO UTAMA --}}
        <p><strong>Kode Transaksi:</strong>
            <span style="font-family:monospace; background:#f3f4f6; padding:2px 6px; border-radius:4px;">
                {{ $transaction->code }}
            </span>
        </p>

        <p><strong>Tanggal:</strong>
            {{ $transaction->created_at->format('d M Y H:i') }}
        </p>

        <p><strong>Buyer:</strong>
            {{ $transaction->buyer->user->name ?? '-' }}
        </p>

        <p><strong>Toko:</strong>
            {{ $transaction->store->name ?? '-' }}
        </p>

        <p><strong>Total:</strong>
            Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}
        </p>

        <p><strong>Status Pembayaran:</strong>
            <span class="status-pill {{ $transaction->payment_status }}">
                {{ $transaction->status_label }}
            </span>
        </p>

        <hr style="margin: 12px 0; border:none; border-top:1px solid #e5e7eb;">

        {{-- ALAMAT & PENGIRIMAN --}}
        <p><strong>Alamat Pengiriman:</strong><br>
            {{ $transaction->address }}<br>
            {{ $transaction->city }} {{ $transaction->postal_code }}
        </p>

        <p><strong>Pengiriman:</strong>
            {{ $transaction->shipping }} ({{ $transaction->shipping_type }})
        </p>

        <p><strong>Ongkir:</strong>
            Rp {{ number_format($transaction->shipping_cost ?? 0, 0, ',', '.') }}
        </p>

        @if($transaction->tracking_number)
            <p><strong>No. Resi:</strong>
                <span style="font-family:monospace;">
                    {{ $transaction->tracking_number }}
                </span>
            </p>
        @endif

        <hr style="margin: 12px 0; border:none; border-top:1px solid #e5e7eb;">

        {{-- ITEMS --}}
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">Items:</h3>

        @if($transaction->details->isEmpty())
            <p style="color:#6b7280;">Tidak ada item.</p>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:5px;">
                <thead>
                    <tr style="background:#f3f4f6; color:#6b7280; text-align:left;">
                        <th style="padding:6px; border-bottom:1px solid #e5e7eb;">Produk</th>
                        <th style="padding:6px; border-bottom:1px solid #e5e7eb; text-align:center;">Qty</th>
                        <th style="padding:6px; border-bottom:1px solid #e5e7eb; text-align:right;">Harga</th>
                        <th style="padding:6px; border-bottom:1px solid #e5e7eb; text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->details as $item)
                        <tr>
                            <td style="padding:6px; border-bottom:1px solid #f3f4f6;">
                                {{ $item->product_name ?? $item->product->name ?? 'Produk' }}
                            </td>
                            <td style="padding:6px; border-bottom:1px solid #f3f4f6; text-align:center;">
                                {{ $item->quantity ?? $item->qty ?? 1 }}
                            </td>
                            <td style="padding:6px; border-bottom:1px solid #f3f4f6; text-align:right;">
                                Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td style="padding:6px; border-bottom:1px solid #f3f4f6; text-align:right;">
                                Rp {{ number_format($item->total ?? $item->subtotal ?? (($item->price ?? 0) * ($item->quantity ?? $item->qty ?? 1)), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- FORM UBAH STATUS OLEH ADMIN --}}
        <div style="margin-top: 16px; padding-top: 10px; border-top:1px solid #e5e7eb;">
            <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 8px;">
                Ubah Status Pembayaran (Admin)
            </h3>

            <form action="{{ route('admin.transactions.update', $transaction->id) }}"
                  method="POST"
                  style="display:flex; align-items:center; gap:8px; font-size:13px;">
                @csrf
                @method('PUT')

                <label for="payment_status" style="font-size:13px; color:#374151;">
                    Status:
                </label>

                <select id="payment_status" name="payment_status"
                        style="border:1px solid #d1d5db; border-radius:6px; padding:4px 8px; font-size:13px;">
                    <option value="pending"
                        {{ $transaction->payment_status === \App\Models\Transaction::STATUS_PENDING ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="waiting_confirmation"
                        {{ $transaction->payment_status === \App\Models\Transaction::STATUS_WAITING_CONFIRMATION ? 'selected' : '' }}>
                        Menunggu Konfirmasi Admin
                    </option>
                    <option value="paid"
                        {{ $transaction->payment_status === \App\Models\Transaction::STATUS_PAID ? 'selected' : '' }}>
                        Paid
                    </option>
                    <option value="failed"
                        {{ $transaction->payment_status === \App\Models\Transaction::STATUS_FAILED ? 'selected' : '' }}>
                        Failed
                    </option>
                </select>

                <button type="submit"
                        style="padding:6px 12px; border:none; border-radius:6px; background:#f97316; color:white; font-size:13px; cursor:pointer;">
                    Simpan
                </button>
            </form>
        </div>

    </div>
@endsection
