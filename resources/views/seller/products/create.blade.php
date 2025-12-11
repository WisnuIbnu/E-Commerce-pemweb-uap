<!-- resources/views/seller/products/create.blade.php -->
@extends('layouts.app')
@section('title', 'Add Product - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Add New Product</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ url('/seller/products') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="product_category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="about" class="form-control" rows="4" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Weight (gram)</label>
                    <input type="number" name="weight" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Condition</label>
                <select name="condition" class="form-control" required>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                <small class="text-muted">You can select multiple images</small>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Create Product</button>
        </form>
    </div>
</div>
@endsection