@extends('layouts.buyer')

@section('title', $product->name . ' - WALKUNO')

@section('content')

<section class="min-h-screen py-10 md:py-20" x-data="{ 
    selectedSize: '', 
    qty: 1, 
    activeImage: '{{ $product->images->first()->image ?? '' }}' 
}">
    <div class="container-custom">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-[10px] md:text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-black">Home</a>
            <span>/</span>
            <a href="{{ route('home', ['category' => $product->category->name]) }}" class="hover:text-black">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-black">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
            
            <!-- GALLERY (Left) -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="bg-gray-50 aspect-square overflow-hidden relative group cursor-zoom-in">
                    @if($product->images && $product->images->count() > 0)
                        <img :src="activeImage.startsWith('http') ? activeImage : '{{ asset('storage') }}/' + activeImage" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($product->images && $product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $img)
                            <button @click="activeImage = '{{ $img->image }}'" 
                                    class="bg-gray-50 aspect-square overflow-hidden border transition-all"
                                    :class="activeImage === '{{ $img->image }}' ? 'border-black opacity-100' : 'border-transparent opacity-60 hover:opacity-100'">
                                <img src="{{ Str::startsWith($img->image, 'http') ? $img->image : asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- DETAILS (Right) -->
            <div class="flex flex-col h-full sticky top-24">
                <div class="mb-auto">
                    <!-- Header -->
                    <div class="mb-8 border-b border-gray-100 pb-8">
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-widest">{{ $product->category->name }}</span>
                        <h1 class="font-heading font-black text-4xl md:text-5xl text-slate-900 leading-tight mt-2 mb-4">{{ $product->name }}</h1>
                        <p class="text-2xl font-medium text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Size -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-xs font-bold uppercase tracking-widest text-slate-900">Select Size</label>
                                <button type="button" class="text-xs text-slate-400 hover:text-black underline decoration-slate-300 underline-offset-4">Size Guide</button>
                            </div>
                            
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                                @if($product->sizes)
                                    @foreach($product->sizes as $size)
                                        <div class="relative">
                                            <input type="radio" name="size" id="size_{{ $size }}" value="{{ $size }}" x-model="selectedSize" class="peer sr-only">
                                            <label for="size_{{ $size }}" 
                                                   class="flex items-center justify-center w-full aspect-square border-2 border-slate-100 text-sm font-bold text-slate-400 cursor-pointer transition-all hover:border-black peer-checked:bg-black peer-checked:text-white peer-checked:border-black">
                                                {{ $size }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <p x-cloak x-show="!selectedSize" class="text-red-500 text-[10px] uppercase font-bold mt-2 animate-pulse" style="display: none;">* Please select a size</p>
                        </div>

                        <!-- Actions -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="border border-slate-200 flex items-center justify-between px-4">
                                <span class="text-xs font-bold uppercase text-slate-500">Qty</span>
                                <div class="flex items-center gap-4">
                                    <button type="button" @click="qty > 1 ? qty-- : qty = 1" class="w-8 h-8 text-slate-400 hover:text-black">-</button>
                                    <input type="number" name="qty" x-model="qty" class="w-8 text-center border-none p-0 text-sm font-bold focus:ring-0" readonly>
                                    <button type="button" @click="qty++" class="w-8 h-8 text-slate-400 hover:text-black">+</button>
                                </div>
                            </div>
                            
                            <button type="submit" name="action" value="add_to_cart" 
                                    :disabled="!selectedSize"
                                    class="w-full py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-slate-800 disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed transition-colors">
                                Add to Cart
                            </button>
                        </div>

                        <!-- Info -->
                        <div class="space-y-6 text-sm text-slate-500 leading-relaxed border-t border-gray-100 pt-8">
                            <div>
                                <h3 class="font-bold text-slate-900 uppercase tracking-widest text-xs mb-2">Description</h3>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-bold text-slate-900 uppercase tracking-widest text-[10px] mb-1">Material</h4>
                                    <p>{{ $product->material ?? 'Synthetic' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 uppercase tracking-widest text-[10px] mb-1">Condition</h4>
                                    <p class="capitalize">{{ $product->condition }}</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="mt-24 pt-12 border-t border-gray-100 max-w-2xl" id="review">
            <h3 class="font-heading font-black text-2xl text-slate-900 mb-8 uppercase">Reviews ({{ $product->reviews->count() }})</h3>
            
            <div class="space-y-8">
                @forelse($product->reviews as $review)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-slate-600 flex-shrink-0">
                            {{ substr($review->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-slate-900 text-sm">{{ $review->user->name ?? 'Anonymous' }}</span>
                                <div class="flex text-blue-600 text-xs gap-0.5">
                                    @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                                </div>
                            </div>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $review->comment }}</p>
                            <span class="text-[10px] text-slate-400 uppercase mt-2 block">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 italic text-sm">No reviews yet for this product.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection
