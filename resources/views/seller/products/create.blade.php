<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">Add Product</h2>
    </x-slot>

    <div class="p-6 bg-gray-900 min-h-screen text-gray-100">

        <form action="{{ route('seller.products.store') }}"
              method="POST" enctype="multipart/form-data"
              class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-2xl">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- PRODUCT NAME --}}
                <div>
                    <label class="font-semibold text-sm text-gray-200">Product Name</label>
                    <input type="text" name="name"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           required>
                </div>

                {{-- CATEGORY --}}
                <div>
                    <label class="block mb-2 font-semibold text-sm text-gray-200">Category</label>
                    <select name="product_category_id"
                            class="border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                   focus:outline-none focus:border-blue-400"
                            required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- CONDITION --}}
                <div>
                    <label class="font-semibold text-sm text-gray-200">Condition</label>
                    <select name="condition"
                            class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                   focus:outline-none focus:border-blue-400"
                            required>
                        <option value="new">New</option>
                        <option value="second">Second</option>
                    </select>
                </div>

                {{-- PRICE --}}
                <div>
                    <label class="font-semibold text-sm text-gray-200">Price</label>
                    <input type="text" name="price"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           pattern="\d+(\.\d{1,2})?" inputmode="decimal" required>
                </div>

                {{-- WEIGHT --}}
                <div>
                    <label class="font-semibold text-sm text-gray-200">Weight (grams)</label>
                    <input type="text" name="weight"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           pattern="\d+" inputmode="numeric" required>
                </div>

                {{-- STOCK --}}
                <div>
                    <label class="font-semibold text-sm text-gray-200">Stock</label>
                    <input type="text" name="stock"
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400"
                           pattern="\d+" inputmode="numeric" required>
                </div>

                {{-- DESCRIPTION --}}
                <div class="md:col-span-2">
                    <label class="font-semibold text-sm text-gray-200">Description</label>
                    <textarea name="description" rows="3"
                              class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                     focus:outline-none focus:border-blue-400"
                              required></textarea>
                </div>

                {{-- IMAGES --}}
                <div class="md:col-span-2">
                    <label class="font-semibold text-sm text-gray-200">Images (can upload multiple)</label>
                    <input type="file" name="images[]" multiple
                           class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded
                                  focus:outline-none focus:border-blue-400">
                </div>

            </div>

            <button
                class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded mt-4 shadow transition-colors">
                Save Product
            </button>
        </form>

    </div>
</x-app-layout>
