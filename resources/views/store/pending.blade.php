@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success fade-in mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="card p-10 text-center">
            <!-- Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-tumbloo-offwhite rounded-full mb-6">
                <svg class="w-10 h-10 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-tumbloo-black mb-3">Toko Sedang Diverifikasi</h1>
            <p class="text-tumbloo-gray mb-8">Terima kasih telah mendaftar! Kami sedang meninjau aplikasi toko Anda.</p>

            <!-- Store Info -->
            <div class="bg-tumbloo-offwhite rounded-lg p-6 mb-8 text-left">
                <h3 class="font-bold text-tumbloo-black mb-4">Informasi Toko</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-tumbloo-gray">Nama Toko:</span>
                        <span class="font-semibold text-tumbloo-black">{{ $store->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-tumbloo-gray">Kota:</span>
                        <span class="font-semibold text-tumbloo-black">{{ $store->city }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-tumbloo-gray">Status:</span>
                        <span class="badge badge-warning">Pending Verification</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-tumbloo-gray">Tanggal Daftar:</span>
                        <span class="font-semibold text-tumbloo-black">{{ $store->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-tumbloo-offwhite rounded-lg p-6 mb-8">
                <h3 class="font-bold text-tumbloo-black mb-4 text-left">Proses Verifikasi</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-tumbloo-black rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-tumbloo-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <p class="font-semibold text-tumbloo-black">Formulir Dikirim</p>
                            <p class="text-sm text-tumbloo-gray">Aplikasi toko Anda telah diterima</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-tumbloo-gray rounded-full flex items-center justify-center animate-pulse">
                                <svg class="w-5 h-5 text-tumbloo-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <p class="font-semibold text-tumbloo-black">Sedang Ditinjau</p>
                            <p class="text-sm text-tumbloo-gray">Admin sedang meninjau toko Anda</p>
                        </div>
                    </div>

                    <div class="flex items-start opacity-50">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-tumbloo-gray-light rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-tumbloo-gray" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <p class="font-semibold text-tumbloo-black">Toko Disetujui</p>
                            <p class="text-sm text-tumbloo-gray">Anda akan menerima notifikasi email</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}" class="btn-primary w-full">
                    Kembali ke Beranda
                </a>
                <p class="text-sm text-tumbloo-gray">
                    Verifikasi biasanya memakan waktu 1-3 hari kerja. Kami akan mengirim email setelah toko Anda disetujui.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection