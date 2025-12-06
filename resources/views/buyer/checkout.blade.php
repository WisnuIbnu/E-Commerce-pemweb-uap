@extends('layouts.app')

@section('title', 'Checkout - FlexSport')

@section('content')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

<div class="checkout-container">
    <div class="checkout-wrapper">
        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <span>Alamat Pengiriman</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">2</div>
                <span>Metode Pengiriman</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span>Pembayaran</span>
            </div>
        </div>

        <div class="checkout-content">
            <!-- Left Column: Form -->
            <div class="checkout-form">
                <form method="POST" action="{{ route('checkout.process') }}" id="checkoutForm">
                    @csrf
                    
                    <!-- Section 1: Alamat Pengiriman -->
                    <div class="form-section active" id="section-address">
                        <h2>📍 Alamat Pengiriman</h2>
                        
                        <div class="form-group">
                            <label for="name">Nama Penerima</label>
                            <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" required placeholder="08123456789">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">Kota</label>
                                <input type="text" id="city" name="city" required placeholder="Contoh: Jakarta">
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" required placeholder="12345">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="4" required placeholder="Jl. Sudirman No. 123, RT 01/RW 02"></textarea>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Lanjut ke Pengiriman →
                        </button>
                    </div>

                    <!-- Section 2: Metode Pengiriman -->
                    <div class="form-section" id="section-shipping">
                        <h2>🚚 Pilih Metode Pengiriman</h2>
                        
                        <div class="shipping-options">
                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="JNE Regular" data-cost="25000" required>
                                <div class="option-content">
                                    <div class="option-header">
                                        <strong>JNE Regular</strong>
                                        <span class="price">Rp 25.000</span>
                                    </div>
                                    <small>Estimasi: 3-5 hari</small>
                                </div>
                            </label>

                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="JNE YES" data-cost="35000">
                                <div class="option-content">
                                    <div class="option-header">
                                        <strong>JNE YES</strong>
                                        <span class="price">Rp 35.000</span>
                                    </div>
                                    <small>Estimasi: 1-2 hari</small>
                                </div>
                            </label>

                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="SiCepat REG" data-cost="20000">
                                <div class="option-content">
                                    <div class="option-header">
                                        <strong>SiCepat REG</strong>
                                        <span class="price">Rp 20.000</span>
                                    </div>
                                    <small>Estimasi: 2-4 hari</small>
                                </div>
                            </label>

                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="Grab Express" data-cost="45000">
                                <div class="option-content">
                                    <div class="option-header">
                                        <strong>Grab Express</strong>
                                        <span class="price">Rp 45.000</span>
                                    </div>
                                    <small>Estimasi: Same day</small>
                                </div>
                            </label>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn btn-outline" onclick="prevStep(1)">
                                ← Kembali
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                Lanjut ke Pembayaran →
                            </button>
                        </div>
                    </div>

                    <!-- Section 3: Pembayaran -->
                    <div class="form-section" id="section-payment">
                        <h2>💳 Metode Pembayaran</h2>
                        
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="transfer" required>
                                <div class="option-content">
                                    <strong>Transfer Bank</strong>
                                    <small>BCA, BRI, BNI, Mandiri</small>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="ewallet">
                                <div class="option-content">
                                    <strong>E-Wallet</strong>
                                    <small>GoPay, OVO, Dana, ShopeePay</small>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod">
                                <div class="option-content">
                                    <strong>COD (Bayar di Tempat)</strong>
                                    <small>Bayar saat barang sampai</small>
                                </div>
                            </label>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn btn-outline" onclick="prevStep(2)">
                                ← Kembali
                            </button>
                            <button type="submit" class="btn btn-success">
                                💳 Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="order-summary">
                <h3>📦 Ringkasan Pesanan</h3>
                
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" alt="Product">
                    <div class="product-info">
                        <h4>Sepatu Futsal Nike Mercurial</h4>
                        <p>Jumlah: 1</p>
                        <strong>Rp 450.000</strong>
                    </div>
                </div>

                <div class="summary-details">
                    <div class="detail-row">
                        <span>Subtotal Produk</span>
                        <strong id="subtotal">Rp 450.000</strong>
                    </div>
                    <div class="detail-row">
                        <span>Ongkos Kirim</span>
                        <strong id="shipping-cost">Rp 0</strong>
                    </div>
                    <div class="detail-row">
                        <span>Pajak (11%)</span>
                        <strong id="tax">Rp 49.500</strong>
                    </div>
                    <div class="divider"></div>
                    <div class="detail-row total">
                        <span>Total</span>
                        <strong id="grand-total">Rp 499.500</strong>
                    </div>
                </div>

                <div class="promo-section">
                    <input type="text" placeholder="Masukkan kode promo">
                    <button class="btn-promo">Gunakan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;

function nextStep(step) {
    // Validate current section
    const currentSection = document.getElementById(`section-${getSectionName(currentStep)}`);
    const inputs = currentSection.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value) {
            isValid = false;
            input.style.borderColor = '#dc3545';
        } else {
            input.style.borderColor = '#E1E5EA';
        }
    });
    
    if (!isValid) {
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return;
    }
    
    // Hide current section
    currentSection.classList.remove('active');
    
    // Show next section
    const nextSection = document.getElementById(`section-${getSectionName(step)}`);
    nextSection.classList.add('active');
    
    // Update progress steps
    updateSteps(step);
    currentStep = step;
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    document.getElementById(`section-${getSectionName(currentStep)}`).classList.remove('active');
    document.getElementById(`section-${getSectionName(step)}`).classList.add('active');
    updateSteps(step);
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function getSectionName(step) {
    const sections = { 1: 'address', 2: 'shipping', 3: 'payment' };
    return sections[step];
}

function updateSteps(activeStep) {
    document.querySelectorAll('.step').forEach((step, index) => {
        if (index + 1 <= activeStep) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });
}

// Update shipping cost
document.querySelectorAll('input[name="shipping"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const cost = parseInt(this.dataset.cost);
        const subtotal = 450000;
        const tax = Math.round((subtotal + cost) * 0.11);
        const grandTotal = subtotal + cost + tax;
        
        document.getElementById('shipping-cost').textContent = 'Rp ' + cost.toLocaleString('id-ID');
        document.getElementById('tax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
        document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    });
});

// Form submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('✅ Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    window.location.href = '{{ route("transaction.history") }}';
});
</script>
@endsection