@extends('admin.layout')

@section('content')
<h1>Edit Produk</h1>

<div class="card">
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nama Produk</label>
    <input type="text" name="name" value="{{ $product->name }}" required 
           style="width:100%;padding:10px;margin:10px 0;">

    <label>Harga</label>
    <input type="number" name="price" value="{{ $product->price }}" required 
           style="width:100%;padding:10px;margin:10px 0;">

    <label>Stok</label>
    <input type="number" name="stock" value="{{ $product->stock }}" required 
           style="width:100%;padding:10px;margin:10px 0;">

    <label>Deskripsi</label>
    <textarea name="description" style="width:100%;padding:10px;margin:10px 0;">{{ $product->description }}</textarea>

    <label>Kategori</label>
    <select name="category_id" style="width:100%;padding:10px;margin:10px 0;">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>

    <label>Foto Produk (optional)</label>
    <input type="file" name="image">
    @if($product->image)
        <p>Gambar saat ini:</p>
        <img src="/{{ $product->image }}" width="150">
    @endif

    <button style="padding:10px 20px;background:#FF7A00;color:white;border:none;border-radius:6px;margin-top:10px;">
        Update
    </button>
</form>
</div>

@endsection
