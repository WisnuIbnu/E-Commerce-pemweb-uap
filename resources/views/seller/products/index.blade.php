<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">My Products</h2>
    </x-slot>

    <div class="p-6">

        <a href="{{ route('seller.products.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Add Product
        </a>

        <table class="w-full bg-white shadow rounded mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $p)
                <tr class="border-b">
                    <td class="p-3">
                        @if($p->productImages->first())
                            <img src="{{ asset('storage/'.$p->productImages->first()->image) }}" 
                                 class="w-16 h-16 object-cover">
                        @else
                            <div class="w-16 h-16 bg-gray-200"></div>
                        @endif
                    </td>

                    <td class="p-3">{{ $p->name }}</td>

                    <td class="p-3">Rp {{ number_format($p->price) }}</td>

                    <td class="p-3">{{ $p->stock }}</td>

                    <td class="p-3 space-x-2">

                        <a href="{{ route('seller.products.edit', $p->id) }}" 
                           class="text-blue-600">Edit</a>

                        <form action="{{ route('seller.products.destroy', $p->id) }}" 
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</x-app-layout>
