<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Members</h3>

                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border">ID</th>
                                <th class="p-3 border">Name</th>
                                <th class="p-3 border">Email</th>
                                <th class="p-3 border">Status</th>
                                <th class="p-3 border">Created At</th>
                                <th class="p-3 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border p-3">{{ $user->id }}</td>
                                    <td class="border p-3">{{ $user->name }}</td>
                                    <td class="border p-3">{{ $user->email }}</td>
                                    <td class="border p-3 capitalize">{{ $user->status }}</td>
                                    <td class="border p-3">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="border p-3">
                                        <form action="{{ route('dashboard.updateStatus', $user->id) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <select name="status" class="border rounded px-2 py-1">
                                                <option value="admin" {{ $user->status === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="seller" {{ $user->status === 'seller' ? 'selected' : '' }}>Seller</option>
                                                <option value="buyer" {{ $user->status === 'buyer' ? 'selected' : '' }}>Buyer</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(session('success'))
                        <div class="mt-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
