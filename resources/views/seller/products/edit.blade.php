
<!-- resources/views/seller/products/edit.blade.php -->
@extends('layouts.app')
@section('title', 'Edit Product - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Edit Product</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ url('/seller/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Existing Images -->
            <div class="mb-3">
                <label class="form-label">Current Images</label>
                <div class="row g-2">
                    @foreach($product->images as $image)
                    <div class="col-md-2">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image->image) }}" 
                                 class="img-fluid rounded" style="width: 100%; height: 100px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                    onclick="deleteImage({{ $image->id }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="product_category_id" class="form-control" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->product_category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="about" class="form-control" rows="4" required>{{ $product->about }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Weight (gram)</label>
                    <input type="number" name="weight" class="form-control" value="{{ $product->weight }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Condition</label>
                <select name="condition" class="form-control" required>
                    <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>New</option>
                    <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Add More Images (Optional)</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div>
            
            <div class="text-end">
                <a href="{{ url('/seller/products') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function deleteImage(imageId) {
    if (confirm('Delete this image?')) {
        fetch(`/seller/products/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection