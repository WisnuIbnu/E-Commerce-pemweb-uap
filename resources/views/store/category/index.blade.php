@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Kelola Kategori</h1>
                <p class="text-tumbloo-gray">Manage kategori produk</p>
            </div>
            <a href="{{ route('store.categories.create') }}" class="btn-primary">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success fade-in mb-6">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error fade-in mb-6">{{ session('error') }}</div>
        @endif>

        <!-- Categories Table -->
        <div class="card p-6">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Tagline</th>
                                <th>Sub-kategori</th>
                                <th>Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    @if($category->image)
                                        <img src="{{ Storage::url($category->image) }}" 
                                            alt="{{ $category->name }}"
                                            class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-tumbloo-gray-light rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-semibold text-tumbloo-black">{{ $category->name }}</p>
                                    <p class="text-xs text-tumbloo-gray">{{ $category->slug }}</p>
                                </td>
                                <td>{{ $category->tagline ?? '-' }}</td>
                                <td>{{ $category->children->count() }}</td>
                                <td>{{ $category->products->count() }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('store.categories.edit', $category->id) }}" 
                                            class="text-tumbloo-black hover:text-tumbloo-accent text-sm font-semibold"
                                            title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('store.categories.destroy', $category->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                            
                            <!-- Sub-categories -->
                            @foreach($category->children as $child)
                            <tr class="bg-tumbloo-offwhite">
                                <td class="pl-12">
                                    @if($child->image)
                                        <img src="{{ Storage::url($child->image) }}" 
                                            alt="{{ $child->name }}"
                                            class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-tumbloo-gray-light rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-semibold text-tumbloo-black">↳ {{ $child->name }}</p>
                                    <p class="text-xs text-tumbloo-gray">{{ $child->slug }}</p>
                                </td>
                                <td>{{ $child->tagline ?? '-' }}</td>
                                <td>-</td>
                                <td>{{ $child->products->count() }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('store.categories.edit', $child->id) }}" 
                                            class="text-tumbloo-black hover:text-tumbloo-accent text-sm font-semibold"
                                            title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('store.categories.destroy', $child->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="text-tumbloo-gray mb-4">Belum ada kategori</p>
                    <a href="{{ route('store.categories.create') }}" class="btn-primary">
                        Tambah Kategori Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection