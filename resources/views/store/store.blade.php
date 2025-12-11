<style>
/* Store Info Card */
.store-info-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    border: 2px solid #E4D6C5;
    margin-bottom: 32px;
    box-shadow: 0 2px 8px rgba(152, 66, 22, 0.08);
}

.store-card-inner {
    display: grid;
    grid-template-columns: auto 1fr auto; /* 🔥 3 kolom stabil */
    gap: 20px;
    align-items: center; /* 🔥 Biar sejajar vertikal */
}

/* Logo */
.store-logo-wrapper {
    flex-shrink: 0;
}

.store-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #E4D6C5;
}

.store-logo-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #E4D6C5 0%, #F5E8DD 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    border: 3px solid #E4D6C5;
}

/* Details */
.store-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Header */
.store-header {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.store-name {
    font-size: 22px;
    font-weight: 700;
    color: #984216;
    margin: 0;
    line-height: 1.3;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* City */
.store-city {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 14px;
    font-weight: 500;
}

/* About */
.store-about {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
}

/* Actions (kanan) */
.store-actions {
    display: flex;
    flex-direction: row; /* ⬅️ horizontal */
    gap: 12px;
    justify-content: flex-end; /* ⬅️ tetap kanan */
    align-items: center; /* ⬅️ sejajar rapi */
}


/* Buttons */
.btn-whatsapp,
.btn-visit-store {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}

/* Chat button */
.btn-whatsapp {
    background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
    color: white;
}

/* Visit Store */
.btn-visit-store {
    background: white;
    color: #984216;
    border: 2px solid #984216;
}
/* --- tetapkan stylesheet sebelumnya di atas --- */

/* Responsive: mobile tweak */
@media (max-width: 768px) {
    /* Ubah layout jadi 2 kolom: logo | detail */
    .store-card-inner {
        display: grid;
        grid-template-columns: auto 1fr;
        grid-template-rows: auto auto; /* baris 1: nama+city+about, baris 2: aksi */
        gap: 12px;
        align-items: start;
        text-align: left;
    }

    /* Logo: di kolom 1, gunakan 2 baris agar logo tetap vertikal sejajar */
    .store-logo-wrapper {
        grid-column: 1;
        grid-row: 1 / span 2;
        justify-self: start;
    }

    /* Detail (nama, city, about) berada di kolom 2 baris 1 */
    .store-details {
        grid-column: 2;
        grid-row: 1;
        text-align: left;
        align-items: flex-start;
    }

    /* Nama dan badge tetap dalam satu baris (wrap jika perlu) */
    .store-header {
        justify-content: flex-start;
        gap: 8px;
    }

    .store-name {
        font-size: 20px;
        line-height: 1.15;
        margin: 0;
    }

    /* Aksi (chat + kunjungi) dipindah ke kolom 2 baris 2 => berada di bawah nama */
    .store-actions {
        grid-column: 2;
        grid-row: 2;
        justify-self: start;       /* tombol di bawah nama, sejajar kiri nama */
        width: auto;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 4px;
    }

    /* Tombol sedikit mengecil di mobile */
    .btn-whatsapp,
    .btn-visit-store {
        padding: 10px 16px;
        font-size: 13px;
    }

    /* Jika mau tombol ditengah (opsional): ubah justify-self:center; */
}


</style>


@if($product->store)
<div class="store-info-card">
    <div class="store-card-inner">

        {{-- LOGO --}}
        <div class="store-logo-wrapper">
            @if($product->store->logo)
                <img src="{{ asset('public/images/store/' . $product->store->logo) }}" 
                  alt="store logo" 
                  class="store-logo">

            @else
                <div class="store-logo-placeholder">
                    🏪
                </div>
            @endif
        </div>

        {{-- DETAIL --}}
        <div class="store-details">
            <div class="store-header">
                <h3 class="store-name">{{ $product->store->name }}</h3>

                @if($product->store->is_verified)
                <div class="verified-badge">
                    ✓ Terverifikasi
                </div>
                @endif
            </div>

            @if($product->store->city)
            <p class="store-city">
                📍 {{ $product->store->city }}
            </p>
            @endif

            @if($product->store->about)
            <p class="store-about">{{ Str::limit($product->store->about, 100) }}</p>
            @endif
        </div>

        {{-- TOMBOL (KANAN) --}}
        <div class="store-actions">

            {{-- CHAT --}}
            @if($product->store->phone)
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $product->store->phone);
                    if (substr($cleanPhone, 0, 1) === '0') {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                @endphp

                <a href="https://wa.me/{{ $cleanPhone }}" 
                   target="_blank" 
                   class="btn-whatsapp">
                     Chat
                </a>
            @endif

            {{-- VISIT STORE --}}
            <a href="{{ route('store.show', $product->store->id) }}" class="btn-visit-store">
                Kunjungi Toko
            </a>
        </div>

    </div>
</div>

@else
<div class="store-fallback">
    <p>Informasi toko tidak tersedia</p>
</div>
@endif

