@extends('layouts.front')

@section('title', 'Top Up Saldo')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <i class="fa-solid fa-money-check-dollar text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Top Up Saldo</h1>
            <p class="text-indigo-100 text-sm">Isi ulang saldo akun Anda dengan mudah dan cepat.</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex justify-center">
            <div class="w-full lg:w-2/3 xl:w-1/2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 border-b pb-4">Masukkan Jumlah Top Up</h2>
                    
                    <form action="{{ route('saldo.topup.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-2">
                                Jumlah Top Up (Minimal Rp 1.000)
                            </label>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 font-medium">Rp</span>
                                <input 
                                    type="number" 
                                    name="jumlah" 
                                    id="jumlah"
                                    required 
                                    min="1000" 
                                    placeholder="Contoh: 50000"
                                    class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-primary focus:border-primary transition duration-150 ease-in-out"
                                >
                            </div>
                            @error('jumlah')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button 
                                type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-bold text-lg hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30"
                            >
                                Proses Top Up <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="flex items-start p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                            <i class="fa-solid fa-circle-info text-indigo-500 text-xl flex-shrink-0 mt-0.5"></i>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-slate-800">Perhatian</h4>
                                <p class="text-sm text-slate-600 mt-1">
                                    Pastikan Anda memasukkan jumlah top up yang benar. Semua transaksi top up tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection