@extends('layouts.front')

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Checkout Pengiriman</h1>
            <p class="text-slate-500">Lengkapi detail pengiriman untuk menyelesaikan pesanan Anda.</p>
        </div>

        <form action="{{ route('front.checkout.store', $product->slug) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-primary"></i> Alamat Pengiriman
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="w-full rounded-xl border-slate-300 focus:border-primary focus:ring-primary" placeholder="Nama jalan, nomor rumah, RT/RW" required>{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kota</label>
                                <input type="text" name="city" class="w-full rounded-xl border-slate-300 focus:border-primary focus:ring-primary" placeholder="Contoh: Jakarta Selatan" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" class="w-full rounded-xl border-slate-300 focus:border-primary focus:ring-primary" placeholder="12345" required>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200" x-data="{ shipping: 'regular' }">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-truck-fast text-primary"></i> Jenis Pengiriman
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all" 
                                   :class="shipping === 'regular' ? 'border-primary bg-indigo-50/50 ring-1 ring-primary' : 'border-slate-200 hover:border-slate-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_type" value="regular" class="text-primary focus:ring-primary" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-800">Regular (3-5 Hari)</p>
                                        <p class="text-xs text-slate-500">Estimasi sampai lebih santai</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700">Rp 20.000</span>
                            </label>

                            <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                   :class="shipping === 'express' ? 'border-primary bg-indigo-50/50 ring-1 ring-primary' : 'border-slate-200 hover:border-slate-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_type" value="express" class="text-primary focus:ring-primary" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-800">Express (1-2 Hari)</p>
                                        <p class="text-xs text-slate-500">Cepat sampai tujuan</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700">Rp 50.000</span>
                            </label>
                            
                            <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                   :class="shipping === 'instant' ? 'border-primary bg-indigo-50/50 ring-1 ring-primary' : 'border-slate-200 hover:border-slate-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_type" value="instant" class="text-primary focus:ring-primary" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-800">Instant (3 Jam)</p>
                                        <p class="text-xs text-slate-500">Khusus dalam kota</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700">Rp 35.000</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
                        <h2 class="text-lg font-bold text-slate-800 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="flex gap-4 mb-6 pb-6 border-b border-slate-100">
                            <div class="w-16 h-16 rounded-lg bg-slate-50 border border-slate-100 overflow-hidden">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-primary font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Subtotal</span>
                                <span class="font-bold text-slate-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Pajak (11%)</span>
                                <span class="font-bold text-slate-700">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Pengiriman</span>
                                <span class="font-bold text-slate-700 italic">Sesuai Pilihan</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800">Total Estimasi</span>
                                <span class="text-xl font-black text-primary">Rp {{ number_format($total, 0, ',', '.') }}++</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2">
                            <span>Bayar Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection