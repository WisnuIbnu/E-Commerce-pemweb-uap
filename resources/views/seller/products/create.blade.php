<x-app-layout>

    <x-slot name="header">
        <h1 class="text-2xl font-bold">Create Product</h1>
    </x-slot>

    <div class="container mx-auto max-w-2xl py-4">

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Category</label>
                <select name="product_category_id" class="w-full border p-2 rounded">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Name</label>
                <input name="name" class="w-full border p-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="font-semibold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded"></textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Condition</label>
                <select name="condition" class="w-full border p-2 rounded">
                    <option value="new">New</option>
                    <option value="second">Second</option>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-4">
                <input name="price" type="number" placeholder="Price" class="border p-2 rounded" />
                <input name="weight" type="number" placeholder="Weight (gram)" class="border p-2 rounded" />
                <input name="stock" type="number" placeholder="Stock" class="border p-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="font-semibold">Images (multiple)</label>
                <input type="file" name="images[]" multiple class="w-full" />
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>

    </div>

</x-app-layout>
