@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Categories</h1>

    <div class="grid grid-cols-1 gap-6">
        @foreach($categories as $category)
            <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-medium">{{ $category->name }}</h4>
            </div>
        @endforeach
    </div>
</div>
@endsection
