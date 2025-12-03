@extends('layouts.buyer')

@section('content')
<h2>Profil Saya</h2>

<p>Nama: {{ auth()->user()->name }}</p>
<p>Email: {{ auth()->user()->email }}</p>

<a href="{{ route('buyer.orders') }}" class="btn-orange">Riwayat Pesanan</a>
@endsection