// footer.js

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // Back to Top Button Functionality
    // ========================================
    const backToTopBtn = document.getElementById('backToTopBtn');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        // Smooth scroll to top when clicked
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    
    // ========================================
    // Newsletter Form (Optional - if you add it later)
    // ========================================
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (email && validateEmail(email)) {
                // Show success message
                showNotification('Thank you for subscribing!', 'success');
                emailInput.value = '';
            } else {
                showNotification('Please enter a valid email address', 'error');
            }
        });
    }
    
    
    // ========================================
    // Email Validation Helper
    // ========================================
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    
    // ========================================
    // Notification System
    // ========================================
    function showNotification(message, type = 'info') {
        // Check if notification container exists, if not create it
        let notificationContainer = document.getElementById('notificationContainer');
        
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.id = 'notificationContainer';
            notificationContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
            `;
            document.body.appendChild(notificationContainer);
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            background: ${type === 'success' ? '#8D957E' : '#E8A87C'};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
            min-width: 250px;
            font-size: 14px;
            font-weight: 500;
        `;
        
        // Add animation keyframes if not exist
        if (!document.getElementById('notificationStyles')) {
            const style = document.createElement('style');
            style.id = 'notificationStyles';
            style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOut {
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
        
        // Append notification
        notificationContainer.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    
    // ========================================
    // Smooth Scroll for Footer Links
    // ========================================
    const footerLinks = document.querySelectorAll('.footer-links a[href^="#"]');
    
    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only handle anchor links
            if (href.startsWith('#') && href.length > 1) {
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    
    // ========================================
    // Current Year Update (for copyright)
    // ========================================
    const currentYearElement = document.querySelector('.footer-copyright');
    if (currentYearElement) {
        const currentYear = new Date().getFullYear();
        currentYearElement.innerHTML = currentYearElement.innerHTML.replace(
            /\d{4}/,
            currentYear
        );
    }
    
    
    // ========================================
    // Social Links - Track Clicks (Optional Analytics)
    // ========================================
    const socialLinks = document.querySelectorAll('.social-link');
    
    socialLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const platform = this.getAttribute('aria-label');
            console.log(`Social link clicked: ${platform}`);
            
            // You can add analytics tracking here
            // Example: gtag('event', 'social_click', { platform: platform });
        });
    });
    
    
    // ========================================
    // Payment Icons - Add Hover Effect Text (Optional)
    // ========================================
    const paymentIcons = document.querySelectorAll('.payment-icon');
    
    paymentIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
});


// ========================================
// Utility: Debounce Function
// ========================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}


// ========================================
// Optional: Lazy Load Footer Images
// ========================================
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    const images = document.querySelectorAll('.footer-main img[data-src]');
    images.forEach(img => imageObserver.observe(img));
}