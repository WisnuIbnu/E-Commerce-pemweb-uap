<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lunpia-dark leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-6 gap-6">

            {{-- Sidebar --}}
            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            {{-- Content --}}
            <div class="md:col-span-5">
                
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-lunpia-dark">All Users</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">ID</th>
                                    <th class="p-3 text-left">Name</th>
                                    <th class="p-3 text-left">Email</th>
                                    <th class="p-3 text-left">Role</th>
                                    <th class="p-3 text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                <tr class="border-t">
                                    <td class="p-3">{{ $user->id }}</td>
                                    <td class="p-3">{{ $user->name }}</td>
                                    <td class="p-3">{{ $user->email }}</td>
                                    <td class="p-3">{{ $user->role }}</td>
                                    <td class="p-3 text-center">
                                        <button class="px-3 py-1 bg-lunpia-red text-white rounded-md hover:bg-red-600">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>