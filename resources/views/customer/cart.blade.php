{{-- ============================================================
FILE: resources/views/customer/cart.blade.php
Shopping Cart Page - Session Based
============================================================ --}}

<x-app-layout>
    <style>
        /* Shopping Cart Styles - Puffy Baby Theme */
        
        /* Breadcrumb - Same as Product Detail */
        .breadcrumb-wrapper {
            background: linear-gradient(135deg, #E4D6C5 0%, #F5E8DD 100%);
            padding: 20px 0;
            border-bottom: 3px solid rgba(152, 66, 22, 0.1);
        }

        .breadcrumb-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .breadcrumb-link {
            color: #984216;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .breadcrumb-link:hover {
            color: #78898F;
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #8D957E;
            font-size: 18px;
            font-weight: 300;
        }

        .breadcrumb-current {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            background: #FEFEFE;
            min-height: calc(100vh - 200px);
        }

        .cart-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .cart-table {
            width: 100%;
            margin-bottom: 2rem;
        }

        .cart-table th {
            text-align: left;
            padding: 1rem 0.5rem;
            border-bottom: 2px solid #E4D6C5;
            color: #984216;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cart-item {
            border-bottom: 1px solid #F0F0F0;
        }

        .cart-item td {
            padding: 1.5rem 0.5rem;
            vertical-align: middle;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #E4D6C5;
        }

        .product-details h3 {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .product-sku {
            font-size: 0.85rem;
            color: #8D957E;
        }

        .price-cell {
            font-weight: 600;
            color: #984216;
        }

        /* Fixed Quantity Selector */
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            border: 2px solid #E4D6C5;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            font-size: 18px;
            font-weight: 700;
            color: #984216;
            line-height: 1;
        }

        .qty-btn:hover:not(:disabled) {
            background: #984216;
            color: white;
            border-color: #984216;
            transform: scale(1.05);
        }

        .qty-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .qty-input {
            width: 60px;
            height: 36px;
            text-align: center;
            border: 2px solid #E4D6C5;
            border-radius: 6px;
            padding: 0;
            font-weight: 700;
            font-size: 16px;
            color: #333;
        }

        .qty-input:focus {
            outline: none;
            border-color: #984216;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.2s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .remove-btn:hover {
            background: #FFEBEE;
            color: #e74c3c;
        }

        .cart-summary {
            border-top: 2px solid #E4D6C5;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        .cart-note {
            background: linear-gradient(135deg, #F9F5F1 0%, #FEFEFE 100%);
            padding: 1.5rem;
            border-radius: 12px;
            border: 2px solid #E4D6C5;
        }

        .cart-note h3 {
            color: #984216;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cart-note textarea {
            width: 100%;
            border: 2px solid #E4D6C5;
            border-radius: 8px;
            padding: 0.75rem;
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .cart-note textarea:focus {
            outline: none;
            border-color: #984216;
        }

        .cart-totals {
            background: linear-gradient(135deg, #F9F5F1 0%, #FEFEFE 100%);
            padding: 1.5rem;
            border-radius: 12px;
            border: 2px solid #E4D6C5;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .total-row.grand {
            border-top: 2px solid #E4D6C5;
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            font-weight: 700;
            font-size: 1.2rem;
            color: #984216;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(152, 66, 22, 0.3);
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(152, 66, 22, 0.4);
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-cart-icon {
            font-size: 4rem;
            color: #E4D6C5;
            margin-bottom: 1rem;
        }

        .empty-cart h3 {
            color: #984216;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .empty-cart p {
            color: #8D957E;
            margin-bottom: 1.5rem;
        }

        .continue-shopping {
            display: inline-block;
            background: #8D957E;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .continue-shopping:hover {
            background: #6d7560;
            transform: translateY(-2px);
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            z-index: 9999;
            display: none;
            animation: slideIn 0.3s;
            border-left: 4px solid;
        }

        .toast.success {
            border-left-color: #27ae60;
        }

        .toast.error {
            border-left-color: #e74c3c;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Loading state */
        .cart-item.updating {
            opacity: 0.6;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
            
            .cart-table {
                font-size: 0.85rem;
            }
            
            .product-image {
                width: 60px;
                height: 60px;
            }

            .qty-btn {
                width: 32px;
                height: 32px;
                font-size: 16px;
            }

            .qty-input {
                width: 50px;
                height: 32px;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="breadcrumb-container">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-current">Shopping Cart</span>
        </div>
    </div>

    <div class="cart-container">
        @if(session('success'))
            <div class="toast success" style="display: block;">
                {{ session('success') }}
            </div>
        @endif

        <div class="cart-content">
            @if(count($cartItems) > 0)
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="cart-item" data-product-id="{{ $item['product']->id }}">
                                <td>
                                    <div class="product-info">
                                        @php
                                            // Check for productImages collection first (new format)
                                            $hasImagesCollection = isset($item['product']->productImages) && $item['product']->productImages->count() > 0;
                                            
                                            if ($hasImagesCollection) {
                                                $mainImageRecord = $item['product']->productImages->firstWhere('is_thumbnail', true) ?? $item['product']->productImages->first();
                                                $mainImagePath = $mainImageRecord->image ?? null;
                                                $imageExists = $mainImagePath && file_exists(public_path($mainImagePath));
                                                $imageUrl = $imageExists ? asset($mainImagePath) : "https://placehold.co/80x80/E4D6C5/984216?text=" . urlencode(Str::limit($item['product']->name, 10));
                                            } elseif (isset($item['product']->image) && $item['product']->image) {
                                                // Fallback to old single image format
                                                $imageUrl = asset('storage/' . $item['product']->image);
                                            } else {
                                                $imageUrl = "https://placehold.co/80x80/E4D6C5/984216?text=No+Image";
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $item['product']->name }}" 
                                             class="product-image"
                                             onerror="this.src='https://placehold.co/80x80/E4D6C5/984216?text=Error'">
                                        <div class="product-details">
                                            <h3>{{ $item['product']->name }}</h3>
                                            <p class="product-sku">#{{ $item['product']->sku ?? $item['product']->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="price-cell">
                                    Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="quantity-selector" data-product-id="{{ $item['product']->id }}">
                                        <button class="qty-btn qty-decrease" 
                                                type="button" 
                                                data-product-id="{{ $item['product']->id }}"
                                                aria-label="Decrease quantity">
                                            −
                                        </button>

                                        <input type="number"
                                               class="qty-input"
                                               data-product-id="{{ $item['product']->id }}"
                                               value="{{ $item['qty'] }}"
                                               min="1"
                                               max="{{ $item['product']->stock }}"
                                               aria-label="Quantity">

                                        <button class="qty-btn qty-increase" 
                                                type="button" 
                                                data-product-id="{{ $item['product']->id }}"
                                                aria-label="Increase quantity">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="price-cell item-total-{{ $item['product']->id }}">
                                    Rp {{ number_format($item['item_total'], 0, ',', '.') }}
                                </td>
                                <td>
                                    <button class="remove-btn" 
                                            type="button" 
                                            data-product-id="{{ $item['product']->id }}"
                                            aria-label="Remove item">
                                        ✕
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-grid">
                    <div class="cart-note">
                        <h3>📝 Add a Note</h3>
                        <textarea placeholder="Add special instructions or notes for your order..." id="cart-note"></textarea>
                    </div>

                    <div class="cart-totals">
                        <div class="total-row">
                            <span>Cart Subtotal:</span>
                            <span id="cart-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="total-row">
                            <span style="font-size: 0.85rem; color: #8D957E;">Shipping & taxes calculated at checkout</span>
                        </div>
                        <div class="total-row grand">
                            <span>CART TOTAL:</span>
                            <span id="cart-grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <button class="checkout-btn" onclick="checkout()">
                            🔒 Proceed to Checkout
                        </button>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('dashboard') }}" class="continue-shopping">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function formatMoney(val) {
    return 'Rp ' + Number(val).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function safeQuery(selector) {
    return document.querySelector(selector);
}

/* Update quantity (+ or -) */
function updateQuantity(productId, change) {
    const input = document.querySelector(`.cart-item[data-product-id="${productId}"] .qty-input`);
    if (!input) return;
    
    const currentQty = parseInt(input.value) || 1;
    const newQty = currentQty + change;
    const maxStock = parseInt(input.max) || 999;

    if (newQty < 1) return;
    if (newQty > maxStock) {
        showToast('Stock not available', 'error');
        return;
    }

    updateCart(productId, newQty);
}

/* Update quantity from manual input */
function updateQuantityInput(productId, value) {
    const qty = parseInt(value) || 1;
    const input = document.querySelector(`.cart-item[data-product-id="${productId}"] .qty-input`);
    if (!input) return;
    
    const maxStock = parseInt(input.max) || 999;
    
    if (qty < 1) {
        input.value = 1;
        return;
    }
    if (qty > maxStock) {
        showToast('Stock not available', 'error');
        input.value = maxStock;
        return;
    }
    updateCart(productId, qty);
}

/* AJAX update call */
function updateCart(productId, quantity) {
    const itemRow = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
    if (itemRow) itemRow.classList.add('updating');

    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(res => res.json())
    .then(data => {
        if (itemRow) itemRow.classList.remove('updating');
        if (!data) return showToast('Invalid server response', 'error');

        if (data.success) {
            // Update item total
            if (typeof data.item_total !== 'undefined') {
                const el = safeQuery(`.item-total-${productId}`);
                if (el) el.textContent = formatMoney(data.item_total);
            }
            // Update totals
            const subEl = safeQuery('#cart-subtotal');
            if (subEl && typeof data.subtotal !== 'undefined') subEl.textContent = formatMoney(data.subtotal);
            const grandEl = safeQuery('#cart-grand-total');
            if (grandEl && typeof data.grand_total !== 'undefined') grandEl.textContent = formatMoney(data.grand_total);

            // Sync input value
            const input = document.querySelector(`.cart-item[data-product-id="${productId}"] .qty-input`);
            if (input) input.value = quantity;

            if (data.message) showToast(data.message, 'success');
        } else {
            showToast(data.message || 'Failed to update cart', 'error');
        }
    })
    .catch(err => {
        console.error('Update error', err);
        if (itemRow) itemRow.classList.remove('updating');
        showToast('Failed to update cart', 'error');
    });
}

/* Remove item */
function removeItem(productId) {
    if (!confirm('Remove this item from cart?')) return;

    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (!data) return showToast('Invalid server response', 'error');

        if (data.success) {
            // Remove row from DOM
            const row = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
            if (row) {
                row.style.transition = 'opacity 0.3s';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            }

            // Update totals
            const subEl = safeQuery('#cart-subtotal');
            if (subEl && typeof data.subtotal !== 'undefined') subEl.textContent = formatMoney(data.subtotal);
            const grandEl = safeQuery('#cart-grand-total');
            if (grandEl && typeof data.grand_total !== 'undefined') grandEl.textContent = formatMoney(data.grand_total);

            showToast(data.message || 'Item removed', 'success');

            if (data.cart_empty) {
                setTimeout(() => window.location.reload(), 1000);
            }
        } else {
            showToast(data.message || 'Failed to remove item', 'error');
        }
    })
    .catch(err => {
        console.error('Remove error', err);
        showToast('Failed to remove item', 'error');
    });
}

/* Checkout redirect */
function checkout() {
    const note = document.getElementById('cart-note')?.value;
    window.location.href = '/checkout' + (note ? '?note=' + encodeURIComponent(note) : '');
}

/* Toast notification */
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    if (!toast) {
        alert(message);
        return;
    }
    toast.textContent = message;
    toast.className = `toast ${type}`;
    toast.style.display = 'block';
    
    if (type === 'error') {
        toast.style.background = '#FDECEA';
        toast.style.color = '#C62828';
    } else {
        toast.style.background = '#EDF7ED';
        toast.style.color = '#2E7D32';
    }
    
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

/* Initialize */
document.addEventListener('DOMContentLoaded', () => {
    // Auto-hide session success toast
    const successToast = document.querySelector('.toast.success');
    if (successToast) setTimeout(() => successToast.style.display = 'none', 3000);

    // Delegated click listeners
    document.body.addEventListener('click', function(e) {
        if (e.target.matches('.qty-increase')) {
            const id = e.target.dataset.productId;
            updateQuantity(id, 1);
        } else if (e.target.matches('.qty-decrease')) {
            const id = e.target.dataset.productId;
            updateQuantity(id, -1);
        } else if (e.target.matches('.remove-btn')) {
            const id = e.target.dataset.productId;
            removeItem(id);
        }
    });

    // Debounced input listener
    let timer;
    document.body.addEventListener('input', function(e) {
        if (e.target.matches('.qty-input')) {
            clearTimeout(timer);
            const el = e.target;
            timer = setTimeout(() => {
                const id = el.closest('.cart-item')?.dataset.productId;
                if (id) updateQuantityInput(id, el.value);
            }, 500);
        }
    });
});
    </script>
</x-app-layout>