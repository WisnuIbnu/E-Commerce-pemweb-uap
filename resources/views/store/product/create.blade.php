@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('store.products.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Produk
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Tambah Produk</h1>
            <p class="text-tumbloo-gray">Tambahkan produk baru ke toko Anda</p>
        </div>

        <!-- Form -->
        <div class="card p-8">
            <form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Image -->
                <div class="mb-6">
                    <label class="label">Foto Produk <span class="text-red-500">*</span></label>
                    <p class="text-sm text-tumbloo-gray mb-3">Upload foto produk (Format: JPG, PNG, max 2MB)</p>
                    
                    <div class="image-upload-container">
                        <div class="image-upload-box" id="uploadBox" onclick="document.getElementById('productImage').click()">
                            <input type="file" id="productImage" name="image" accept="image/*" class="hidden" onchange="previewImage(this)" required>
                            <div id="imagePreview" class="preview-content">
                                <svg class="w-12 h-12 text-tumbloo-gray mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-tumbloo-gray">Klik untuk upload foto</span>
                            </div>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Name -->
                <div class="mb-6">
                    <label class="label">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                        class="input-field @error('name') border-red-500 @enderror" 
                        placeholder="Nama produk yang menarik"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="label">Kategori <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <select name="product_category_id" id="categorySelect"
                            class="select-field flex-1 @error('product_category_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()" 
                            class="px-4 py-2 bg-tumbloo-black text-white rounded-lg hover:bg-opacity-90 transition whitespace-nowrap">
                            + Kategori Baru
                        </button>
                    </div>
                    @error('product_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="label">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5"
                        class="textarea-field @error('description') border-red-500 @enderror" 
                        placeholder="Jelaskan detail produk Anda..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Condition -->
                <div class="mb-6">
                    <label class="label">Kondisi <span class="text-red-500">*</span></label>
                    <select name="condition" 
                        class="select-field @error('condition') border-red-500 @enderror" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>Bekas</option>
                    </select>
                    @error('condition')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Weight -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" 
                            class="input-field @error('price') border-red-500 @enderror" 
                            placeholder="100000" min="0" step="0.01"
                            value="{{ old('price') }}" required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Berat (gram) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" 
                            class="input-field @error('weight') border-red-500 @enderror" 
                            placeholder="500" min="0"
                            value="{{ old('weight') }}" required>
                        @error('weight')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-6">
                    <label class="label">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" 
                        class="input-field @error('stock') border-red-500 @enderror" 
                        placeholder="10" min="0"
                        value="{{ old('stock') }}" required>
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mb-6">
                    <p class="text-sm">
                        💡 <strong>Tips:</strong> Upload foto produk yang jelas dan menarik untuk meningkatkan penjualan!
                    </p>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">
                        Simpan Produk
                    </button>
                    <a href="{{ route('store.products.index') }}" class="btn-secondary flex-1">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-tumbloo-black">Tambah Kategori Baru</h3>
            <button type="button" onclick="closeCategoryModal()" class="text-tumbloo-gray hover:text-tumbloo-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="categoryForm" onsubmit="submitCategory(event)">
            <div class="mb-4">
                <label class="label">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="categoryName" name="name"
                    class="input-field" 
                    placeholder="Contoh: Elektronik, Fashion, dll"
                    required>
            </div>

            <div class="mb-4">
                <label class="label">Tagline</label>
                <input type="text" id="categoryTagline" name="tagline"
                    class="input-field" 
                    placeholder="Tagline singkat kategori">
            </div>

            <div class="mb-4">
                <label class="label">Deskripsi</label>
                <textarea id="categoryDescription" name="description" rows="3"
                    class="textarea-field" 
                    placeholder="Deskripsi kategori (opsional)"></textarea>
            </div>

            <p id="categoryError" class="text-red-500 text-xs mb-3 hidden"></p>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1" id="submitCategoryBtn">
                    Simpan Kategori
                </button>
                <button type="button" onclick="closeCategoryModal()" class="btn-secondary flex-1">
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
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    overflow: hidden;
    position: relative;
    background-color: #f9fafb;
}

.image-upload-box:hover {
    border-color: #9ca3af;
    background-color: #f3f4f6;
}

.image-upload-box.has-image {
    border-style: solid;
    border-color: #10b981;
    background-color: #fff;
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
        <svg class="w-12 h-12 text-tumbloo-gray mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm text-tumbloo-gray">Klik untuk upload foto</span>
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
    
    // Check CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        errorEl.textContent = 'Error: CSRF token tidak ditemukan. Tambahkan <meta name="csrf-token"> di layout.';
        errorEl.classList.remove('hidden');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    errorEl.classList.add('hidden');
    
    const url = '{{ route("store.categories.store") }}';
    console.log('Request URL:', url);
    console.log('Sending data:', { name: categoryName, tagline: categoryTagline, description: categoryDescription });
    
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
        
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Cek apakah response adalah JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Response bukan JSON:', text);
            errorEl.textContent = 'Server error: Response bukan JSON. Mungkin ada redirect atau error 500.';
            errorEl.classList.remove('hidden');
            return;
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (response.ok && data.success) {
            const select = document.getElementById('categorySelect');
            const option = new Option(data.category.name, data.category.id, true, true);
            select.add(option);
            
            closeCategoryModal();
            
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = 'Kategori berhasil ditambahkan!';
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            // Show validation errors
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
        console.error('Fetch error:', error);
        console.error('Error type:', error.name);
        console.error('Error message:', error.message);
        
        let errorMessage = 'Terjadi kesalahan koneksi: ' + error.message;
        
        if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
            errorMessage = 'Tidak dapat terhubung ke server. Pastikan Laravel server berjalan (php artisan serve).';
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