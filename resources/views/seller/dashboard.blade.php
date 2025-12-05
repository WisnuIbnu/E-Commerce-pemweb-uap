@extends('layouts.app')

@section('content')
    <h2>Selamat datang di Dashboard Seller!</h2>
    <p>Kelola toko Anda di sini.</p>

    <!-- Manajemen Produk -->
    <div class="product-management">
        <h3>Kelola Produk</h3>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
        <div class="product-list">
            <!-- Daftar produk -->
        </div>
    </div>
@endsection
