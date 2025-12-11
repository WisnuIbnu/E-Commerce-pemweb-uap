@extends('layouts.front')

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="{{ route('front.checkout', $product->slug) }}" class="text-slate-900">Checkout</a>
        </nav>
    </div>
</div>

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Checkout Pengiriman</h1>
            <p class="text-slate-500">Lengkapi detail alamat Anda untuk menyelesaikan pesanan.</p>
        </div>

        <form action="{{ route('front.checkout.store', $product->slug) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900">Alamat Pengiriman</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Alamat Lengkap</label>
                                <textarea name="address" rows="3" 
                                    class="w-full rounded-2xl border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm placeholder-slate-400 transition-all p-4" 
                                    placeholder="Nama jalan, nomor rumah, RT/RW, Patokan..." required>{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Kota</label>
                                <input type="text" name="city" 
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all" 
                                    placeholder="Contoh: Jakarta Selatan" required>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" 
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all" 
                                    placeholder="12345" required>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm" x-data="{ shipping: 'regular' }">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-truck-fast text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900">Metode Pengiriman</h2>
                        </div>

                        <div class="space-y-3">
                            <label class="group relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 ease-out" 
                                   :class="shipping === 'regular' ? 'border-primary bg-indigo-50/30' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                                <div class="flex items-center gap-4">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                         :class="shipping === 'regular' ? 'border-primary' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-primary transform scale-0 transition-transform"
                                             :class="shipping === 'regular' ? 'scale-100' : ''"></div>
                                    </div>
                                    <input type="radio" name="shipping_type" value="regular" class="hidden" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Regular (3-5 Hari)</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Estimasi standar.</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700 text-sm bg-white px-3 py-1 rounded-full border border-slate-200">Rp 20.000</span>
                            </label>

                            <label class="group relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 ease-out" 
                                   :class="shipping === 'express' ? 'border-primary bg-indigo-50/30' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                                <div class="flex items-center gap-4">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                         :class="shipping === 'express' ? 'border-primary' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-primary transform scale-0 transition-transform"
                                             :class="shipping === 'express' ? 'scale-100' : ''"></div>
                                    </div>
                                    <input type="radio" name="shipping_type" value="express" class="hidden" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Express (1-2 Hari)</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Prioritas cepat.</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700 text-sm bg-white px-3 py-1 rounded-full border border-slate-200">Rp 50.000</span>
                            </label>
                            
                            <label class="group relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 ease-out" 
                                   :class="shipping === 'instant' ? 'border-primary bg-indigo-50/30' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                                <div class="flex items-center gap-4">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                         :class="shipping === 'instant' ? 'border-primary' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-primary transform scale-0 transition-transform"
                                             :class="shipping === 'instant' ? 'scale-100' : ''"></div>
                                    </div>
                                    <input type="radio" name="shipping_type" value="instant" class="hidden" x-model="shipping">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Instant (3 Jam)</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Dalam kota.</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700 text-sm bg-white px-3 py-1 rounded-full border border-slate-200">Rp 35.000</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 sticky top-10">
                        <h2 class="text-lg font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-slate-400"></i> Ringkasan Pesanan
                        </h2>
                        
                        <div class="flex gap-4 mb-5 pb-5 border-b border-slate-100">
                            <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm leading-snug mb-1 line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-xs text-slate-500 mb-1">{{ $product->store->name }}</p>
                                <p class="text-slate-900 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 font-medium">Subtotal</span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 font-medium">Pajak (11%)</span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 font-medium">Pengiriman</span>
                                <span class="font-bold text-slate-700 italic bg-slate-50 px-2 py-0.5 rounded text-xs">Sesuai Pilihan</span>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-slate-100 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="block text-base font-bold text-slate-900">Total</span>
                                <span class="text-2xl font-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition-all shadow-lg shadow-primary/30 hover:shadow-primary/50 flex items-center justify-center gap-2 text-sm">
                            <span>Bayar Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-slate-400 text-[10px] font-medium uppercase tracking-wider">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Pembayaran Aman</span>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection