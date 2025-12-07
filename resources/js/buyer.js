/**
 * Buyer JavaScript - Complete
 * File: resources/js/buyer.js
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Profile Dropdown
    initProfileDropdown();
    
    // Auto Hide Alerts
    autoHideAlerts();
    
});

/**
 * Profile Dropdown Functionality
 */
function initProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    const overlay = document.getElementById('dropdownOverlay');
    
    if (!dropdown) return;
    
    const trigger = dropdown.querySelector('.profile-trigger');
    
    // Toggle dropdown
    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
        overlay.classList.toggle('active');
    });
    
    // Close on overlay click
    overlay.addEventListener('click', function() {
        dropdown.classList.remove('active');
        overlay.classList.remove('active');
    });
    
    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
            overlay.classList.remove('active');
        }
    });
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            dropdown.classList.remove('active');
            overlay.classList.remove('active');
        }
    });
}

/**
 * Auto Hide Alerts after 5 seconds
 */
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});