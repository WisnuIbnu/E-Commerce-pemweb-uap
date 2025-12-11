@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Products</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
        </div>
    @endif

    <a href="{{ route('seller.products.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700">Tambah Produk</a>

    <!-- Daftar Produk -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Gambar</th>
                    <th class="px-4 py-2">Nama Produk</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-2">
                            @if($product->productImages->where('is_thumbnail', true)->first())
                                <img src="{{ asset('storage/' . $product->productImages->where('is_thumbnail', true)->first()->image) }}" class="w-20 h-20 object-cover rounded" alt="{{ $product->name }}">
                            @elseif($product->productImages->first())
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" class="w-20 h-20 object-cover rounded" alt="{{ $product->name }}">
                            @else
                                <span class="text-gray-400 text-xs">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->category->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $product->stock }}</td>
                        <td class="px-4 py-2">{{ $product->status }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-500">Edit</a> |
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
