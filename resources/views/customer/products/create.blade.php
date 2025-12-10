<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Add Product</h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('seller.products.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label>Product Name</label>
                    <input type="text" name="name" class="border p-2 w-full" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Category</label>
                    <label class="block mb-2 font-semibold">Category</label>
                    <select name="product_category_id" class="border p-2 w-full" required>
                        <optgroup label="Elektronik">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>

                </div>

                <div>
                    <label>Condition</label>
                    <select name="condition" class="border p-2 w-full" required>
                        <option value="new">New</option>
                        <option value="second">Second</option>
                    </select>
                </div>

                <div>
                    <label>Price</label>
                    <input type="text" name="price" class="border p-2 w-full" required>
                </div>

                <div>
                    <label>Weight (grams)</label>
                    <input type="number" name="weight" class="border p-2 w-full" required>
                </div>

                <div>
                    <label>Stock</label>
                    <input type="number" name="stock" class="border p-2 w-full" required>
                </div>

                <div class="col-span-2">
                    <label>Description</label>
                    <textarea name="description" class="border p-2 w-full" required></textarea>
                </div>

                <div class="col-span-2">
                    <label>Images (can upload multiple)</label>
                    <input type="file" name="images[]" multiple class="border p-2 w-full">
                </div>

            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
                Save Product
            </button>
        </form>

    </div>

</x-app-layout>
