// Product Detail JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Quantity Controls
    const qtyInput = document.getElementById('qtyInput');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    
    if (decreaseBtn && increaseBtn && qtyInput) {
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            const minValue = parseInt(qtyInput.min);
            
            if (currentValue > minValue) {
                qtyInput.value = currentValue - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            const maxValue = parseInt(qtyInput.max);
            
            if (currentValue < maxValue) {
                qtyInput.value = currentValue + 1;
            }
        });
        
        // Prevent invalid input
        qtyInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);
            
            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    }
    
    // Thumbnail Gallery
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const mainImage = document.getElementById('mainImage');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all
            thumbnails.forEach(t => t.classList.remove('active'));
            
            // Add active to clicked
            this.classList.add('active');
            
            // Change main image
            const newSrc = this.querySelector('img').src;
            if (mainImage) {
                mainImage.src = newSrc;
            }
        });
    });
    
    // Wishlist Toggle
    const wishlistBtn = document.querySelector('.wishlist-badge');
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            
            // Change icon fill
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
    
    // Add to Cart Button
    const addToCartBtn = document.querySelector('.btn-add-cart');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            if (!this.disabled) {
                const quantity = qtyInput ? qtyInput.value : 1;
                showNotification(`Added ${quantity} item(s) to cart! 🛒`);
                
                // Here you can add AJAX call to add to cart
                console.log('Add to cart:', quantity);
            }
        });
    }
    
    // Buy Now Button
    const buyNowBtn = document.querySelector('.btn-buy-now');
    
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            if (!this.disabled) {
                const quantity = qtyInput ? qtyInput.value : 1;
                showNotification('Redirecting to checkout...');
                
                // Redirect to checkout
                // window.location.href = '/checkout';
                console.log('Buy now:', quantity);
            }
        });
    }
    
    // Notification System
    function showNotification(message, type = 'success') {
        // Remove existing notification
        const existing = document.querySelector('.product-notification');
        if (existing) {
            existing.remove();
        }
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = `product-notification ${type}`;
        notification.textContent = message;
        
        // Add styles
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
        
        // Add animation
        if (!document.getElementById('notificationStyles')) {
            const style = document.createElement('style');
            style.id = 'notificationStyles';
            style.textContent = `
                @keyframes slideInRight {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOutRight {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(notification);
        
        // Auto remove
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Image Zoom on Hover (Optional)
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
            if (img) {
                img.style.transformOrigin = 'center center';
            }
        });
    }
});