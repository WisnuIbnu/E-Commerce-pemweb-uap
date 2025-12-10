@extends('layouts.seller')

@section('title', 'Manajemen Produk')
@section('subtitle', 'Kelola katalog produk toko Anda di sini.')

@section('seller-content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    
    {{-- Toolbar Atas --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Produk</h2>
        <a href="{{ route('seller.products.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Tabel Produk --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-tl-xl">Produk</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 rounded-tr-xl text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($products as $product)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">{{ $product->name }}</div>
                                <div class="text-xs text-slate-500">SKU: {{ $product->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-4">
                        {{-- Logika Stok Sederhana --}}
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                            {{ $product->stock > 0 ? 'Ada (' . $product->stock . ')' : 'Habis' }}
                        </span>
                    </td>
                    <td class="p-4">{{ $product->category->name ?? '-' }}</td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                <i class="fa-solid fa-box-open text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-medium">Belum ada produk</p>
                            <p class="text-xs mt-1">Mulai upload produk pertamamu sekarang!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection