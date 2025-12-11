<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 px-6 py-8 shadow-xl">
            <div class="relative z-10 flex flex-col gap-3">
                <div class="inline-flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-2xl">
                        🏷️
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-blue-100">
                            Seller Dashboard
                        </p>
                        <h2 class="font-semibold text-2xl md:text-3xl text-white">
                            Manage Categories
                        </h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-blue-100 max-w-2xl">
                    Kelola kategori produk toko kamu untuk mengatur katalog dengan rapi.
                </p>
            </div>

            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-300/30 blur-3xl"></div>
            <div class="pointer-events-none absolute left-10 -bottom-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
        </div>
    </x-slot>

    {{-- MAIN CONTENT --}}
    <div class="bg-gray-900 min-h-screen text-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-400 text-green-100 px-4 py-2 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-400 text-red-100 px-4 py-2 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-100">
                    Category List
                </h3>
                <a href="{{ route('categories.create') }}"
                   class="inline-flex items-center bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
                    + Add Category
                </a>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-800 text-gray-300 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Slug</th>
                            <th class="px-4 py-2">Created</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-t border-gray-800 hover:bg-gray-800/60">
                                <td class="px-4 py-2 text-gray-100">
                                    {{ $category->name }}
                                </td>
                                <td class="px-4 py-2 text-gray-400">
                                    {{ $category->slug }}
                                </td>
                                <td class="px-4 py-2 text-gray-400">
                                    {{ $category->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="text-xs bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-1 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs bg-red-500 hover:bg-red-400 text-white px-3 py-1 rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400">
                                    No categories yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
