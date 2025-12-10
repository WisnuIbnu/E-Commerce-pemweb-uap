@extends('admin.layouts.main')

@section('content')
    <h2 class="mb-3">Dashboard Admin</h2>

    <div class="alert alert-info">
        Selamat datang di halaman dashboard admin!
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Total User</h5>
                <p>{{ \App\Models\User::count() }} user</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Pengajuan Toko</h5>
                <p>{{ \App\Models\Store::where('status','pending')->count() }} pending</p>
            </div>
        </div>
    </div>
@endsection
