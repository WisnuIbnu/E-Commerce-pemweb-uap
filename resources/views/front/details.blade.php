@extends('layouts.front')

@section('title', $product->name)

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="bg-white rounded-2xl shadow-lg shadow-indigo-50/50 border border-slate-100 p-6 md:p-8 relative overflow-hidden">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12" 
             x-data="{ activeImage: '{{ asset('storage/' . $product->thumbnail) }}' }">
            
            <div class="space-y-4">
                <div class="bg-slate-50 rounded-xl border border-slate-100 overflow-hidden aspect-square flex items-center justify-center relative">
                    <img :src="activeImage" alt="{{ $product->name }}" 
                         class="max-w-[85%] max-h-[85%] object-contain transition-opacity duration-300 ease-in-out"
                         x-transition:enter="opacity-0"
                         x-transition:enter-end="opacity-100">
                </div>

                <div class="flex gap-3 overflow-x-auto hide-scroll py-1 justify-center md:justify-start">
                    <button @click="activeImage = '{{ asset('storage/' . $product->thumbnail) }}'" 
                            class="flex-shrink-0 w-20 h-20 rounded-lg border-2 overflow-hidden bg-slate-50 transition-colors duration-200"
                            :class="activeImage === '{{ asset('storage/' . $product->thumbnail) }}' 
                                ? 'border-primary ring-2 ring-primary/10' 
                                : 'border-slate-100 hover:border-slate-300'">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover p-1">
                    </button>

                    @foreach($product->productImages as $img)
                        @if($img->image !== $product->thumbnail) 
                            <button @click="activeImage = '{{ asset('storage/' . $img->image) }}'" 
                                    class="flex-shrink-0 w-20 h-20 rounded-lg border-2 overflow-hidden bg-slate-50 transition-colors duration-200"
                                    :class="activeImage === '{{ asset('storage/' . $img->image) }}' 
                                        ? 'border-primary ring-2 ring-primary/10' 
                                        : 'border-slate-100 hover:border-slate-300'">
                                <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover p-1">
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col h-full py-1">
                
                <div class="mb-6">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-[10px] font-bold text-primary uppercase tracking-widest mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        {{ $product->productCategory->name ?? 'Umum' }}
                    </div>
                    
                    <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-5">
                        <div class="bg-gradient-to-br from-primary to-purple-600 text-white w-9 h-9 rounded-lg flex items-center justify-center shadow-md shadow-primary/30">
                            <i class="fa-solid fa-bag-shopping text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Official Store</p>
                            <p class="text-sm font-bold text-slate-800">{{ $product->store->name ?? 'Toko' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Harga Spesial</p>
                    <div class="text-3xl md:text-4xl font-black text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="p-3 rounded-xl border border-slate-100 text-center bg-slate-50/50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kondisi</p>
                        <p class="text-sm font-bold text-slate-900 capitalize">{{ $product->condition ?? 'Baru' }}</p>
                    </div>
                    <div class="p-3 rounded-xl border border-slate-100 text-center bg-slate-50/50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Berat</p>
                        <p class="text-sm font-bold text-slate-900">{{ $product->weight ?? 0 }} gr</p>
                    </div>
                    <div class="p-3 rounded-xl border border-slate-100 text-center bg-slate-50/50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stok</p>
                        <p class="text-sm font-bold text-slate-900">{{ $product->stock ?? 0 }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-base font-bold text-slate-900 mb-2">Deskripsi Produk</h3>
                    <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed text-sm">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <div class="mt-auto grid grid-cols-2 gap-3">
                    @auth
                        <form action="{{ route('carts.store', $product->slug) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full px-5 py-3 rounded-xl font-bold text-slate-700 border-2 border-slate-200 hover:border-primary hover:text-primary bg-white transition-colors duration-200 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> 
                                <span>Keranjang</span>
                            </button>
                        </form>
                        
                        <button class="px-5 py-3 rounded-xl font-bold text-white bg-primary hover:bg-primary-dark shadow-lg shadow-indigo-500/30 transition-colors duration-200 flex items-center justify-center gap-2">
                            <span>Beli Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl font-bold text-slate-700 border-2 border-slate-200 hover:border-primary hover:text-primary bg-white transition-colors duration-200 flex items-center justify-center gap-2 text-center">
                            <i class="fa-solid fa-cart-plus"></i> 
                            <span>Keranjang</span>
                        </a>
                        
                        <<a href="{{ route('front.checkout', $product->slug) }}" class="px-5 py-3 rounded-xl font-bold text-white bg-primary hover:bg-primary-dark shadow-lg shadow-indigo-500/30 transition-colors duration-200 flex items-center justify-center gap-2 text-center">
                            <span>Beli Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <h3 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-2">
                <i class="fa-solid fa-star text-yellow-400"></i>
                Ulasan Pelanggan ({{ $product->productReviews->count() }})
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-1">
                    @auth
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 sticky top-24">
                            <h4 class="font-bold text-slate-800 mb-4">Tulis Ulasan Anda</h4>
                            
                            @if(session('success'))
                                <div class="mb-4 p-3 bg-green-100 text-green-700 text-xs rounded-lg font-bold">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('product.review.store', $product->slug) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Rating</label>
                                    <div class="flex flex-row-reverse justify-end gap-1 group w-max">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                                            <label for="star{{$i}}" class="cursor-pointer text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors text-xl">
                                                <i class="fa-solid fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="comment" class="block text-xs font-bold text-slate-500 uppercase mb-2">Komentar</label>
                                    <textarea name="comment" id="comment" rows="4" class="w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary text-sm bg-white" placeholder="Bagaimana kualitas produk ini?" required></textarea>
                                </div>

                                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-4 rounded-full transition-colors shadow-lg shadow-indigo-500/20 text-sm">
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 text-center">
                            <i class="fa-solid fa-lock text-primary text-2xl mb-3"></i>
                            <p class="text-sm text-slate-600 mb-4">Silakan login untuk memberikan ulasan.</p>
                            <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-700 hover:border-primary hover:text-primary transition-colors">
                                Masuk Akun
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="lg:col-span-2">
                    @if($product->productReviews->count() > 0)
                        <div class="space-y-8">
                            @foreach($product->productReviews as $review)
                                <div class="flex gap-4 pb-8 border-b border-slate-100 last:border-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-white border border-indigo-50 flex items-center justify-center text-primary font-bold shadow-sm">
                                            {{ substr($review->user->name ?? 'A', 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-1">
                                            <h5 class="font-bold text-slate-800 text-sm">{{ $review->user->name ?? 'Pengguna' }}</h5>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex text-yellow-400 text-[10px] mb-3 gap-0.5">
                                            @for($j = 1; $j <= 5; $j++)
                                                @if($j <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-slate-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-4 rounded-xl rounded-tl-none border border-slate-100">
                                            {{ $review->comment }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center border-2 border-dashed border-slate-100 rounded-xl bg-slate-50/50">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white text-slate-300 mb-4 shadow-sm">
                                <i class="fa-regular fa-comment-dots text-2xl"></i>
                            </div>
                            <p class="text-slate-900 font-bold mb-1">Belum ada ulasan</p>
                            <p class="text-xs text-slate-500">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="mt-8 flex justify-start">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-slate-700 transition-colors bg-white border-2 border-slate-200 hover:border-primary hover:text-primary rounded-xl shadow-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> 
            Kembali ke Katalog
        </a>
    </div>

</div>

@endsection