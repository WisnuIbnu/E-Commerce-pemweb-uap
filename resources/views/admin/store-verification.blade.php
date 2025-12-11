@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Store Verification</h1>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pending Stores Table -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Store Verification</h3>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($stores as $store)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $store->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $store->user->email }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($store->description ?? 'No description', 50) }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.store.verify', $store->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3" onclick="return confirm('Verify this store?')">
                                    Verify
                                </button>
                            </form>
                            <form action="{{ route('admin.store.reject', $store->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Reject and delete this store?')">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No pending stores.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
