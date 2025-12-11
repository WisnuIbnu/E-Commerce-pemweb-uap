@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Payment</h1>
            <div class="text-sm text-gray-500">Order Pay ID: {{ substr($transactions->first()->code ?? 'TRX', 0, 8) }}...</div>
        </div>

        <div class="p-8">
            {{-- Amount Section --}}
            <div class="text-center mb-8">
                <p class="text-sm text-gray-500 mb-1">Total Amount to Pay</p>
                <div class="text-4xl font-bold text-gray-900">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
            </div>

            {{-- VA Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-semibold text-blue-900">Virtual Account ({{ $bank }})</span>
                    <img src="{{ asset('icons/secure-payment.png') }}" class="h-6 opacity-50" onerror="this.style.display='none'">
                </div>
                <div class="flex items-center justify-between bg-white px-4 py-3 rounded-lg border border-blue-100">
                    <span class="text-xl font-mono font-bold text-gray-800 tracking-wider">{{ $vaNumber }}</span>
                    <button onclick="navigator.clipboard.writeText('{{ $vaNumber }}'); alert('Copied!');" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Copy
                    </button>
                </div>
                <p class="text-xs text-blue-600 mt-2">*Automatic verification. Complete payment within 24 hours.</p>
            </div>

            {{-- Transactions Breakdown --}}
            <div class="border-t pt-6 mb-8">
                <h3 class="font-semibold mb-4">Transaction Details</h3>
                @foreach($transactions as $trx)
                    <div class="flex justify-between items-center text-sm mb-2 text-gray-600">
                        <span>{{ $trx->code }} ({{ $trx->transactionDetails->count() }} items)</span>
                        <span>Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Pay Button --}}
            <form action="{{ route('checkout.pay') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="transaction_ids" value="{{ implode(',', $ids) }}">
                <button type="button" onclick="confirmPayment()" class="w-full bg-black text-white py-4 rounded-xl font-bold text-lg hover:bg-gray-800 transform hover:-translate-y-1 transition shadow-lg">
                    Pay Now
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmPayment() {
        Swal.fire({
            title: 'Processing Payment',
            text: 'Simulating payment gateway...',
            icon: 'info',
            timer: 1500,
            showConfirmButton: false,
            willClose: () => {
                Swal.fire({
                    title: 'Payment Successful!',
                    text: 'Your order has been paid successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#000000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('payment-form').submit();
                    }
                });
            }
        });
    }
</script>
@endsection
