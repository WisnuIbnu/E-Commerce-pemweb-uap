@extends('layouts.buyer')

@section('content')
<h2>Checkout</h2>

<form method="POST" action="{{ route('buyer.checkout.process') }}">
    @csrf
    <label>Nama Penerima</label>
    <input type="text" name="receiver" required>

    <label>Alamat Lengkap</label>
    <textarea name="address" required></textarea>

    <button class="btn-orange">Proses Pembayaran</button>
</form>
@endsection