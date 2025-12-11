@extends('admin.layout')

@section('content')

<h2 style="font-size:26px;font-weight:600;margin-bottom:20px;">
    Detail Toko
</h2>

<div class="card" style="max-width:650px;">

    <div style="margin-bottom:12px;">
        <span style="display:inline-block;width:120px;font-weight:600;">ID</span>
        <span>{{ $store->id }}</span>
    </div>

    <div style="margin-bottom:12px;">
        <span style="display:inline-block;width:120px;font-weight:600;">Nama Toko</span>
        <span>{{ $store->name }}</span>
    </div>

    <div style="margin-bottom:12px;">
        <span style="display:inline-block;width:120px;font-weight:600;">Pemilik</span>
        <span>{{ $store->user->name ?? '-' }}</span>
    </div>

    <div style="margin-bottom:20px;">
        <span style="display:inline-block;width:120px;font-weight:600;">Status</span>

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
    </div>

    <hr style="margin:20px 0;">

    <a href="{{ route('admin.stores.edit',$store->id) }}"
       style="
            display:inline-block;
            padding:10px 18px;
            background:#FF7A00;
            color:white;
            border-radius:6px;
            text-decoration:none;
        ">
        Edit Status
    </a>

</div>

@endsection
