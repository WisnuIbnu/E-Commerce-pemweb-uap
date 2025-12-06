<!-- resources/views/seller/store/register.blade.php -->
@extends('layouts.app')
@section('title', 'Register Store - SORAE')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">Register Your Store</h4></div>
            <div class="card-body">
                <form action="{{ url('/seller/store/register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Store Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Store Logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">About Store</label>
                        <textarea name="about" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Register Store</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection