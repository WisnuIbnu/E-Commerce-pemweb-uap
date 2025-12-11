@extends('admin.layout')

@section('content')
<h1>Edit Category</h1>

<div class="card">
<form action="{{ route('admin.categories.update',$category->id) }}" method="POST">
    @csrf @method('PUT')

    <label>Name</label>
    <input type="text" name="name" value="{{ $category->name }}"
           required style="width:100%;padding:10px;margin:10px 0;">

    <button style="padding:10px 20px;background:#FF7A00;color:white;border:none;border-radius:6px;">
        Update
    </button>
</form>
</div>
@endsection
