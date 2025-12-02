@extends('layouts.admin')

@section('title', 'Detail Store')

@section('content')
<h3 class="fw-bold mb-4">Detail Store</h3>

<div class="card">
    <div class="card-body">

        <p><strong>Nama Store:</strong> {{ $store->name }}</p>
        <p><strong>Pemilik:</strong> {{ $store->user->name }}</p>

        <p>
            <strong>Status:</strong>
            @if($store->is_verified)
                <span class="badge bg-success">Verified</span>
            @else
                <span class="badge bg-secondary">Pending Verification</span>
            @endif
        </p>

        @if($store->logo)
        <p><strong>Logo:</strong></p>
        <img src="{{ asset('storage/' . $store->logo) }}" width="150">
        @endif

        <hr>

        <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
</div>
@endsection
