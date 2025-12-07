<footer class="buyer-footer">
    <div class="footer-main">
        {{-- About Section --}}
        <div class="footer-section footer-about">
            <h3>Tentang ELSHOP</h3>
            <p>ELSHOP adalah platform e-commerce terpercaya untuk membeli berbagai snack dan makanan ringan favorit Anda dengan harga terbaik.</p>
            <div class="social-links">
                <a href="#" class="social-link" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="footer-section">
            <h3>Tautan Cepat</h3>
            <ul class="footer-links">
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Cara Berbelanja</a></li>
                <li><a href="#">Informasi Pengiriman</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>

        {{-- For Sellers --}}
        <div class="footer-section">
            <h3>Untuk Seller</h3>
            <ul class="footer-links">
                <li><a href="{{ route('store.apply') }}">Daftar Jadi Seller</a></li>
                <li><a href="#">Panduan Seller</a></li>
                <li><a href="#">Dukungan Seller</a></li>
                @auth
                    @php
                        $hasStore = \App\Models\Store::where('user_id', auth()->id())
                            ->where('is_verified', 1)
                            ->exists();
                    @endphp
                    @if($hasStore)
                        <li><a href="{{ route('seller.dashboard') }}">Dashboard Seller</a></li>
                    @endif
                @endauth
            </ul>
        </div>

        {{-- Customer Service --}}
        <div class="footer-section">
            <h3>Layanan Pelanggan</h3>
            <ul class="footer-links">
                <li><a href="#">Pusat Bantuan</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
                <li><a href="#">Kebijakan Privasi</a></li>
                <li><a href="#">Pengembalian & Penukaran</a></li>
                <li><a href="#">Jaminan 100% Aman</a></li>
            </ul>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p>&copy; {{ date('Y') }} ELSHOP. All rights reserved.</p>
            <div class="payment-methods">
                <span style="margin-right: 12px; font-size: 0.875rem; opacity: 0.9;">Metode Pembayaran:</span>
                <div class="payment-icon">
                    <i class="fab fa-cc-visa"></i>
                </div>
                <div class="payment-icon">
                    <i class="fab fa-cc-mastercard"></i>
                </div>
                <div class="payment-icon">OVO</div>
                <div class="payment-icon">DANA</div>
                <div class="payment-icon">GOPAY</div>
            </div>
        </div>
    </div>
</footer>