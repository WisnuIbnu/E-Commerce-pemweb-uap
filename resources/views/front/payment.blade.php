@extends('layouts.front')

@section('title', 'Pembayaran')

@section('content')
<div class="bg-slate-50 min-h-screen py-10 flex items-center justify-center">
    <div class="max-w-lg w-full px-4">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl text-center">
            
            <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-wallet text-2xl text-primary"></i>
            </div>
            
            <h1 class="text-xl font-bold text-slate-900 mb-2">Konfirmasi Pembayaran</h1>
            <p class="text-slate-500 text-sm mb-6">Scan QRIS di bawah untuk membayar pesanan #{{ $transaction->code }}</p>

            <div class="bg-white p-4 rounded-2xl border-2 border-slate-900 border-dashed mb-6 inline-block">
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" 
                     alt="QRIS Code" 
                     class="w-48 h-48 mx-auto opacity-90">
                <p class="text-[10px] font-bold text-slate-900 mt-2 uppercase tracking-widest">NAMA MERCHANT</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                <p class="text-2xl font-black text-slate-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
            </div>

            <form action="{{ route('front.payment.update', $transaction->code) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 text-base">
                    Saya Sudah Bayar
                </button>
            </form>
            
            <a href="{{ route('home') }}" class="block mt-4 text-xs font-bold text-slate-400 hover:text-primary transition-colors">Batalkan & Kembali</a>
        </div>
    </div>
</div>
@endsection