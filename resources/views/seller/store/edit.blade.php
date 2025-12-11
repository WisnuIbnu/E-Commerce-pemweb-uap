<!-- resources/views/seller/store/edit.blade.php -->
@extends('layouts.app')
@section('title', 'Edit Store - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Edit Store</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ url('/seller/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="text-center mb-4">
                @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="Store Logo" 
                     class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            </div>
            
            <div class="mb-3">
                <label class="form-label">Store Name</label>
                <input type="text" name="name" class="form-control" value="{{ $store->name }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Store Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep current logo</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">About Store</label>
                <textarea name="about" class="form-control" rows="4" required>{{ $store->about }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $store->phone }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3" required>{{ $store->address }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ $store->city }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ $store->postal_code }}" required>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ url('/seller/dashboard') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- ===================================================== -->