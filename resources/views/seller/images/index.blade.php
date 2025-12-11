<x-seller-layout title="Product Images">

<a href="{{ route('seller.product.images.store', $product->id) }}" class="seller-btn mb-4 inline-block">Upload</a>

<div class="grid grid-cols-3 gap-4">
    @foreach ($images as $img)
        <div class="seller-card">
            <img src="{{ asset('storage/'.$img->image) }}" class="h-40 w-full object-cover rounded">

            <form action="{{ route('product.images.delete', $img->id) }}" method="POST" class="mt-2">
                @csrf @method('DELETE')
                <button class="text-red-500">Delete</button>
            </form>
        </div>
    @endforeach
</div>

</x-seller-layout>