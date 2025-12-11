// Product Detail JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    /* ================================
       QUANTITY CONTROLS
    ================================= */
    const qtyInput = document.getElementById('qtyInput');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    
    if (decreaseBtn && increaseBtn && qtyInput) {
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            const minValue = parseInt(qtyInput.min);
            if (currentValue > minValue) qtyInput.value = currentValue - 1;
        });

        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            const maxValue = parseInt(qtyInput.max);
            if (currentValue < maxValue) qtyInput.value = currentValue + 1;
        });

        qtyInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);

            if (isNaN(value) || value < min) this.value = min;
            if (value > max) this.value = max;
        });
    }

    /* ================================
       THUMBNAIL GALLERY
    ================================= */
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const mainImage = document.getElementById('mainImage');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const newSrc = this.querySelector('img').src;
            if (mainImage) mainImage.src = newSrc;
        });
    });

    /* ================================
       WISHLIST TOGGLE
    ================================= */
    const wishlistBtn = document.querySelector('.wishlist-badge');
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            const svg = this.querySelector('svg path');
            
            if (this.classList.contains('active')) {
                svg.setAttribute('fill', 'currentColor');
                showNotification('Added to wishlist! 💖');
            } else {
                svg.setAttribute('fill', 'none');
                showNotification('Removed from wishlist');
            }
        });
    }

    /* ================================
       ADD TO CART
    ================================= */
    const addToCartBtn = document.querySelector('.btn-add-cart');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            if (!this.disabled) {
                const quantity = qtyInput ? qtyInput.value : 1;
                showNotification(`Added ${quantity} item(s) to cart! 🛒`);
            }
        });
    }

    /* ================================
       BUY NOW
    ================================= */
    const buyNowBtn = document.querySelector('.btn-buy-now');

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            if (!this.disabled) {
                const quantity = qtyInput ? qtyInput.value : 1;
                showNotification('Redirecting to checkout...');
            }
        });
    }

    /* ================================
       NOTIFICATION SYSTEM
    ================================= */
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.product-notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = `product-notification ${type}`;
        notification.textContent = message;

        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? '#984216' : '#E8A87C'};
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: slideInRight 0.3s ease-out;
            font-weight: 600;
            font-size: 15px;
        `;

        if (!document.getElementById('notificationStyles')) {
            const style = document.createElement('style');
            style.id = 'notificationStyles';
            style.textContent = `
                @keyframes slideInRight {
                    from { transform: translateX(400px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOutRight {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(400px); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    /* ================================
       IMAGE ZOOM (DESKTOP)
    ================================= */
    const mainImageContainer = document.querySelector('.main-image-container');
    
    if (mainImageContainer && window.innerWidth > 1024) {
        mainImageContainer.addEventListener('mousemove', function(e) {
            const img = this.querySelector('.main-product-image');
            if (!img) return;

            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            img.style.transformOrigin = `${x}% ${y}%`;
        });

        mainImageContainer.addEventListener('mouseleave', function() {
            const img = this.querySelector('.main-product-image');
            if (img) img.style.transformOrigin = 'center center';
        });
    }

});
