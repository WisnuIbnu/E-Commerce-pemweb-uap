@extends('layouts.app')

@section('title', 'Menunggu Verifikasi - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="bg-green-500 bg-opacity-10 border-l-4 border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6 animate-fadeIn">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-8 md:p-12 text-center">
            
            <div class="w-24 h-24 mx-auto mb-6 bg-yellow-500 bg-opacity-20 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-yellow-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-tumbloo-white mb-4">
                Toko Anda Sedang Diverifikasi
            </h1>

            <p class="text-tumbloo-gray text-lg mb-8 max-w-2xl mx-auto">
                Terima kasih telah mendaftar sebagai seller di Tumbloo! Tim kami sedang meninjau informasi toko Anda. 
                Proses verifikasi biasanya memakan waktu <span class="text-tumbloo-white font-semibold">1-3 hari kerja</span>.
            </p>
            <div class="bg-tumbloo-dark border border-tumbloo-accent rounded-lg p-6 mb-8 max-w-xl mx-auto">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-tumbloo-black border border-tumbloo-accent flex-shrink-0">
                        @if($store->logo)
                            <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="text-left flex-1">
                        <h3 class="text-lg font-semibold text-tumbloo-white mb-1">{{ $store->name }}</h3>
                        <div class="space-y-1 text-sm text-tumbloo-gray">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $store->city }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $store->phone }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Didaftarkan {{ $store->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-500 bg-opacity-10 border border-yellow-500 rounded-full text-yellow-400 font-semibold mb-8">
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Status: Menunggu Verifikasi
            </div>

            <!-- What's Next Section -->
            <div class="text-left bg-tumbloo-dark border border-tumbloo-accent rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-tumbloo-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-tumbloo-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Apa yang Terjadi Selanjutnya?
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-tumbloo-accent bg-opacity-30 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs text-tumbloo-white font-semibold">1</span>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Tinjauan Tim Tumbloo</div>
                            <div class="text-sm text-tumbloo-gray">Tim kami akan meninjau informasi toko, dokumen, dan kelengkapan data Anda</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-tumbloo-accent bg-opacity-30 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs text-tumbloo-white font-semibold">2</span>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Notifikasi Email</div>
                            <div class="text-sm text-tumbloo-gray">Anda akan menerima email notifikasi mengenai status verifikasi toko</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-tumbloo-accent bg-opacity-30 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs text-tumbloo-white font-semibold">3</span>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Mulai Berjualan</div>
                            <div class="text-sm text-tumbloo-gray">Setelah disetujui, Anda dapat langsung menambahkan produk dan mulai berjualan</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" 
                   class="px-8 py-3 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('support') }}" 
                   class="px-8 py-3 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-white border border-tumbloo-accent font-semibold rounded-lg transition">
                    Hubungi Support
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            
            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-tumbloo-white mb-2">Tips Sementara Menunggu</h3>
                        <ul class="space-y-2 text-sm text-tumbloo-gray">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Siapkan foto produk berkualitas tinggi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Buat deskripsi produk yang menarik</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Baca panduan seller kami</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-tumbloo-white mb-2">Butuh Bantuan?</h3>
                        <p class="text-sm text-tumbloo-gray mb-3">
                            Jika ada pertanyaan atau masalah, tim support kami siap membantu Anda.
                        </p>
                        <a href="{{ route('support') }}" class="inline-flex items-center gap-2 text-sm text-tumbloo-accent hover:text-tumbloo-accent-light transition font-medium">
                            <span>Hubungi Support</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endpush
@endsection