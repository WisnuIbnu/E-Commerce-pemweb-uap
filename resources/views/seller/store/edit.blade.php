@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Store Profile</h1>

    <form method="POST" action="{{ route('seller.store.update') }}">
        @csrf
        @method('PATCH')

        <!-- Nama Toko -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Toko</label>
            <input type="text" name="name" value="{{ old('name', $store->name) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <!-- Deskripsi Toko -->
        <div class="mb-4">
            <label for="about" class="block text-sm font-medium text-gray-700">Deskripsi Toko</label>
            <textarea name="about" rows="4" class="mt-1 w-full border rounded-md px-3 py-2" required>{{ old('about', $store->about) }}</textarea>
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" name="address" value="{{ old('address', $store->address) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <!-- Kota -->
        <div class="mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
            <input type="text" name="city" value="{{ old('city', $store->city) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <!-- Kode Pos -->
        <div class="mb-4">
            <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}" class="mt-1 w-full border rounded-md px-3 py-2" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan Perubahan</button>
    </form>
</div>
@endsection
