{{-- File: resources/views/customer/categories.blade.php --}}
 <style>
/* File: resources/css/customer/category.css */

.category-section {
    width: 100%;
    padding: 3rem 1rem;
    background: linear-gradient(180deg, #FFFFFF 0%, #F5F5F0 100%);
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 2rem;
    max-width: 1280px;
    margin: 0 auto;
    justify-items: center;
}

.category-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    cursor: default;
    transition: all 0.3s ease;
}

.category-item:hover {
    transform: translateY(-4px);
}

.category-circle {
    position: relative;
    width: 96px;
    height: 96px;
    border-radius: 50%;
    overflow: hidden;
    background: #FFFFFF;
    border: 2px solid #E4D6C5;
    box-shadow: 0 2px 8px rgba(141, 149, 126, 0.15);
    transition: all 0.3s ease;
}

.category-item:hover .category-circle {
    transform: scale(1.05);
    box-shadow: 0 4px 16px rgba(141, 149, 126, 0.25);
    border-color: #8D957E;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-item:hover .category-image {
    transform: scale(1.1);
}

.category-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #F5F5F0 0%, #E4D6C5 100%);
    color: #8D957E;
}

.category-icon {
    width: 48px;
    height: 48px;
}

.category-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border: 2px solid #FFFFFF;
    animation: pulse 2s ease-in-out infinite;
}

.category-badge-sale {
    background: linear-gradient(135deg, #984216 0%, #B85A29 100%);
    color: #FFFFFF;
}

.category-badge-new {
    background: linear-gradient(135deg, #8D957E 0%, #A4AE96 100%);
    color: #FFFFFF;
}

.category-badge-gift {
    background: linear-gradient(135deg, #78898F 0%, #8D9BA0 100%);
    color: #FFFFFF;
}

.badge-icon {
    width: 14px;
    height: 14px;
}

.category-info {
    text-align: center;
    max-width: 120px;
}

.category-name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #8D957E;
    margin: 0 0 0.25rem 0;
    line-height: 1.3;
}

.category-count {
    font-size: 0.8125rem;
    color: #78898F;
    margin: 0;
    font-weight: 400;
}

.category-empty {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    gap: 1rem;
}

.empty-icon {
    width: 64px;
    height: 64px;
    color: #8D957E;
    opacity: 0.5;
}

.empty-text {
    font-size: 1rem;
    color: #78898F;
    margin: 0;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@media (max-width: 1024px) {
    .category-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .category-section {
        padding: 2rem 0;
        overflow-x: hidden;
    }

  .category-grid {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 1.5rem;
    padding: 0 1rem;
    justify-items: unset;

    /* hide scrollbar */
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;     /* Firefox */
}

    .category-grid::-webkit-scrollbar {
        height: 6px;
    }

   .category-grid::-webkit-scrollbar {
    display: none;  /* Chrome, Safari, Opera */
}

    .category-grid::-webkit-scrollbar-thumb {
        background: #E4D6C5;
        border-radius: 10px;
    }

    .category-grid::-webkit-scrollbar-thumb:hover {
        background: #8D957E;
    }

    .category-item {
        flex: 0 0 auto;
        scroll-snap-align: start;
        width: 100px;
    }

    .category-circle {
        width: 80px;
        height: 80px;
    }

    .category-icon {
        width: 40px;
        height: 40px;
    }

    .category-name {
        font-size: 0.875rem;
    }

    .category-count {
        font-size: 0.75rem;
    }

    .category-info {
        max-width: 100px;
    }
}

@media (max-width: 640px) {
    .category-item {
        width: 90px;
    }

    .category-circle {
        width: 72px;
        height: 72px;
    }

    .category-badge {
        width: 24px;
        height: 24px;
    }

    .badge-icon {
        width: 12px;
        height: 12px;
    }

    .category-name {
        font-size: 0.8125rem;
    }
}
</style>

<div class="category-section">
    <div class="category-grid">
        @forelse($categories as $category)
            <div class="category-item"
                 aria-label="{{ $category->name }} category with {{ $category->products_count }} products">
                
                <div class="category-circle">
                    @if($category->image)
                        <img src="{{ asset($category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="category-image"
                             loading="lazy">
                    @else
                        {{-- Fallback SVG Icon --}}
                        <div class="category-fallback">
                            <svg class="category-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    @if($category->tagline && (stripos($category->tagline, 'sale') !== false || stripos($category->tagline, 'discount') !== false))
                        <span class="category-badge category-badge-sale">
                            {{-- Sale Icon --}}
                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @elseif($category->tagline && stripos($category->tagline, 'new') !== false)
                        <span class="category-badge category-badge-new">
                            {{-- Star Icon --}}
                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </span>
                    @elseif($category->tagline && stripos($category->tagline, 'gift') !== false)
                        <span class="category-badge category-badge-gift">
                            {{-- Gift Icon --}}
                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                            </svg>
                        </span>
                    @endif
                </div>
                
                <div class="category-info">
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <p class="category-count">{{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}</p>
                </div>
            </div>
        @empty
            <div class="category-empty">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="empty-text">No categories available</p>
            </div>
        @endforelse
    </div>
</div>