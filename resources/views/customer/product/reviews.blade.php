{{-- ============================================================
FILE: resources/views/customer/product/reviews.blade.php
PARTIAL VIEW untuk Product Reviews
USAGE: @include('customer.product.reviews', ['product' => $product])
============================================================ --}}

<style>
/* Product Reviews Styles - Puffy Baby Theme */
.reviews-container {
    margin: 2rem 0;
    padding: 1.5rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.reviews-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #E4D6C5;
}

.rating-summary {
    text-align: center;
}

.rating-number {
    font-size: 3rem;
    font-weight: bold;
    color: #984216;
    line-height: 1;
}

.rating-stars {
    color: #FFD700;
    font-size: 1.5rem;
    margin: 0.5rem 0;
}

.rating-count {
    color: #8D957E;
    font-size: 0.9rem;
}

.review-item {
    padding: 1.5rem;
    border: 1px solid #E4D6C5;
    border-radius: 8px;
    margin-bottom: 1rem;
    background: #FAFAFA;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.reviewer-name {
    font-weight: 600;
    color: #984216;
}

.review-date {
    font-size: 0.85rem;
    color: #8D957E;
}

.review-rating {
    color: #FFD700;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.review-text {
    color: #333;
    line-height: 1.6;
}

.review-form {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #F9F5F1;
    border: 2px solid #E4D6C5;
    border-radius: 8px;
}

.review-form h3 {
    color: #984216;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #984216;
    margin-bottom: 0.5rem;
}

.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #E4D6C5;
    border-radius: 6px;
    font-family: inherit;
    font-size: 1rem;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.btn-submit {
    background: #984216;
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover {
    background: #7a3412;
}

.btn-submit:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn-login {
    display: inline-block;
    background: #8D957E;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}

.btn-login:hover {
    background: #6d7560;
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.pagination-controls button {
    padding: 0.5rem 1.5rem;
    background: #E4D6C5;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    color: #984216;
}

.pagination-controls button:hover:not(:disabled) {
    background: #d4c6b5;
}

.pagination-controls button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.message {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}

.message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.no-reviews {
    text-align: center;
    padding: 2rem;
    color: #8D957E;
    font-style: italic;
}
</style>

<div class="reviews-container" id="reviews-container" data-product-id="{{ $product->id }}">
    {{-- Reviews Header with Average Rating --}}
    <div class="reviews-header">
        <div class="rating-summary">
            <div class="rating-number" id="avg-rating">0</div>
            <div class="rating-stars" id="avg-stars">☆☆☆☆☆</div>
            <div class="rating-count" id="total-reviews">(0 Reviews)</div>
        </div>
        <div style="flex: 1;">
            <h2 style="color: #984216; margin: 0;">Rating & Reviews</h2>
        </div>
    </div>

    {{-- Message Area --}}
    <div id="message-area"></div>

    {{-- Reviews List --}}
    <div id="reviews-list">
        <div class="no-reviews">Loading reviews...</div>
    </div>

    {{-- Pagination Controls --}}
    <div class="pagination-controls" id="pagination-controls" style="display: none;">
        <button id="prev-btn" onclick="loadReviews(currentPage - 1)">« Previous</button>
        <span id="page-info" style="align-self: center; color: #8D957E;"></span>
        <button id="next-btn" onclick="loadReviews(currentPage + 1)">Next »</button>
    </div>

    {{-- Form review dihapus - akan ditampilkan di halaman order history --}}
</div>

<script>
// Product Reviews JavaScript
(function() {
    const productId = document.getElementById('reviews-container').dataset.productId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    let currentPage = 1;
    let lastPage = 1;

    // Load reviews from API
    window.loadReviews = function(page = 1) {
        if (page < 1 || page > lastPage) return;
        
        currentPage = page;
        
        fetch(`/product/${productId}/reviews?page=${page}`)
            .then(response => response.json())
            .then(data => {
                updateRatingSummary(data.avg_rating, data.total);
                renderReviews(data.data);
                updatePagination(data.current_page, data.last_page);
                lastPage = data.last_page;
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
                showMessage('Failed to load reviews. Please try again.', 'error');
            });
    };

    // Update rating summary
    function updateRatingSummary(avgRating, total) {
        document.getElementById('avg-rating').textContent = avgRating.toFixed(1);
        document.getElementById('avg-stars').textContent = getStarDisplay(avgRating);
        document.getElementById('total-reviews').textContent = `(${total} Review${total !== 1 ? 's' : ''})`;
    }

    // Render reviews list
    function renderReviews(reviews) {
        const listContainer = document.getElementById('reviews-list');
        
        if (reviews.length === 0) {
            listContainer.innerHTML = '<div class="no-reviews">No reviews yet. Be the first to review this product!</div>';
            return;
        }

        listContainer.innerHTML = reviews.map(review => `
            <div class="review-item">
                <div class="review-header">
                    <span class="reviewer-name">${escapeHtml(review.user_name)}</span>
                    <span class="review-date">${review.created_at_human}</span>
                </div>
                <div class="review-rating">${getStarDisplay(review.rating)}</div>
                <div class="review-text">${escapeHtml(review.review)}</div>
            </div>
        `).join('');
    }

    // Update pagination controls
    function updatePagination(current, last) {
        const paginationControls = document.getElementById('pagination-controls');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const pageInfo = document.getElementById('page-info');

        if (last <= 1) {
            paginationControls.style.display = 'none';
            return;
        }

        paginationControls.style.display = 'flex';
        prevBtn.disabled = current <= 1;
        nextBtn.disabled = current >= last;
        pageInfo.textContent = `Page ${current} of ${last}`;
    }

    // Submit review via AJAX - Dihapus karena form dipindah ke order history
    // Function ini bisa dipakai di halaman order history nanti

    // Show message
    function showMessage(message, type) {
        const messageArea = document.getElementById('message-area');
        messageArea.innerHTML = `<div class="message ${type}">${escapeHtml(message)}</div>`;
        
        setTimeout(() => {
            messageArea.innerHTML = '';
        }, 5000);
    }

    // Get star display based on rating
    function getStarDisplay(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        
        return '★'.repeat(fullStars) + 
               (hasHalfStar ? '⯨' : '') + 
               '☆'.repeat(emptyStars);
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initial load
    loadReviews(1);
})();
</script>