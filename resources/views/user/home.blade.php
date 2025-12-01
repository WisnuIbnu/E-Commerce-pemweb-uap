@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Semua Produk</h2>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <small class="text-muted">
                            {{ $product->category->name ?? '-' }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada produk.</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection
