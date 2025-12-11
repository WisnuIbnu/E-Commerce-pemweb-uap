<x-seller-layout title="Add Category">

<div class="seller-card">

<form action="{{ route('seller.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Name</label>
    <input type="text" name="name" class="form-input mb-3">

    <label>Image</label>
    <input type="file" name="image" class="form-input mb-3">

    <button class="seller-btn mt-3">Save</button>
</form>

</div>

</x-seller-layout>