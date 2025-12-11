<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">Edit Product</h2>
    </x-slot>

    <div class="p-6 bg-gray-900 min-h-screen text-gray-100">

        {{-- FORM UPDATE PRODUCT --}}
        <form action="{{ route('seller.products.update', $product->id) }}"
              method="POST" class="mb-8 bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-2xl">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold text-sm text-gray-200">Product Name</label>
                    <input type="text" name="name"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           value="{{ $product->name }}" required>
                </div>

                <div>
                    <label class="font-semibold text-sm text-gray-200">Category</label>
                    <select name="product_category_id"
                            class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                   focus:outline-none focus:border-blue-400">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                @selected($cat->id == $product->product_category_id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold text-sm text-gray-200">Condition</label>
                    <select name="condition"
                            class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                   focus:outline-none focus:border-blue-400">
                        <option value="new" @selected($product->condition === 'new')>New</option>
                        <option value="second" @selected($product->condition === 'second')>Second</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold text-sm text-gray-200">Price</label>
                    <input type="number" name="price"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           value="{{ $product->price }}" required>
                </div>

                <div>
                    <label class="font-semibold text-sm text-gray-200">Weight (grams)</label>
                    <input type="number" name="weight"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           value="{{ $product->weight }}" required>
                </div>

                <div>
                    <label class="font-semibold text-sm text-gray-200">Stock</label>
                    <input type="number" name="stock"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           value="{{ $product->stock }}" required>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold text-sm text-gray-200">Description</label>
                    <textarea name="description" rows="5"
                              class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                     focus:outline-none focus:border-blue-400"
                              required>{{ $product->description }}</textarea>
                </div>

            </div>

            <button
                class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded mt-4 shadow transition-colors">
                Update Product
            </button>
        </form>

        {{-- PRODUCT IMAGES MANAGEMENT --}}
        <h3 class="font-semibold text-lg mb-3 text-gray-100">Product Images</h3>

        {{-- LIST ALL IMAGES --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-6">
            @forelse ($product->productImages as $img)
                <div class="border border-gray-700 bg-gray-800 p-2 rounded-xl shadow relative">

                    <img src="{{ asset('storage/' . $img->image) }}"
                         class="w-full h-32 object-cover rounded-lg">

                    @if($img->is_thumbnail)
                        <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            Thumbnail
                        </span>
                    @endif

                    {{-- Delete button --}}
                    <form action="{{ route('seller.products.images.delete', $img->id) }}"
                          method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 text-sm hover:text-red-300">
                            Delete
                        </button>
                    </form>

                </div>
            @empty
                <p class="text-gray-400">No images uploaded.</p>
            @endforelse
        </div>

        {{-- UPLOAD NEW IMAGE --}}
        <form action="{{ route('seller.products.images.store', $product->id) }}"
              method="POST" enctype="multipart/form-data"
              class="border border-gray-700 bg-gray-800 p-4 rounded-2xl shadow">
            @csrf

            <label class="font-semibold text-sm text-gray-200">Upload New Image</label>
            <input type="file" name="image"
                   class="mt-2 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                          focus:outline-none focus:border-blue-400"
                   required>

            <button
                class="bg-green-500 hover:bg-green-400 text-white px-4 py-2 rounded mt-3 shadow transition-colors">
                Upload
            </button>
        </form>

    </div>
</x-app-layout>
