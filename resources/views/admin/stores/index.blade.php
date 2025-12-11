<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Store Verification</h2>
    </x-slot>

    <div class="p-6">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">Owner</th>
                    <th class="p-3 border">Store Name</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td class="border p-3">{{ $store->user->name }}</td>
                        <td class="border p-3">{{ $store->name }}</td>
                        <td class="border p-3 capitalize">{{ $store->status }}</td>
                        <td class="border p-3">
                            @if ($store->status === 'pending')
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-500">Completed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
