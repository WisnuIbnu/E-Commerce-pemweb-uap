@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">Total Users: {{ $totalUsers }}</div>
    <div class="bg-white p-6 rounded-lg shadow">Total Sellers: {{ $totalSellers }}</div>
    <div class="bg-white p-6 rounded-lg shadow">Total Products: {{ $totalProducts }}</div>
    <div class="bg-white p-6 rounded-lg shadow">Total Orders: {{ $totalOrders }}</div>
</div>
@endsection
