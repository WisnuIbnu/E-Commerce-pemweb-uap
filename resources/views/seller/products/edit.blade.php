<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Product</h2>
    </x-slot>

    <div class="p-6">

        {{-- FORM UPDATE PRODUCT --}}
        <form action="{{ route('seller.products.update', $product->id) }}" 
              method="POST" class="mb-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">Product Name</label>
                    <input type="text" name="name" 
                           class="border p-2 w-full"
                           value="{{ $product->name }}" required>
                </div>

                <div>
                    <label class="font-semibold">Category</label>
                    <select name="product_category_id" class="border p-2 w-full">
                        @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            @selected($cat->id == $product->product_category_id)>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Condition</label>
                    <select name="condition" class="border p-2 w-full">
                        <option value="new" @selected($product->condition === 'new')>New</option>
                        <option value="second" @selected($product->condition === 'second')>Second</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Price</label>
                    <input type="number" name="price" class="border p-2 w-full"
                           value="{{ $product->price }}" required>
                </div>

                <div>
                    <label class="font-semibold">Weight (grams)</label>
                    <input type="number" name="weight" class="border p-2 w-full"
                           value="{{ $product->weight }}" required>
                </div>

                <div>
                    <label class="font-semibold">Stock</label>
                    <input type="number" name="stock" class="border p-2 w-full"
                           value="{{ $product->stock }}" required>
                </div>

                <div class="col-span-2">
                    <label class="font-semibold">Description</label>
                    <textarea name="description" class="border p-2 w-full" rows="5" required>
                        {{ $product->description }}
                    </textarea>
                </div>

            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
                Update Product
            </button>
        </form>


        {{-- ========================== --}}
        {{-- PRODUCT IMAGES MANAGEMENT --}}
        {{-- ========================== --}}
        <h3 class="font-semibold text-lg mb-3">Product Images</h3>

        {{-- LIST ALL IMAGES --}}
        <div class="grid grid-cols-6 gap-4 mb-6">

            @forelse ($product->productImages as $img)
            <div class="border p-2 rounded shadow relative">

                <img src="{{ asset('storage/' . $img->image) }}"
                     class="w-full h-32 object-cover rounded">

                @if($img->is_thumbnail)
                <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded">
                    Thumbnail
                </span>
                @endif

                {{-- Delete button --}}
                <form action="{{ route('seller.products.images.delete', $img->id) }}" 
                      method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 text-sm">
                        Delete
                    </button>
                </form>

            </div>
            @empty
            <p class="text-gray-500">No images uploaded.</p>
            @endforelse

        </div>

        {{-- UPLOAD NEW IMAGE --}}
        <form action="{{ route('seller.products.images.store', $product->id) }}" 
              method="POST" enctype="multipart/form-data" class="border p-4 rounded">
            @csrf

            <label class="font-semibold">Upload New Image</label>
            <input type="file" name="image" class="border p-2 w-full mt-2" required>

            <button class="bg-green-600 text-white px-4 py-2 rounded mt-3">
                Upload
            </button>
        </form>

    </div>

</x-app-layout>
