@extends('layouts.buyer')
@section('title','Edit Profile')

@section('content')
<h1>Edit Profile</h1>

<form action="{{ route('buyer.profile.update') }}" method="POST">
    @csrf
    <input name="name" value="{{ auth()->user()->name }}">
    <button>Save</button>
</form>
@endsection
