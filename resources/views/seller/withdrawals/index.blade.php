<x-app-layout>

    {{-- HEADER GRADIENT (lebarnya sama) --}}
    <div class="bg-gray-900 pt-6">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-blue-700 to-blue-500 py-8 shadow-xl">
                <div class="relative px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">💸</span>
                        <h2 class="text-2xl font-semibold text-white">
                            Withdrawal Center
                        </h2>
                    </div>
                    <p class="text-sm text-blue-100 mt-2">
                        Manage your store balance and request withdrawals easily.
                    </p>
                </div>

                <div class="pointer-events-none absolute top-3 right-6 w-32 h-32 bg-blue-300 bg-opacity-20 rounded-full blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-6 left-0 w-40 h-40 bg-white bg-opacity-10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="py-10 bg-gray-900 min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">

            {{-- WELCOME BOX --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-100">
                    Your Store Balance & Withdrawals
                </h3>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Cek saldo toko dan ajukan permintaan penarikan dana dengan aman.
                </p>
            </div>

            {{-- ALERTS --}}
            @if(session('success'))
                <div class="bg-green-500 bg-opacity-20 text-green-200 border border-green-400 p-3 rounded-xl shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500 bg-opacity-20 text-red-200 border border-red-400 p-3 rounded-xl shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- BALANCE INFO --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <p class="text-sm font-semibold text-gray-300">Current Balance</p>
                <p class="text-3xl md:text-4xl font-bold text-blue-300 mt-2">
                    {{ number_format($storeBalance->amount ?? 0, 0, ',', '.') }} IDR
                </p>
            </div>

            {{-- WITHDRAWAL FORM --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <h4 class="text-xl font-bold text-gray-100 mb-4">Request Withdrawal</h4>
                <form action="{{ route('seller.withdraw.request') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-200">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                               class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 rounded w-full p-2 focus:outline-none focus:border-blue-400"
                               required>
                        @error('bank_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-200">Account Name</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}"
                               class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 rounded w-full p-2 focus:outline-none focus:border-blue-400"
                               required>
                        @error('bank_account_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-200">Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}"
                               class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 rounded w-full p-2 focus:outline-none focus:border-blue-400"
                               required>
                        @error('bank_account_number')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-200">Amount</label>
                        <input type="number" name="amount" value="{{ old('amount') }}"
                               class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 rounded w-full p-2 focus:outline-none focus:border-blue-400"
                               required>
                        @error('amount')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-400 text-white px-6 py-2 rounded-lg shadow transition-colors text-sm font-semibold">
                        Submit Withdrawal
                    </button>
                </form>
            </div>

            {{-- WITHDRAWAL HISTORY --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <h4 class="text-xl font-bold text-gray-100 mb-4">Withdrawal History</h4>

                @if($withdrawals->isEmpty())
                    <p class="text-gray-400">No withdrawals yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-200">
                            <thead class="bg-gray-900 border-b border-gray-800 text-xs uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Bank</th>
                                    <th class="px-4 py-2">Account Name</th>
                                    <th class="px-4 py-2">Account Number</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $w)
                                    <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-2 text-gray-100">
                                            {{ number_format($w->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-200">{{ $w->bank_name }}</td>
                                        <td class="px-4 py-2 text-gray-200">{{ $w->bank_account_name }}</td>
                                        <td class="px-4 py-2 text-gray-200">{{ $w->bank_account_number }}</td>
                                        <td class="px-4 py-2 capitalize">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($w->status === 'pending') bg-yellow-400 text-gray-900
                                                @elseif($w->status === 'approved') bg-green-500 text-white
                                                @else bg-red-500 text-white @endif">
                                                {{ $w->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-gray-300">
                                            {{ $w->created_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-app-layout>
