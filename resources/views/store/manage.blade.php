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
                            <span class="breadcrumb-current">Manage Store</span>
                        </div>
                    </div>
                    
                    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">🏪 Manage Store</h1>
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #6b7280;">Update store profile and manage products</p>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    
                    @if(session('success'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        ✓ {{ session('success') }}
                    </div>
                    @endif

                    <!-- Store Profile Section -->
                    <div class="p-6 bg-white rounded-lg shadow">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Store Profile</h2>
                        
                        <form method="POST" action="{{ route('store.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Name *</label>
                                    <input type="text" name="name" value="{{ $store->name }}" required 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Banner</label>
                                    <input type="file" name="banner" accept="image/*" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" rows="4" 
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">{{ $store->description ?? '' }}</textarea>
                            </div>

                            <button type="submit" class="mt-4 px-6 py-2.5 text-white rounded-lg font-medium" style="background-color: #984216;">
                                Update Store Profile
                            </button>
                        </form>
                    </div>

                    <!-- Products Management Section -->
                    <div class="p-6 bg-white rounded-lg shadow">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">Products Management</h2>
                            <button onclick="openProductModal()" class="px-5 py-2.5 text-white rounded-lg font-medium" style="background-color: #984216;">
                                + Add New Product
                            </button>
                        </div>

                        @if($products->count() > 0)
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                            @foreach($products as $product)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                <div style="width: 100%; aspect-ratio: 1; background: #f9fafb; overflow: hidden;">
                                    @php
                                        // Cari gambar pertama dengan format id-1.jpeg, id-1.jpg, id-1.png, dll
                                        $imagePath = null;
                                        $extensions = ['jpeg', 'jpg', 'png', 'webp'];
                                        foreach ($extensions as $ext) {
                                            $path = "images/products/{$product->id}-1.{$ext}";
                                            if (file_exists(public_path($path))) {
                                                $imagePath = $path;
                                                break;
                                            }
                                        }
                                    @endphp
                                    
                                    @if($imagePath)
                                        <img src="{{ asset($imagePath) }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;"
                                             onerror="this.parentElement.innerHTML='<div style=\'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 60px;\'>🌿</div>'">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 60px;">🌿</div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <div class="font-semibold text-gray-800 mb-1">{{ Str::limit($product->name, 30) }}</div>
                                    <div class="text-xs text-gray-500 mb-2">{{ $product->category_name ?? 'Uncategorized' }}</div>
                                    <div class="text-lg font-bold mb-2" style="color: #984216;">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-600 mb-3">Stock: {{ $product->stock }}</div>
                                    
                                    <div class="flex gap-2">
                                        <button class="flex-1 px-3 py-2 bg-yellow-500 text-white rounded text-sm font-medium">Edit</button>
                                        <form method="POST" action="{{ route('store.product.delete', $product->id) }}" class="flex-1" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div style="font-size: 60px; margin-bottom: 20px;">📦</div>
                            <div style="font-size: 18px; color: #6b7280;">No products yet</div>
                            <div style="font-size: 14px; color: #9ca3af; margin-top: 10px;">Add your first product to start selling</div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="productModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl mx-auto my-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add New Product</h2>
            
            <form method="POST" action="{{ route('store.product.create') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" required placeholder="Enter product name" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;" class="mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                        <input type="number" name="price" required min="0" placeholder="0" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                        <input type="number" name="stock" required min="0" placeholder="0" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Weight (gram) *</label>
                        <input type="number" name="weight" required min="0" placeholder="0" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" required rows="4" placeholder="Product description..." 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                    <input type="file" name="images[]" multiple accept="image/*" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                    <div class="text-xs text-gray-500 mt-1">You can upload multiple images</div>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeProductModal()" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 text-white rounded-lg font-medium" style="background-color: #984216;">Add Product</button>
                </div>
            </form>
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

    <script>
        function openProductModal() {
            document.getElementById('productModal').style.display = 'flex';
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });
    </script>
</x-app-layout>