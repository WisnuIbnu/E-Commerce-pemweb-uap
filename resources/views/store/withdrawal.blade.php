<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        @include('profile.partials.navbar')

        <div class="flex-1">
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="breadcrumb-wrapper mb-4">
                        <div class="breadcrumb-container">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">›</span>
                            <a href="{{ route('store.dashboard') }}" class="breadcrumb-link">Dashboard</a>
                            <span class="breadcrumb-separator">›</span>
                            <span class="breadcrumb-current">Withdrawal</span>
                        </div>
                    </div>
                    
                    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">💸 Withdrawal</h1>
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #6b7280;">Request withdrawal to your bank account</p>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    
                    @if(session('success'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        ✓ {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                        ✗ {{ session('error') }}
                    </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        
                        <!-- Withdrawal Form -->
                        <div class="p-6 bg-white rounded-lg shadow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Request Withdrawal</h2>
                            
                            <!-- Available Balance -->
                            <div class="p-5 rounded-lg text-white mb-6" style="background: linear-gradient(135deg, #984216 0%, #7a3412 100%);">
                                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 8px;">Available Balance</div>
                                <div style="font-size: 28px; font-weight: bold;">
                                    Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('store.withdrawal.submit') }}">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bank Name *</label>
                                    <input type="text" name="bank_name" required placeholder="e.g., Bank BCA" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Name *</label>
                                    <input type="text" name="account_name" required placeholder="Your name as per bank account" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Number *</label>
                                    <input type="text" name="account_number" required placeholder="1234567890" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount *</label>
                                    <input type="number" name="amount" required min="10000" placeholder="Minimum Rp 10.000" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                                    <div class="text-xs text-gray-500 mt-1">Minimum withdrawal: Rp 10.000</div>
                                </div>

                                <button type="submit" class="w-full py-3 text-white rounded-lg font-semibold" style="background-color: #984216;">
                                    Submit Withdrawal Request
                                </button>
                            </form>
                        </div>

                        <!-- Withdrawal History -->
                        <div class="p-6 bg-white rounded-lg shadow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Withdrawal History</h2>
                            
                            @if($withdrawals->count() > 0)
                            <div style="max-height: 600px; overflow-y: auto;">
                                @foreach($withdrawals as $withdrawal)
                                <div class="border border-gray-200 rounded-lg p-4 mb-3">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <div class="text-lg font-bold text-gray-800 mb-1">
                                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                        @if($withdrawal->status == 'approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">✓ Approved</span>
                                        @elseif($withdrawal->status == 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">✗ Rejected</span>
                                        @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">⏳ Pending</span>
                                        @endif
                                    </div>
                                    
                                    <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-700">
                                        <div class="mb-1"><strong>Bank:</strong> {{ $withdrawal->bank_name ?? 'N/A' }}</div>
                                        <div class="mb-1"><strong>Account:</strong> {{ $withdrawal->account_holder ?? $withdrawal->account_name ?? 'N/A' }}</div>
                                        <div><strong>Number:</strong> {{ $withdrawal->account_number ?? 'N/A' }}</div>
                                    </div>

                                    @if(!empty($withdrawal->notes))
                                    <div class="mt-2 p-2 bg-yellow-50 rounded text-xs text-yellow-800">
                                        <strong>Note:</strong> {{ $withdrawal->notes }}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $withdrawals->links() }}
                            </div>
                            @else
                            <div class="text-center py-12">
                                <div style="font-size: 60px; margin-bottom: 20px;">💸</div>
                                <div style="font-size: 18px; color: #6b7280;">No withdrawal history</div>
                                <div style="font-size: 14px; color: #9ca3af; margin-top: 10px;">Your withdrawal requests will appear here</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Information Box -->
                    <div class="p-5 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-base font-semibold text-blue-900 mb-3">ℹ️ Withdrawal Information</h3>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li>• Minimum withdrawal amount is Rp 10.000</li>
                            <li>• Withdrawal requests are processed within 1-3 business days</li>
                            <li>• Make sure your bank account information is correct</li>
                            <li>• You will receive a notification once your withdrawal is processed</li>
                            <li>• Contact support if you have any questions about your withdrawal</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .breadcrumb-wrapper { margin-bottom: 1rem; }
        .breadcrumb-container { display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; }
        .breadcrumb-link { color:#984216; text-decoration:none; transition:color .2s; }
        .breadcrumb-link:hover { color:#7a3412; text-decoration:underline; }
        .breadcrumb-separator { color:#9ca3af; font-size:1rem; }
        .breadcrumb-current { color:#6b7280; font-weight:500; }
    </style>
</x-app-layout>