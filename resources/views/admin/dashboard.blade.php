@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">

    <!-- JUDUL SANGAT BESAR -->
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <div class="row justify-content-center">

        <!-- Verified Stores -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0" style="background:#cfe8ff; border-radius:14px;">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-1" style="color:#000; font-size:22px;">Verified Stores</h4>
                    <h1 class="fw-bolder" style="color:#000; font-size:38px;">{{ $totalVerified }}</h1>
                </div>
            </div>
        </div>

        <!-- Pending Stores -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0" style="background:#cfe8ff; border-radius:14px;">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-1" style="color:#000; font-size:22px;">Pending Stores</h4>
                    <h1 class="fw-bolder" style="color:#000; font-size:38px;">{{ $totalPending }}</h1>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0" style="background:#cfe8ff; border-radius:14px;">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-1" style="color:#000; font-size:22px;">Total Users</h4>
                    <h1 class="fw-bolder" style="color:#000; font-size:38px;">{{ $totalUsers }}</h1>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0" style="background:#cfe8ff; border-radius:14px;">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-1" style="color:#000; font-size:22px;">Total Products</h4>
                    <h1 class="fw-bolder" style="color:#000; font-size:38px;">{{ $totalProducts }}</h1>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
