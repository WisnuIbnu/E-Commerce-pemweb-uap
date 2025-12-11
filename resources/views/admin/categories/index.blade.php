@extends('admin.layout')

@section('content')
<h1>Categories</h1>

<div class="card">

<a href="{{ route('admin.categories.create') }}"
   style="padding:10px 15px;background:#FF7A00;color:white;border-radius:6px;text-decoration:none;">
    + Add Category
</a>

<table style="width:100%; margin-top:20px; border-collapse:collapse;">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
    </tr>

    @foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td>
            <a href="{{ route('admin.categories.edit',$category->id) }}">Edit</a>
            |
            <form action="{{ route('admin.categories.destroy',$category->id) }}" 
                  method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button style="color:red;border:none;background:none;">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

</div>
@endsection
