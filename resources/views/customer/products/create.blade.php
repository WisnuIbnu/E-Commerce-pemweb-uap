<x-app-layout>

    <x-slot name="header">
        <h1 class="text-2xl font-bold">Add New Product</h1>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Store</label>
                <input type="text" name="store_id" required
                    class="w-full border p-2 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="font-semibold">Category</label>
                <select name="product_category_id"
                    class="w-full border p-2 rounded mt-1">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Name</label>
                <input type="text" name="name" required
                    class="w-full border p-2 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="font-semibold">Description</label>
                <textarea name="description" required
                    class="w-full border p-2 rounded mt-1"></textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Condition</label>
                <select name="condition"
                    class="w-full border p-2 rounded mt-1">
                    <option value="new">New</option>
                    <option value="second">Second</option>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Price</label>
                    <input type="number" name="price" required
                        class="w-full border p-2 rounded mt-1">
                </div>
                <div>
                    <label class="font-semibold">Weight (gram)</label>
                    <input type="number" name="weight" required
                        class="w-full border p-2 rounded mt-1">
                </div>
                <div>
                    <label class="font-semibold">Stock</label>
                    <input type="number" name="stock" required
                        class="w-full border p-2 rounded mt-1">
                </div>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save
            </button>

        </form>

    </div>

</x-app-layout>
