@extends('layouts.admin')

@section('title', 'Edit Store')

@section('content')
<h3 class="fw-bold mb-4">Edit Store</h3>

<form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama Store</label>
        <input type="text" name="store_name" value="{{ $store->store_name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Pemilik</label>
        <input type="text" name="owner" value="{{ $store->owner }}" class="form-control" required>
    </div>

    <button class="btn btn-warning">Update</button>
</form>
@endsection
