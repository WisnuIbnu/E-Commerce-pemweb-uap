@extends('layouts.seller')
@section('title','Edit Store')

@section('content')

<h2 class="text-xl font-bold mb-4">Edit Store Profile</h2>

<form action="{{ route('seller.store.update') }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label class="block">Store Name</label>
        <input type="text" name="name" class="form-control" value="{{ $store->name }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Description</label>
        <textarea name="description" class="form-control">{{ $store->description }}</textarea>
    </div>

    <div class="mb-3">
        <label class="block">Address</label>
        <input type="text" name="address" class="form-control" value="{{ $store->address }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $store->phone }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Logo</label>
        <input type="file" name="logo" class="form-control">

        @if($store->logo)
            <p class="mt-2">Current Logo:</p>
            <img src="{{ asset('storage/'.$store->logo) }}" width="120">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update Store</button>

</form>

@endsection
