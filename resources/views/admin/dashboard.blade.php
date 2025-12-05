@extends('admin.layout')

@section('content')

<h1>Admin Dashboard</h1>

<div class="card">
    <p><strong>Total Users:</strong> {{ $userCount }}</p>
    <p><strong>Total Products:</strong> {{ $productCount }}</p>
    <p><strong>Total Stores:</strong> {{ $storeCount }}</p>
    <p><strong>Total Transactions:</strong> {{ $transactionCount }}</p>
</div>

@endsection
