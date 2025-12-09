{{-- ============================================
     FILE: resources/views/layouts/footer.blade.php
     Footer component
     ============================================ --}}
<style>
.footer {
    background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
    color: var(--white);
    padding: var(--spacing-2xl) 0 var(--spacing-md);
    margin-top: var(--spacing-2xl);
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-xl);
}

.footer-section h3 {
    margin-bottom: var(--spacing-md);
    font-size: 18px;
    color: var(--white);
}

.footer-logo {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-link {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    margin-bottom: var(--spacing-sm);
    transition: all 0.2s;
    font-size: 14px;
}

.footer-link:hover {
    color: var(--white);
    padding-left: 4px;
}

.footer-bottom {
    text-align: center;
    padding-top: var(--spacing-md);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.5);
    font-size: 14px;
}

.social-links {
    display: flex;
    gap: var(--spacing-md);
    margin-top: var(--spacing-md);
}

.social-link {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    text-decoration: none;
    font-size: 18px;
    transition: all 0.2s;
}

.social-link:hover {
    background: var(--primary);
    transform: translateY(-2px);
}
</style>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <div class="footer-logo">
                    <span>🛍️</span>
                    <span>DrizStuff</span>
                </div>
                <p style="color: rgba(255, 255, 255, 0.7); line-height: 1.6;">
                    Your trusted online marketplace for quality products. Shop with confidence from verified sellers.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" title="Facebook">📘</a>
                    <a href="#" class="social-link" title="Instagram">📷</a>
                    <a href="#" class="social-link" title="Twitter">🐦</a>
                    <a href="#" class="social-link" title="WhatsApp">💬</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Shop</h3>
                <a href="{{ route('home') }}" class="footer-link">All Products</a>
                <a href="{{ route('home') }}" class="footer-link">Categories</a>
                <a href="{{ route('home') }}" class="footer-link">New Arrivals</a>
                <a href="{{ route('home') }}" class="footer-link">Best Sellers</a>
            </div>
            
            <div class="footer-section">
                <h3>For Sellers</h3>
                @guest
                    <a href="{{ route('register') }}" class="footer-link">Register as Seller</a>
                @else
                    @if(!auth()->user()->store)
                        <a href="{{ route('seller.register') }}" class="footer-link">Open Your Store</a>
                    @else
                        <a href="{{ route('seller.dashboard') }}" class="footer-link">Seller Dashboard</a>
                        <a href="{{ route('seller.products.index') }}" class="footer-link">My Products</a>
                        <a href="{{ route('seller.orders.index') }}" class="footer-link">Orders</a>
                    @endif
                @endguest
                <a href="#" class="footer-link">Seller Guide</a>
                <a href="#" class="footer-link">Success Stories</a>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 12px; font-size: 14px;">
                    <strong>Email:</strong><br>
                    support@drizstuff.com
                </p>
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 12px; font-size: 14px;">
                    <strong>Phone:</strong><br>
                    +62 812-3456-7890
                </p>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 14px;">
                    <strong>Address:</strong><br>
                    Jakarta, Indonesia
                </p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} DrizStuff. All rights reserved. Made with ❤️ for great shopping experience.</p>
        </div>
    </div>
</footer>