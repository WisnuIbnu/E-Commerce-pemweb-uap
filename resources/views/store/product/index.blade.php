@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Kelola Produk</h1>
                <p class="text-tumbloo-gray">Manage produk toko Anda</p>
            </div>
            <a href="{{ route('store.products.create') }}" class="btn-primary">
                + Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success fade-in mb-6">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error fade-in mb-6">{{ session('error') }}</div>
        @endif

        <div class="card p-6">
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Kondisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($product->images->first())
                                            <img src="{{ Storage::url($product->images->first()->image) }}" 
                                                alt="{{ $product->name }}"
                                                class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-12 bg-tumbloo-gray-light rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-tumbloo-black">{{ $product->name }}</p>
                                            <p class="text-xs text-tumbloo-gray">{{ Str::limit($product->about, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($product->condition) }}</span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('store.product-images.index', $product->id) }}" 
                                            class="text-tumbloo-black hover:text-tumbloo-accent text-sm font-semibold"
                                            title="Manage Images">
                                            🖼️
                                        </a>
                                        <a href="{{ route('store.products.edit', $product->id) }}" 
                                            class="text-tumbloo-black hover:text-tumbloo-accent text-sm font-semibold"
                                            title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('store.products.destroy', $product->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="text-red-600 hover:text-red-800 text-sm font-semibold"
                                                title="Delete">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-tumbloo-gray mb-4">Belum ada produk</p>
                    <a href="{{ route('store.products.create') }}" class="btn-primary">
                        Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection