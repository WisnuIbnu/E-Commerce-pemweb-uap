@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <div class="mb-8">
            <a href="{{ route('store.products.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Produk
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Kelola Gambar Produk</h1>
            <p class="text-tumbloo-gray">{{ $product->name }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success fade-in mb-6">{{ session('success') }}</div>
        @endif

        <div class="card p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-black mb-4">Upload Gambar Baru</h2>
            <form action="{{ route('store.product-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="mb-4">
                    <label class="label">Pilih Gambar (Bisa Multiple)</label>
                    <input type="file" name="images[]" 
                        class="input-field @error('images') border-red-500 @enderror" 
                        accept="image/jpeg,image/png,image/jpg" 
                        multiple required>
                    <p class="text-xs text-tumbloo-gray mt-1">Format: JPG, PNG (Max: 2MB per file)</p>
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Upload Gambar
                </button>
            </form>
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-bold text-tumbloo-black mb-6">Gambar Produk</h2>

            @if($images->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $image)
                    <div class="relative group">
                        <img src="{{ Storage::url($image->image) }}" 
                            alt="Product Image" 
                            class="w-full h-48 object-cover rounded-lg">
                        
                        @if($image->is_thumbnail)
                            <div class="absolute top-2 left-2">
                                <span class="badge badge-success text-xs">Thumbnail</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="flex gap-2">
                                @if(!$image->is_thumbnail)
                                <form action="{{ route('store.product-images.set-thumbnail', $image->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-tumbloo-white text-tumbloo-black px-3 py-2 rounded-lg text-sm font-semibold hover:bg-tumbloo-offwhite"
                                        title="Set as Thumbnail">
                                        ⭐ Jadikan Thumbnail
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('store.product-images.destroy', $image->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-700"
                                        title="Delete">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-tumbloo-gray">Belum ada gambar. Upload gambar pertama!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection