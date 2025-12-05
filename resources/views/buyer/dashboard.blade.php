@extends('layouts.buyer')
@section('title','Dashboard')

@section('content')
<h1>Buyer Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}!</p>
@endsection
