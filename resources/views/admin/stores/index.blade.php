@extends('admin.layout')

@section('content')

<h2 style="font-size:26px;font-weight:600;margin-bottom:20px;">
    Manajemen Toko
</h2>

<div class="card">

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f3f3f3; text-align:left;">
                <th style="padding:12px;">Nama Toko</th>
                <th style="padding:12px;">Pemilik</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($stores as $store)
            <tr style="border-bottom:1px solid #ececec;">
                <td style="padding:12px;">{{ $store->name }}</td>

                <td style="padding:12px;">
                    {{ $store->user->name ?? '-' }}
                </td>

                <td style="padding:12px;">
                    @if($store->status == 'approved')
                        <span style="
                            padding:4px 10px;
                            border-radius:6px;
                            font-size:13px;
                            background:#d1fadf;
                            color:#14532d;
                        ">
                            Approved
                        </span>
                    @elseif($store->status == 'pending')
                        <span style="
                            padding:4px 10px;
                            border-radius:6px;
                            font-size:13px;
                            background:#fef9c3;
                            color:#92400e;
                        ">
                            Pending
                        </span>
                    @else
                        <span style="
                            padding:4px 10px;
                            border-radius:6px;
                            font-size:13px;
                            background:#fee2e2;
                            color:#991b1b;
                        ">
                            Rejected
                        </span>
                    @endif
                </td>

                <td style="padding:12px;">
                    <a href="{{ route('admin.stores.show', $store->id) }}">Detail</a>
                    <span style="margin:0 4px;">|</span>
                    <a href="{{ route('admin.stores.edit', $store->id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
