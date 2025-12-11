<x-seller-layout title="Edit Category">

<div class="seller-card">

<form action="{{ route('seller.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <label>Name</label>
    <input type="text" name="name" class="form-input mb-3" value="{{ $category->name }}">

    <label>Image</label>
    <input type="file" name="image" class="form-input mb-3">

    <button class="seller-btn mt-3">Update</button>
</form>

</div>

</x-seller-layout>