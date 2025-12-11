{{-- File: resources/views/customer/hero-banner.blade.php --}}

<div class="hero-banner-container">
    <div class="hero-slider">
        <div class="hero-slide active">
            <img src="{{ asset('images/hero.png') }}" alt="PuffyBaby Collection" class="hero-background">
            
            <div class="hero-overlay"></div>
            
            <div class="hero-content">
                <div class="hero-breadcrumb">
                    <a href="{{ url('/') }}" class="breadcrumb-link">Home</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Shop</span>
                </div>
                <h1 class="hero-title">Shop</h1>
                <p class="hero-description">Discover Our Latest Collection</p>
            </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button class="hero-nav prev" onclick="navigateSlide(-1)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="hero-nav next" onclick="navigateSlide(1)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
</div>

<style>
.hero-banner-container {
    width: 100%;
    position: relative;
    margin-bottom: 60px;
}

.hero-slider {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
    border-radius: 0 0 40px 40px;
}

.hero-slide {
    position: relative;
    width: 100%;
    height: 100%;
    display: none;
}

.hero-slide.active {
    display: block;
}

.hero-background {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0) 100%);
}

.hero-content {
    position: absolute;
    top: 50%;
    left: 80px;
    transform: translateY(-50%);
    z-index: 2;
    color: white;
    max-width: 600px;
}

.hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    font-size: 14px;
}

.breadcrumb-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.breadcrumb-separator {
    color: rgba(255,255,255,0.7);
}

.breadcrumb-current {
    color: white;
    font-weight: 500;
}

.hero-title {
    font-size: 80px;
    font-weight: 700;
    color: white;
    margin: 0 0 15px 0;
    letter-spacing: -2px;
    line-height: 1;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
}

.hero-description {
    font-size: 18px;
    color: rgba(255,255,255,0.95);
    margin: 0;
    font-weight: 300;
    letter-spacing: 0.5px;
}

/* Navigation Arrows */
.hero-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.9);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    transition: all 0.3s ease;
    color: #333;
}

.hero-nav:hover {
    background: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.hero-nav.prev {
    left: 30px;
}

.hero-nav.next {
    right: 30px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .hero-slider {
        height: 450px;
    }
    
    .hero-content {
        left: 50px;
    }
    
    .hero-title {
        font-size: 64px;
    }
}

@media (max-width: 768px) {
    .hero-slider {
        height: 400px;
        border-radius: 0 0 30px 30px;
    }
    
    .hero-content {
        left: 30px;
        right: 30px;
    }
    
    .hero-title {
        font-size: 48px;
    }
    
    .hero-description {
        font-size: 16px;
    }
    
    .hero-nav {
        width: 40px;
        height: 40px;
    }
    
    .hero-nav.prev {
        left: 20px;
    }
    
    .hero-nav.next {
        right: 20px;
    }
}

@media (max-width: 480px) {
    .hero-slider {
        height: 350px;
    }
    
    .hero-content {
        left: 20px;
        right: 20px;
    }
    
    .hero-title {
        font-size: 36px;
    }
    
    .hero-breadcrumb {
        font-size: 12px;
    }
    
    .hero-description {
        font-size: 14px;
    }
    
    .hero-nav {
        width: 35px;
        height: 35px;
    }
}
</style>

<script>
function navigateSlide(direction) {
    // Placeholder untuk slider functionality
    // Nanti bisa ditambah multiple slides
    console.log('Navigate:', direction);
}
</script>