@extends('layouts.admin')

@section('title', 'Tambah Store')

@section('content')
<h3 class="fw-bold mb-4">Tambah Store</h3>

<form action="{{ route('admin.stores.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Store</label>
        <input type="text" name="store_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Pemilik</label>
        <input type="text" name="owner" class="form-control" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
