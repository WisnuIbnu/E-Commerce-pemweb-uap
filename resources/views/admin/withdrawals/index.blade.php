@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Withdrawal Management</h1>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Withdrawal Requests Table -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank Info</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $withdrawal->storeBalance->store->name }}</div>
                            <div class="text-sm text-gray-500">{{ $withdrawal->storeBalance->store->user->name }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900">{{ $withdrawal->bank_name }}</div>
                            <div class="text-sm text-gray-500">{{ $withdrawal->bank_account_number }}</div>
                            <div class="text-sm text-gray-500">{{ $withdrawal->bank_account_name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $withdrawal->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            @if($withdrawal->status === 'pending')
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-3" onclick="return confirm('Approve this withdrawal?')">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Reject this withdrawal?')">
                                        Reject
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No withdrawal requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
@endsection
