@extends('layouts.buyer')

@section('title', 'Checkout - WALKUNO')

@section('content')

<section class="min-h-screen py-10 md:py-20" x-data="{ 
    shippingType: 'Regular', 
    shippingCost: 15000, 
    subtotal: {{ collect(session('cart'))->sum('subtotal') }},
    updateTotal() {
        if(this.shippingType === 'Regular') this.shippingCost = 15000;
        if(this.shippingType === 'Express') this.shippingCost = 30000;
        if(this.shippingType === 'Same Day') this.shippingCost = 50000;
    }
}">
    <div class="container-custom">
        <form action="{{ route('checkout.process') }}" method="POST" class="flex flex-col lg:flex-row gap-12 lg:gap-24 items-start">
            @csrf
            
            <!-- LEFT FORM -->
            <div class="flex-grow w-full space-y-12">
                <div class="border-b border-gray-100 pb-8">
                    <h1 class="font-heading font-black text-3xl uppercase tracking-tighter mb-2">Checkout</h1>
                    <p class="text-slate-500 text-sm">Please enter your details below to complete your order.</p>
                </div>

                <!-- 1. Contact -->
                <div>
                    <h3 class="font-heading font-bold text-xl mb-6 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-black text-white text-xs flex items-center justify-center">1</span>
                        Contact Info
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="w-full border-b border-gray-300 py-2 focus:border-black outline-none transition-colors placeholder-slate-300" placeholder="John Doe" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Phone</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="w-full border-b border-gray-300 py-2 focus:border-black outline-none transition-colors placeholder-slate-300" placeholder="+62..." required>
                        </div>
                    </div>
                </div>

                <!-- 2. Address -->
                <div>
                    <h3 class="font-heading font-bold text-xl mb-6 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-black text-white text-xs flex items-center justify-center">2</span>
                        Shipping Address
                    </h3>
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Full Address</label>
                            <textarea name="address" rows="1" class="w-full border-b border-gray-300 py-2 focus:border-black outline-none transition-colors placeholder-slate-300 resize-none" placeholder="Street name, house number..." required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">City</label>
                                <input type="text" name="city" class="w-full border-b border-gray-300 py-2 focus:border-black outline-none transition-colors placeholder-slate-300" placeholder="Jakarta" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Post Code</label>
                                <input type="text" name="postal_code" class="w-full border-b border-gray-300 py-2 focus:border-black outline-none transition-colors placeholder-slate-300" placeholder="12345" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Shipping -->
                <div>
                    <h3 class="font-heading font-bold text-xl mb-6 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-black text-white text-xs flex items-center justify-center">3</span>
                        Shipping Method
                    </h3>
                    <div class="space-y-4">
                        @foreach(['Regular' => '15.000', 'Express' => '30.000', 'Same Day' => '50.000'] as $type => $price)
                        <label class="flex items-center justify-between p-4 border border-gray-200 cursor-pointer hover:border-black transition-colors group">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="shipping_type" value="{{ $type }}" x-model="shippingType" @change="updateTotal()" class="text-black focus:ring-black">
                                <span class="font-bold text-sm uppercase tracking-wide group-hover:text-black transition-colors">{{ $type }}</span>
                            </div>
                            <span class="font-medium text-sm">Rp {{ $price }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Payment -->
                <div>
                    <h3 class="font-heading font-bold text-xl mb-6 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-black text-white text-xs flex items-center justify-center">4</span>
                        Payment
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="border border-gray-200 p-4 cursor-pointer hover:border-black transition-colors text-center">
                            <input type="radio" name="payment_method" value="COD" class="sr-only" required>
                            <span class="font-bold text-sm uppercase tracking-wide">COD</span>
                        </label>
                        <label class="border border-gray-200 p-4 cursor-pointer hover:border-black transition-colors text-center">
                            <input type="radio" name="payment_method" value="Transfer" class="sr-only" required>
                            <span class="font-bold text-sm uppercase tracking-wide">Bank Transfer</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- RIGHT SUMMARY -->
            <div class="w-full lg:w-[400px] flex-shrink-0 lg:sticky lg:top-24">
                <div class="bg-gray-50 p-8">
                    <h2 class="font-heading font-black text-xl mb-6 uppercase tracking-tight">Order Summary</h2>
                    
                    <!-- Minified Items -->
                    <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach(session('cart') as $item)
                        <div class="flex gap-4">
                            <div class="w-12 h-16 bg-white flex-shrink-0 overflow-hidden">
                                @php $img = \App\Models\Product::find($item['id'])->images->first()->image ?? null; @endphp
                                @if($img)
                                    <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 transition-all">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-900 line-clamp-1">{{ $item['name'] }}</p>
                                <p class="text-[10px] text-slate-500">Size: {{ $item['size'] }} | Qty: {{ $item['qty'] }}</p>
                                <p class="text-[10px] font-bold text-slate-900 mt-1">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-6 space-y-2 text-sm text-slate-600 mb-8">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format(collect(session('cart'))->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span x-text="'Rp ' + shippingCost.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between font-bold text-black text-lg pt-4">
                            <span>Total</span>
                            <span x-text="'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-blue-600 transition-colors">
                        Place Order
                    </button>
                    
                    <p class="text-[10px] text-slate-400 text-center mt-4">
                        By placing this order, you agree to our <a href="#" class="underline">Terms</a> and <a href="#" class="underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
            
        </form>
    </div>
</section>
@endsection
