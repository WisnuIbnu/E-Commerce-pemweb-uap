@extends('layouts.app')

@section('title', 'Beri Ulasan - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('transactions.show', $transaction->id) }}" class="inline-flex items-center gap-2 text-tumbloo-accent hover:text-tumbloo-accent-light mb-6 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Detail Transaksi
        </a>

        <h1 class="text-3xl font-bold text-tumbloo-white mb-8">Beri Ulasan Produk</h1>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-900/50 border border-red-500 rounded-lg text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Info -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <div class="flex gap-4">
                <div class="w-24 h-24 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                    @if($product->images->isNotEmpty())
                        <img src="{{ asset($product->images->first()->image) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-tumbloo-white mb-2">{{ $product->name }}</h2>
                    <p class="text-tumbloo-gray">{{ $product->store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-tumbloo-white mb-3">
                        Rating *
                    </label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" required class="hidden peer">
                                <svg class="w-12 h-12 text-tumbloo-gray peer-checked:text-yellow-400 hover:text-yellow-300 transition" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Review Text -->
                <div class="mb-6">
                    <label for="review" class="block text-sm font-medium text-tumbloo-white mb-2">
                        Ulasan Anda *
                    </label>
                    <textarea 
                        id="review" 
                        name="review" 
                        rows="6"
                        required
                        maxlength="1000"
                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light resize-none"
                        placeholder="Bagikan pengalaman Anda dengan produk ini..."
                    >{{ old('review') }}</textarea>
                    <div class="flex justify-between mt-2">
                        @error('review')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @else
                            <p class="text-sm text-tumbloo-gray">Ceritakan pengalaman Anda dengan detail</p>
                        @enderror
                        <p class="text-sm text-tumbloo-gray">
                            <span id="charCount">0</span>/1000
                        </p>
                    </div>
                </div>

                <!-- Review Tips -->
                <div class="mb-6 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent/30">
                    <h3 class="text-sm font-medium text-tumbloo-white mb-2">Tips Menulis Ulasan:</h3>
                    <ul class="space-y-1 text-xs text-tumbloo-gray">
                        <li>• Jelaskan kualitas produk dan kesesuaian dengan deskripsi</li>
                        <li>• Bagikan pengalaman pengiriman dan pelayanan toko</li>
                        <li>• Berikan masukan yang membangun untuk pembeli lain</li>
                        <li>• Hindari kata-kata kasar atau tidak pantas</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <a href="{{ route('transactions.show', $transaction->id) }}" 
                       class="flex-1 text-center bg-tumbloo-dark hover:bg-tumbloo-accent/20 text-tumbloo-white border border-tumbloo-accent font-semibold py-3 px-6 rounded-lg transition">
                        Batal
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105"
                    >
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="mt-6 p-4 bg-tumbloo-black/50 border border-tumbloo-accent/30 rounded-lg">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-tumbloo-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-xs text-tumbloo-gray">
                        Ulasan Anda akan membantu pembeli lain membuat keputusan yang lebih baik. Pastikan ulasan Anda jujur dan sesuai dengan pengalaman Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewTextarea = document.getElementById('review');
    const charCount = document.getElementById('charCount');
    
    if (reviewTextarea && charCount) {
        reviewTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
        
        // Set initial count
        charCount.textContent = reviewTextarea.value.length;
    }

    // Interactive star rating
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            // Update all previous stars
            ratingInputs.forEach((inp, i) => {
                const svg = inp.nextElementSibling;
                if (i <= index) {
                    svg.classList.remove('text-tumbloo-gray');
                    svg.classList.add('text-yellow-400');
                } else {
                    svg.classList.add('text-tumbloo-gray');
                    svg.classList.remove('text-yellow-400');
                }
            });
        });
    });
});
</script>
@endsection