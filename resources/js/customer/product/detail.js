// Product Detail Page JavaScript

// Change main image function
function changeMainImage(imageSrc, element) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    if (element) {
        element.classList.add('active');
    }
}

// Quantity selector
document.addEventListener('DOMContentLoaded', function() {
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    const qtyInput = document.getElementById('qtyInput');

    if (decreaseBtn && increaseBtn && qtyInput) {
        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value > parseInt(qtyInput.min)) {
                qtyInput.value = value - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value < parseInt(qtyInput.max)) {
                qtyInput.value = value + 1;
            }
        });

        qtyInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            let min = parseInt(this.min);
            let max = parseInt(this.max);
            
            if (isNaN(value) || value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
        });
    }
});