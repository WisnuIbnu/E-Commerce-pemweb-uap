@extends('layouts.buyer')

@section('content')
<h2>Berhasil Checkout!</h2>
<p>Terima kasih telah membeli produk LUNPIA SNACK.</p>

<a href="{{ route('buyer.home') }}" class="btn-orange">Kembali ke Home</a>
@endsection