
<x-app-layout>
<x-slot name="title">Register Your Store - SORAÉ</x-slot>

<style>
.register-container {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 20px;
}

.register-header {
    text-align: center;
    margin-bottom: 50px;
}

.register-header h1 {
    font-size: 3rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.register-header p {
    font-size: 1.1rem;
    color: var(--color-secondary);
}

.register-card {
    background: var(--color-white);
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(86, 28, 36, 0.1);
}

.status-card {
    background: var(--color-white);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(86, 28, 36, 0.1);
}

.status-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.status-title {
    font-size: 2rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.status-message {
    font-size: 1.1rem;
    color: var(--color-secondary);
    line-height: 1.8;
}

.form-section {
    margin-bottom: 35px;
}

.form-section-title {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--color-light);
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    color: var(--color-primary);
    font-weight: 500;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--color-tertiary);
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--color-primary);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.file-input-wrapper {
    position: relative;
}

.file-input {
    display: none;
}

.file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    border: 2px dashed var(--color-tertiary);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

.file-label:hover {
    border-color: var(--color-primary);
    background: var(--color-light);
}

.file-icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

.image-preview {
    margin-top: 15px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.preview-item {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.rejection-reason {
    background: #f8d7da;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #dc3545;
    margin-bottom: 30px;
}

.rejection-reason strong {
    display: block;
    margin-bottom: 10px;
    color: #721c24;
}

@media (max-width: 768px) {
    .register-card {
        padding: 30px 20px;
    }
    
    .register-header h1 {
        font-size: 2rem;
    }
}
</style>

<div class="register-container">
    @if(auth()->user()->store && auth()->user()->store->isPending())
        <!-- Pending Status -->
        <div class="status-card">
            <div class="status-icon">⏳</div>
            <h1 class="status-title">Registration Pending</h1>
            <p class="status-message">
                Your store registration is currently under review. Our team will verify your information and get back to you within 1-3 business days.
            </p>
            <div style="margin-top: 30px;">
                <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    @elseif(auth()->user()->store && auth()->user()->store->isApproved())
        <!-- Approved - Redirect to Dashboard -->
        <script>window.location.href = "{{ route('seller.dashboard') }}";</script>
    @else
        <!-- Registration Form -->
        <div class="register-header">
            <h1>Become a Seller</h1>
            <p>Register your store and start selling on SORAÉ</p>
        </div>

        @if(auth()->user()->store && auth()->user()->store->isRejected())
            <div class="rejection-reason">
                <strong>❌ Previous Registration Rejected</strong>
                <p>{{ auth()->user()->store->rejection_reason }}</p>
                <p style="margin-top: 10px; font-size: 0.95rem;">Please review the feedback and submit a new application.</p>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul style="margin-top: 10px; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="register-card">
            <form method="POST" action="{{ route('seller.register.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Store Information -->
                <div class="form-section">
                    <h2 class="form-section-title">Store Information</h2>
                    
                    <div class="form-group">
                        <label class="form-label required">Store Name</label>
                        <input type="text" name="name" class="form-input" 
                               value="{{ old('name') }}" 
                               placeholder="Your Store Name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Store Description</label>
                        <textarea name="description" class="form-textarea" 
                                  placeholder="Tell customers about your store..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store Logo</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="logo" id="logo" class="file-input" accept="image/*">
                            <label for="logo" class="file-label">
                                <div>
                                    <div class="file-icon">📷</div>
                                    <p>Click to upload store logo</p>
                                    <p style="font-size: 0.9rem; color: var(--color-tertiary); margin-top: 5px;">
                                        PNG, JPG (max 2MB)
                                    </p>
                                </div>
                            </label>
                        </div>
                        <div id="logo-preview" class="image-preview"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store Banner</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="banner" id="banner" class="file-input" accept="image/*">
                            <label for="banner" class="file-label">
                                <div>
                                    <div class="file-icon">🖼️</div>
                                    <p>Click to upload store banner</p>
                                    <p style="font-size: 0.9rem; color: var(--color-tertiary); margin-top: 5px;">
                                        PNG, JPG (max 2MB, recommended: 1200x400)
                                    </p>
                                </div>
                            </label>
                        </div>
                        <div id="banner-preview" class="image-preview"></div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h2 class="form-section-title">Contact Information</h2>
                    
                    <div class="form-group">
                        <label class="form-label required">Phone Number</label>
                        <input type="tel" name="phone" class="form-input" 
                               value="{{ old('phone') }}" 
                               placeholder="08123456789" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-input" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               placeholder="store@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Store Address</label>
                        <textarea name="address" class="form-textarea" 
                                  placeholder="Complete store address..." required>{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- Terms -->
                <div class="form-group">
                    <label style="display: flex; align-items: flex-start; gap: 10px;">
                        <input type="checkbox" name="terms" required 
                               style="width: 18px; height: 18px; margin-top: 3px;">
                        <span style="color: var(--color-secondary);">
                            I agree to the <a href="#" style="color: var(--color-primary); text-decoration: underline;">Seller Terms & Conditions</a> 
                            and confirm that all information provided is accurate.
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                    Submit Registration
                </button>
            </form>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Image preview functionality
function setupImagePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (!input || !preview) return;
    
    input.addEventListener('change', function(e) {
        preview.innerHTML = '';
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
}

setupImagePreview('logo', 'logo-preview');
setupImagePreview('banner', 'banner-preview');
</script>
@endpush
</x-app-layout>
