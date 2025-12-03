<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Manage Sellers</h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-8xl mx-auto sm:px-10 lg:px-10 grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            <div class="md:col-span-5">
                <div class="bg-white p-4 rounded-xl shadow">
                    <table class="w-full">
                        <thead class="bg-lunpia-peach">
                            <tr>
                                <th class="p-3 text-left">Store Name</th>
                                <th class="p-3 text-left">Owner</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Verified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sellers as $seller)
                                <tr class="border-b">
                                    <td class="p-3">{{ $seller->store_name ?? '-' }}</td>
                                    <td class="p-3">{{ $seller->name }}</td>
                                    <td class="p-3">{{ $seller->email }}</td>
                                    <td class="p-3">{{ $seller->is_verified ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $sellers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
