@extends('layouts.seller')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Buat Toko Baru</h2>

    <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Toko --}}
        <div class="mb-3">
            <label class="font-semibold">Nama Toko</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Tentang --}}
        <div class="mb-3">
            <label class="font-semibold">Tentang Toko</label>
            <textarea name="about" class="form-control"></textarea>
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label class="font-semibold">Nomor HP</label>
            <input type="text" name="phone" class="form-control">
        </div>

        {{-- Address --}}
        <div class="mb-3">
            <label class="font-semibold">Alamat</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        {{-- City --}}
        <div class="mb-3">
            <label class="font-semibold">Kota</label>
            <input type="text" name="city" class="form-control">
        </div>

        {{-- Postal Code --}}
        <div class="mb-3">
            <label class="font-semibold">Kode Pos</label>
            <input type="text" name="postal_code" class="form-control">
        </div>

        {{-- Logo Upload --}}
        <div class="mb-3">
            <label class="font-semibold">Logo Toko</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
            <small class="text-muted">Format: JPG, JPEG, PNG, WEBP (max 2MB)</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
