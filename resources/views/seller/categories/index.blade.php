<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/seller_categories.css') }}">
    @endpush

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="seller-tabs">
            <a href="{{ route('seller.products.index') }}" class="tab-item">
                Produk Saya
            </a>
            <a href="{{ route('seller.categories.index') }}" class="tab-item active">
                Kategori Produk
            </a>
            <a href="{{ route('seller.orders.index') }}" class="tab-item">
                Pesanan
            </a>
            <a href="{{ route('store.balance.index') }}" class="tab-item">
                Saldo Toko
            </a>
            <a href="{{ route('seller.withdrawals.index') }}" class="tab-item">
                Penarikan Dana
            </a>
        </div>

        <div class="categories-section">
            <div class="section-header">
                <h2>Daftar Kategori ({{ $categories->total() }})</h2>
                <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">
                    + Tambah Kategori
                </a>
            </div>

            @if($categories->count() > 0)
                <div class="categories-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Kategori</th>
                                <th>Parent</th>
                                <th>Slug</th>
                                <th>Tagline</th>
                                <th>Jumlah Produk</th>
                                <th>Sub-Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->image)
                                            <img 
                                                src="{{ asset('storage/' . $category->image) }}" 
                                                alt="{{ $category->name }}"
                                                class="category-thumb"
                                            >
                                        @else
                                            <div class="no-image-small">No Image</div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge badge-parent">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        {{ $category->tagline ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $category->products->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $category->children->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a 
                                                href="{{ route('seller.categories.edit', $category->id) }}" 
                                                class="btn-action btn-edit"
                                                title="Edit"
                                            >
                                                ✏️
                                            </a>
                                            <form 
                                                method="POST" 
                                                action="{{ route('seller.categories.destroy', $category->id) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                                style="display: inline;"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="btn-action btn-delete"
                                                    title="Hapus"
                                                    {{ $category->products->count() > 0 || $category->children->count() > 0 ? 'disabled' : '' }}
                                                >
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

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="empty-state">
                    <h3>Belum ada kategori</h3>
                    <p>Mulai tambahkan kategori produk untuk toko Anda</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>