@extends('layouts.front')

@section('title', $product->name)

@section('content')

<div class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-900 line-clamp-1">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
    x-data="{ 
        activeImage: '{{ asset('storage/' . $product->thumbnail) }}',
        quantity: 1, 
        selectedColor: null, 
        selectedSize: null,
        price: {{ $product->price }},
        stock: {{ $product->stock }},
        variants: {{ $product->variants->toJson() }},
        showVariantAlert: false, 
        
        addToCart() {
            if (this.variants.length > 0 && (!this.selectedColor || !this.selectedSize)) {
                this.showVariantAlert = true;
                setTimeout(() => this.showVariantAlert = false, 3000); 
                return;
            }
            this.$refs.cartForm.submit();
        }
    }"
    x-effect="
        if(variants.length > 0 && selectedColor && selectedSize) {
            const variant = variants.find(v => v.color === selectedColor && v.size === selectedSize);
            if(variant) {
                price = variant.price || {{ $product->price }};
                stock = variant.stock;
            }
        }
    ">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <div class="lg:col-span-7 flex flex-col gap-6">
            <div class="w-full aspect-[4/3] bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden relative flex items-center justify-center group">
                <img :src="activeImage" alt="{{ $product->name }}" 
                     class="max-w-[85%] max-h-[85%] object-contain transition-transform duration-500 group-hover:scale-105">
                
                @if($product->condition)
                <div class="absolute top-5 left-5 px-4 py-2 bg-white/90 backdrop-blur border border-slate-100 rounded-full text-xs font-bold text-slate-900 shadow-sm uppercase tracking-wide">
                    {{ $product->condition }}
                </div>
                @endif
            </div>

            <div class="flex gap-4 overflow-x-auto py-4 hide-scroll px-1">
                <button @click="activeImage = '{{ asset('storage/' . $product->thumbnail) }}'" 
                        class="w-24 h-24 flex-shrink-0 rounded-2xl border-2 overflow-hidden bg-white shadow-sm transition-all duration-300"
                        :class="activeImage === '{{ asset('storage/' . $product->thumbnail) }}' ? 'border-primary ring-2 ring-primary/20 -translate-y-1 shadow-md' : 'border-slate-100 hover:border-slate-300'">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover p-2">
                </button>

                @foreach($product->productImages as $img)
                    @if($img->image !== $product->thumbnail)
                    <button @click="activeImage = '{{ asset('storage/' . $img->image) }}'" 
                            class="w-24 h-24 flex-shrink-0 rounded-2xl border-2 overflow-hidden bg-white shadow-sm transition-all duration-300"
                            :class="activeImage === '{{ asset('storage/' . $img->image) }}' ? 'border-primary ring-2 ring-primary/20 -translate-y-1 shadow-md' : 'border-slate-100 hover:border-slate-300'">
                        <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover p-2">
                    </button>
                    @endif
                @endforeach
            </div>

            <div class="hidden lg:block mt-8">
                <h3 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-200 pb-4">Deskripsi Produk</h3>
                <div class="prose prose-slate text-slate-600 leading-relaxed max-w-none">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-2xl shadow-slate-200/50">
                
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-primary text-xs font-bold uppercase tracking-wider">
                        {{ $product->productCategory->name ?? 'Umum' }}
                    </span>
                    <div class="flex items-center gap-1 text-yellow-400 text-sm">
                        <i class="fa-solid fa-star"></i>
                        <span class="font-bold text-slate-900 ml-1">4.8</span>
                        <span class="text-slate-400 text-xs">(120 Ulasan)</span>
                    </div>
                </div>

                <h1 class="text-3xl font-extrabold text-slate-900 leading-tight mb-2">
                    {{ $product->name }}
                </h1>

                <div class="flex items-center gap-2 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-xs">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">{{ $product->store->name ?? 'Official Store' }}</span>
                </div>

                <div class="mb-8">
                    <p class="text-sm text-slate-400 font-medium mb-1">Harga Terbaik</p>
                    <div class="text-4xl font-black text-slate-900 flex items-start gap-1">
                        <span class="text-lg font-bold text-primary mt-1">Rp</span>
                        <span x-text="new Intl.NumberFormat('id-ID').format(price)">{{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($product->variants->count() > 0)
                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-3">Pilih Warna</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->variants->unique('color') as $variant)
                                @if($variant->color)
                                <button @click="selectedColor = '{{ $variant->color }}'; showVariantAlert = false"
                                        class="group relative px-5 py-2.5 rounded-xl border-2 text-sm font-bold transition-all duration-200 ease-out"
                                        :class="selectedColor === '{{ $variant->color }}' 
                                            ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 transform scale-105' 
                                            : 'border-slate-100 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                    {{ $variant->color }}
                                </button>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-3">Pilih Ukuran</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->variants->unique('size') as $variant)
                                @if($variant->size)
                                <button @click="selectedSize = '{{ $variant->size }}'; showVariantAlert = false"
                                        class="group relative h-12 min-w-[3.5rem] px-4 rounded-xl border-2 text-sm font-bold flex items-center justify-center transition-all duration-200 ease-out"
                                        :class="selectedSize === '{{ $variant->size }}' 
                                            ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 transform scale-105' 
                                            : 'border-slate-100 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                    {{ $variant->size }}
                                </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <div class="mb-8 p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</span>
                        <span class="text-xs text-slate-400 mt-0.5">Stok: <span x-text="stock" class="font-bold text-slate-700"></span></span>
                    </div>
                    <div class="flex items-center gap-3 bg-white rounded-xl px-2 py-1 shadow-sm border border-slate-100">
                        <button @click="if(quantity > 1) quantity--" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:bg-indigo-50 transition-colors">
                            <i class="fa-solid fa-minus text-xs"></i>
                        </button>
                        <input type="number" x-model="quantity" class="w-10 text-center border-none p-0 text-slate-900 font-bold focus:ring-0" readonly>
                        <button @click="if(quantity < stock) quantity++" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:bg-indigo-50 transition-colors">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <div x-show="showVariantAlert" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mb-4 p-3 rounded-xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-600">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    <span class="text-sm font-bold">Mohon pilih varian (warna/ukuran) terlebih dahulu.</span>
                </div>

                <div class="flex flex-col gap-3">
                    @auth
                        <div class="grid grid-cols-5 gap-3">
                            <form x-ref="cartForm" action="{{ route('carts.store', $product->slug) }}" method="POST" class="col-span-1 w-full">
                                @csrf
                                <input type="hidden" name="quantity" :value="quantity">
                                <input type="hidden" name="color" :value="selectedColor">
                                <input type="hidden" name="size" :value="selectedSize">
                                
                                <button type="button" @click="addToCart()"
                                        class="w-full h-[56px] rounded-2xl border-2 border-slate-200 text-slate-600 bg-white hover:border-primary hover:text-primary hover:bg-indigo-50 transition-all flex items-center justify-center group relative">
                                    <i class="fa-solid fa-cart-shopping text-xl group-hover:scale-110 transition-transform"></i>
                                </button>
                            </form>
                            
                            <a href="{{ route('front.checkout', $product->slug) }}" 
                               class="col-span-4 h-[56px] rounded-2xl font-bold text-white bg-primary hover:bg-primary-dark shadow-xl shadow-primary/30 hover:shadow-primary/50 transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                                Beli Sekarang
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}" class="h-[52px] rounded-2xl font-bold text-slate-700 border-2 border-slate-200 bg-white hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> Keranjang
                            </a>
                            <a href="{{ route('login') }}" class="h-[52px] rounded-2xl font-bold text-white bg-primary hover:bg-primary-dark shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2">
                                Beli Sekarang
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>

        <div class="lg:hidden mt-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-200 pb-4">Deskripsi Produk</h3>
            <div class="prose prose-slate text-slate-600 leading-relaxed max-w-none">
                <p>{{ $product->description }}</p>
            </div>
        </div>

    </div>

    <div class="mt-24">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Ulasan Pelanggan</h2>
                <div class="flex items-center justify-center gap-3">
                    <div class="flex text-yellow-400 text-xl">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="text-lg font-bold text-slate-700">4.8 <span class="text-slate-400 font-normal">/ 5.0</span></span>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                    
                    <div class="p-8 bg-slate-50 md:col-span-1">
                        <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i class="fa-regular fa-pen-to-square"></i> Tulis Ulasan
                        </h3>
                        @auth
                            <form action="{{ route('product.review.store', $product->slug) }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Rating</label>
                                    <div class="flex flex-row-reverse justify-end gap-2 group w-max p-3 bg-white rounded-2xl border-2 border-slate-300 shadow-sm hover:border-primary transition-colors">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                                            <label for="star{{$i}}" class="cursor-pointer text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors text-2xl">
                                                <i class="fa-solid fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Komentar</label>
                                    <textarea name="comment" rows="4" 
                                        class="w-full rounded-2xl border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm placeholder-slate-400 transition-all p-4" 
                                        placeholder="Bagaimana kualitas produk ini?" required></textarea>
                                </div>
                                <button type="submit" class="w-full py-3.5 rounded-xl bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 transform hover:-translate-y-0.5">
                                    Kirim Ulasan
                                </button>
                            </form>
                        @else
                            <div class="text-center py-10 flex flex-col items-center justify-center h-full">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-primary mb-3">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <p class="text-sm text-slate-600 mb-4 font-medium">Login untuk memberikan ulasan.</p>
                                <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 rounded-full border-2 border-primary text-primary font-bold text-sm hover:bg-primary hover:text-white transition-colors">
                                    Masuk Akun
                                </a>
                            </div>
                        @endauth
                    </div>

                    <div class="p-8 md:col-span-2 space-y-8 bg-white">
                        @forelse($product->productReviews as $review)
                            <div class="flex gap-5 group">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-50 border border-indigo-100 flex items-center justify-center text-primary font-bold shadow-sm text-lg">
                                        {{ substr($review->user->name ?? 'A', 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm">{{ $review->user->name ?? 'Pengguna' }}</h4>
                                            <div class="flex text-yellow-400 text-xs mt-1">
                                                @for($j = 1; $j <= 5; $j++)
                                                    <i class="{{ $j <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50 px-2 py-1 rounded-md">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl rounded-tl-none border border-slate-100 group-hover:border-primary/20 transition-colors">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center h-full text-center py-10 opacity-60">
                                <img src="https://illustrations.popsy.co/gray/surr-feedback.svg" alt="No Reviews" class="w-32 h-32 mb-4 opacity-50 grayscale">
                                <p class="text-slate-500 font-medium">Belum ada ulasan untuk produk ini.</p>
                                <p class="text-sm text-slate-400">Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>

@endsection