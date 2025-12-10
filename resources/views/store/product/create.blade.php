@extends('layouts.app')

@section('content')
<div class= bg-tumbloo-dark min-h-screen>
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('store.products.index') }}" class="text-gray-400 hover:text-white mb-4 inline-block transition-colors">
                ← Kembali ke Produk
            </a>
            <h1 class="text-3xl font-bold text-white mb-2">Tambah Produk</h1>
            <p class="text-gray-400">Tambahkan produk baru ke toko Anda</p>
        </div>

        <!-- Form -->
        <div class="bg-zinc-900 rounded-xl p-8 border border-zinc-800">
            <form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Image -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Foto Produk <span class="text-red-400">*</span>
                    </label>
                    <p class="text-sm text-gray-400 mb-3">Upload foto produk (Format: JPG, PNG, max 2MB)</p>
                    
                    <div class="image-upload-container">
                        <div class="image-upload-box" id="uploadBox" onclick="document.getElementById('productImage').click()">
                            <input type="file" id="productImage" name="image" accept="image/*" class="hidden" onchange="previewImage(this)" required>
                            <div id="imagePreview" class="preview-content">
                                <svg class="w-12 h-12 text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-400">Klik untuk upload foto</span>
                            </div>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Name -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Nama Produk <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" 
                        class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" 
                        placeholder="Nama produk yang menarik"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <div class="flex gap-2">
                        <select name="product_category_id" id="categorySelect"
                            class="flex-1 px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-blue-500 @error('product_category_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors whitespace-nowrap">
                            + Kategori Baru
                        </button>
                    </div>
                    @error('product_category_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Deskripsi Produk <span class="text-red-400">*</span>
                    </label>
                    <textarea name="description" rows="5"
                        class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('description') border-red-500 @enderror" 
                        placeholder="Jelaskan detail produk Anda..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Condition -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Kondisi <span class="text-red-400">*</span>
                    </label>
                    <select name="condition" 
                        class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-blue-500 @error('condition') border-red-500 @enderror" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>Bekas</option>
                    </select>
                    @error('condition')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Weight -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-300 block mb-2">
                            Harga (Rp) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="price" 
                            class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('price') border-red-500 @enderror" 
                            placeholder="100000" min="0" step="0.01"
                            value="{{ old('price') }}" required>
                        @error('price')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-300 block mb-2">
                            Berat (gram) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="weight" 
                            class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('weight') border-red-500 @enderror" 
                            placeholder="500" min="0"
                            value="{{ old('weight') }}" required>
                        @error('weight')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-300 block mb-2">
                        Stok <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="stock" 
                        class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 @error('stock') border-red-500 @enderror" 
                        placeholder="10" min="0"
                        value="{{ old('stock') }}" required>
                    @error('stock')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-400">
                        💡 <strong>Tips:</strong> Upload foto produk yang jelas dan menarik untuk meningkatkan penjualan!
                    </p>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Simpan Produk
                    </button>
                    <a href="{{ route('store.products.index') }}" class="flex-1 px-6 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Tambah Kategori Baru</h3>
            <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="categoryForm" onsubmit="submitCategory(event)">
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-300 block mb-2">
                    Nama Kategori <span class="text-red-400">*</span>
                </label>
                <input type="text" id="categoryName" name="name"
                    class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500" 
                    placeholder="Contoh: Elektronik, Fashion, dll"
                    required>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-300 block mb-2">Tagline</label>
                <input type="text" id="categoryTagline" name="tagline"
                    class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500" 
                    placeholder="Tagline singkat kategori">
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-300 block mb-2">Deskripsi</label>
                <textarea id="categoryDescription" name="description" rows="3"
                    class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500" 
                    placeholder="Deskripsi kategori (opsional)"></textarea>
            </div>

            <p id="categoryError" class="text-red-400 text-xs mb-3 hidden"></p>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors" id="submitCategoryBtn">
                    Simpan Kategori
                </button>
                <button type="button" onclick="closeCategoryModal()" class="flex-1 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.image-upload-container {
    max-width: 300px;
}

.image-upload-box {
    aspect-ratio: 1;
    border: 2px dashed #3f3f46;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    overflow: hidden;
    position: relative;
    background-color: #18181b;
}

.image-upload-box:hover {
    border-color: #52525b;
    background-color: #27272a;
}

.image-upload-box.has-image {
    border-style: solid;
    border-color: #10b981;
    background-color: #000;
}

.preview-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 1rem;
}

.preview-content img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
}

.remove-image {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background-color: rgba(239, 68, 68, 0.9);
    color: white;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s;
}

.remove-image:hover {
    background-color: rgb(220, 38, 38);
    transform: scale(1.1);
}

.image-upload-box.has-image .remove-image {
    display: flex;
}
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const uploadBox = document.getElementById('uploadBox');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <div class="remove-image" onclick="removeImage(event)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            `;
            uploadBox.classList.add('has-image');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(event) {
    event.stopPropagation();
    
    const input = document.getElementById('productImage');
    const preview = document.getElementById('imagePreview');
    const uploadBox = document.getElementById('uploadBox');
    
    input.value = '';
    preview.innerHTML = `
        <svg class="w-12 h-12 text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm text-gray-400">Klik untuk upload foto</span>
    `;
    uploadBox.classList.remove('has-image');
}

function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').classList.add('flex');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryModal').classList.remove('flex');
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryError').classList.add('hidden');
}

async function submitCategory(event) {
    event.preventDefault();
    
    const submitBtn = document.getElementById('submitCategoryBtn');
    const errorEl = document.getElementById('categoryError');
    
    const categoryName = document.getElementById('categoryName').value;
    const categoryTagline = document.getElementById('categoryTagline').value;
    const categoryDescription = document.getElementById('categoryDescription').value;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        errorEl.textContent = 'Error: CSRF token tidak ditemukan.';
        errorEl.classList.remove('hidden');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    errorEl.classList.add('hidden');
    
    const url = '{{ route("store.categories.store") }}';
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                name: categoryName,
                tagline: categoryTagline,
                description: categoryDescription
            })
        });
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            errorEl.textContent = 'Server error: Response bukan JSON.';
            errorEl.classList.remove('hidden');
            return;
        }
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            const select = document.getElementById('categorySelect');
            const option = new Option(data.category.name, data.category.id, true, true);
            select.add(option);
            
            closeCategoryModal();
            
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = 'Kategori berhasil ditambahkan!';
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat().join(', ');
                errorEl.textContent = errorMessages;
            } else if (data.message) {
                errorEl.textContent = data.message;
            } else {
                errorEl.textContent = 'Terjadi kesalahan. Status: ' + response.status;
            }
            errorEl.classList.remove('hidden');
        }
    } catch (error) {
        let errorMessage = 'Terjadi kesalahan koneksi: ' + error.message;
        if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
            errorMessage = 'Tidak dapat terhubung ke server.';
        }
        errorEl.textContent = errorMessage;
        errorEl.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Simpan Kategori';
    }
}

document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCategoryModal();
    }
});
</script>
@endsection