@extends('layouts.buyer')

@section('content')
<h2>Selamat Datang di LUNPIA SNACK!</h2>
<p>Nikmati berbagai pilihan keripik premium dari bahan terbaik.</p>

<a href="{{ route('buyer.products') }}" class="btn-orange">Lihat Produk</a>
@endsection