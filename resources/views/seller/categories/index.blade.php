<x-seller-layout title="Categories">

<a href="{{ route('seller.categories.index') }}" class="seller-btn mb-4 inline-block">
    + Add Category
</a>

<div class="seller-card">
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th></th>
        </tr>

        @foreach ($categories as $cat)
        <tr>
            <td>{{ $cat->name }}</td>
            <td><img src="{{ asset('storage/'.$cat->image) }}" class="h-14"></td>
            <td>
                <a href="{{ route('seller.categories.edit', $cat->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('seller.categories.destroy', $cat->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-500 ml-2">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</x-seller-layout>