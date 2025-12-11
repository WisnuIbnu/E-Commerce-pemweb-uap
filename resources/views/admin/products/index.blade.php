@extends('admin.layout')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
    }

    .card {
        background: #ffffff;
        padding: 20px;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }

    table.product-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .product-table th {
        background: #f3f4f6;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }

    .product-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f1f1;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .action-link {
        color: #374151;
        text-decoration: none;
        margin-right: 10px;
        font-size: 13px;
    }

    .action-link:hover {
        text-decoration: underline;
    }

    .badge-store {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 999px;
        font-size: 12px;
        background: #eef2ff;
        color: #4338ca;
    }

    .btn-delete {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #fecaca;
    }
</style>

<div class="page-header">
    <h2 class="page-title">Manajemen Produk</h2>

    {{-- 
        KALAU mau benar-benar hilang, hapus block tombol ini.
        Atau kalau mau batasi pakai Gate/Policy:
        @can('create', App\Models\Product::class)
            <a href="{{ route('admin.products.create') }}" class="btn-add">
                + Tambah Produk
            </a>
        @endcan
    --}}
</div>

<div class="card">
    <table class="product-table">
        <thead>
            <tr>
                <th style="width:60px;">ID</th>
                <th>Nama Produk</th>
                <th>Toko</th>
                <th>Kategori</th>
                <th class="text-right">Harga</th>
                <th class="text-center" style="width:220px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>

                    <td>{{ $product->name }}</td>

                    <td>
                        @if($product->store)
                            <span class="badge-store">{{ $product->store->name }}</span>
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $product->category->name ?? '-' }}</td>

                    <td class="text-right">
                        Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.products.show', $product->id) }}" class="action-link">
                            Detail
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="action-link">
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                              method="POST"
                              style="display:inline-block;"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color:#6b7280;">
                        Belum ada produk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($products, 'links'))
        <div style="margin-top: 14px;">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
