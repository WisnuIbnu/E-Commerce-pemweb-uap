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
                            <span class="breadcrumb-current">Balance</span>
                        </div>
                    </div>
                    
                    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">💰 Store Balance</h1>
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #6b7280;">Track your earnings and balance history</p>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    
                    <!-- Balance Summary Cards -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        
                        <div class="p-6 rounded-lg shadow text-white" style="background: linear-gradient(135deg, #984216 0%, #7a3412 100%);">
                            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 10px;">💳 Available Balance</div>
                            <div style="font-size: 32px; font-weight: bold; margin-bottom: 5px;">
                                Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 12px; opacity: 0.8;">Ready to withdraw</div>
                        </div>

                        <div class="p-6 bg-white rounded-lg shadow">
                            <div style="font-size: 14px; color: #6b7280; margin-bottom: 10px;">📊 Total Earned</div>
                            <div style="font-size: 32px; font-weight: bold; color: #10b981; margin-bottom: 5px;">
                                Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 12px; color: #9ca3af;">All time earnings</div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="p-5 bg-white rounded-lg shadow flex justify-between items-center">
                        <div>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 5px;">Ready to withdraw?</div>
                            <div style="font-size: 13px; color: #6b7280;">Request withdrawal to your bank account</div>
                        </div>
                        <a href="{{ route('store.withdrawal') }}" 
                           class="px-6 py-3 text-white rounded-lg font-medium"
                           style="background-color: #984216;">
                            Withdraw Now →
                        </a>
                    </div>

                    <!-- Balance History -->
                    <div class="p-6 bg-white rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction History</h2>
                        
                        @if($histories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Date</th>
                                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Type</th>
                                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Description</th>
                                        <th class="text-right py-3 px-2 text-sm font-semibold text-gray-600">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($histories as $history)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 px-2 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-3 px-2">
                                            @if($history->type == 'income')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">💰 Income</span>
                                            @elseif($history->type == 'withdrawal')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">💸 Withdrawal</span>
                                            @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">📝 Other</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-2 text-sm text-gray-800">
                                            {{ $history->notes ?? 'Transaction' }}
                                        </td>
                                        <td class="py-3 px-2 text-sm font-semibold text-right {{ $history->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $history->type == 'income' ? '+' : '-' }} Rp {{ number_format($history->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $histories->links() }}
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div style="font-size: 60px; margin-bottom: 20px;">📊</div>
                            <div style="font-size: 18px; color: #6b7280;">No transaction history yet</div>
                            <div style="font-size: 14px; color: #9ca3af; margin-top: 10px;">Your balance activities will appear here</div>
                        </div>
                        @endif
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