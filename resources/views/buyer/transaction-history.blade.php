@extends('layouts.app')

@section('title', 'Riwayat Transaksi - FlexSport')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction-history.css') }}">

<div class="container">
    <div class="page-header">
        <h1>📋 Riwayat Transaksi</h1>
        <p>Lihat semua pesanan dan status pengiriman Anda</p>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="tab active" data-status="all">Semua</button>
        <button class="tab" data-status="unpaid">Belum Bayar</button>
        <button class="tab" data-status="paid">Sudah Bayar</button>
        <button class="tab" data-status="shipped">Dikirim</button>
        <button class="tab" data-status="completed">Selesai</button>
    </div>

    <!-- Transaction List -->
    <div class="transaction-list">
        <!-- Transaction Item 1 -->
        <div class="transaction-card" data-status="paid">
            <div class="card-header">
                <div class="store-info">
                    <span class="store-icon">🏪</span>
                    <div>
                        <strong>Sport Gear Pro</strong>
                        <span class="transaction-date">03 Des 2025, 14:30</span>
                    </div>
                </div>
                <span class="badge badge-paid">✅ Sudah Bayar</span>
            </div>

            <div class="card-body">
                <div class="product-info">
                    <img src="https://via.placeholder.com/80" alt="Product" class="product-image">
                    <div class="product-details">
                        <h4>Sepatu Futsal Nike Mercurial</h4>
                        <p class="product-meta">1x | Rp 450.000</p>
                        <span class="product-condition">✨ Baru</span>
                    </div>
                </div>

                <div class="transaction-details">
                    <div class="detail-row">
                        <span>Kode Transaksi</span>
                        <strong>TRX-20251203-001</strong>
                    </div>
                    <div class="detail-row">
                        <span>Metode Pembayaran</span>
                        <span>Transfer Bank BCA</span>
                    </div>
                    <div class="detail-row">
                        <span>Pengiriman</span>
                        <span>JNE Regular (3-5 hari)</span>
                    </div>
                    <div class="detail-row">
                        <span>No. Resi</span>
                        <strong class="tracking-number">JNE123456789</strong>
                    </div>
                    <div class="detail-row total">
                        <span>Total Pembayaran</span>
                        <strong class="price">Rp 499.500</strong>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-outline" onclick="trackOrder('JNE123456789')">
                    📦 Lacak Paket
                </button>
                <button class="btn btn-primary" onclick="viewDetail('TRX-20251203-001')">
                    👁️ Lihat Detail
                </button>
            </div>
        </div>

        <!-- Transaction Item 2 -->
        <div class="transaction-card" data-status="unpaid">
            <div class="card-header">
                <div class="store-info">
                    <span class="store-icon">🏪</span>
                    <div>
                        <strong>Olahraga Store</strong>
                        <span class="transaction-date">02 Des 2025, 10:15</span>
                    </div>
                </div>
                <span class="badge badge-unpaid">⏳ Belum Bayar</span>
            </div>

            <div class="card-body">
                <div class="product-info">
                    <img src="https://via.placeholder.com/80" alt="Product" class="product-image">
                    <div class="product-details">
                        <h4>Raket Badminton Yonex</h4>
                        <p class="product-meta">1x | Rp 750.000</p>
                        <span class="product-condition">✨ Baru</span>
                    </div>
                </div>

                <div class="transaction-details">
                    <div class="detail-row">
                        <span>Kode Transaksi</span>
                        <strong>TRX-20251202-002</strong>
                    </div>
                    <div class="detail-row">
                        <span>Metode Pembayaran</span>
                        <span>E-Wallet (GoPay)</span>
                    </div>
                    <div class="detail-row">
                        <span>Batas Pembayaran</span>
                        <strong style="color: #dc3545;">03 Des 2025, 10:15</strong>
                    </div>
                    <div class="detail-row total">
                        <span>Total Pembayaran</span>
                        <strong class="price">Rp 807.500</strong>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-danger" onclick="cancelOrder('TRX-20251202-002')">
                    ❌ Batalkan
                </button>
                <button class="btn btn-success" onclick="payNow('TRX-20251202-002')">
                    💳 Bayar Sekarang
                </button>
            </div>
        </div>

        <!-- Transaction Item 3 -->
        <div class="transaction-card" data-status="completed">
            <div class="card-header">
                <div class="store-info">
                    <span class="store-icon">🏪</span>
                    <div>
                        <strong>Sport Equipment</strong>
                        <span class="transaction-date">25 Nov 2025, 16:45</span>
                    </div>
                </div>
                <span class="badge badge-completed">✅ Selesai</span>
            </div>

            <div class="card-body">
                <div class="product-info">
                    <img src="https://via.placeholder.com/80" alt="Product" class="product-image">
                    <div class="product-details">
                        <h4>Bola Basket Molten</h4>
                        <p class="product-meta">2x | Rp 600.000</p>
                        <span class="product-condition">✨ Baru</span>
                    </div>
                </div>

                <div class="transaction-details">
                    <div class="detail-row">
                        <span>Kode Transaksi</span>
                        <strong>TRX-20251125-003</strong>
                    </div>
                    <div class="detail-row">
                        <span>Diterima Tanggal</span>
                        <span>28 Nov 2025</span>
                    </div>
                    <div class="detail-row total">
                        <span>Total Pembayaran</span>
                        <strong class="price">Rp 666.000</strong>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-outline" onclick="buyAgain()">
                    🔄 Beli Lagi
                </button>
                <button class="btn btn-warning" onclick="reviewProduct('TRX-20251125-003')">
                    ⭐ Beri Ulasan
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State (Hidden by default) -->
    <div class="empty-state" style="display: none;">
        <div class="empty-icon">📭</div>
        <h3>Belum Ada Transaksi</h3>
        <p>Yuk mulai belanja produk olahraga favoritmu!</p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            🛍️ Mulai Belanja
        </a>
    </div>
</div>

<script>
// Filter tabs functionality
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.dataset.status;
        const cards = document.querySelectorAll('.transaction-card');
        
        cards.forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

function trackOrder(trackingNumber) {
    alert(`🚚 Melacak paket dengan resi: ${trackingNumber}\n\nFitur tracking akan terintegrasi dengan API kurir.`);
}

function viewDetail(transactionCode) {
    alert(`📋 Menampilkan detail transaksi: ${transactionCode}`);
}

function cancelOrder(transactionCode) {
    if (confirm(`Yakin ingin membatalkan pesanan ${transactionCode}?`)) {
        alert('✅ Pesanan berhasil dibatalkan');
    }
}

function payNow(transactionCode) {
    alert(`💳 Mengarahkan ke halaman pembayaran untuk ${transactionCode}`);
}

function buyAgain() {
    alert('🔄 Produk ditambahkan ke keranjang');
}

function reviewProduct(transactionCode) {
    alert(`⭐ Buka form review untuk transaksi ${transactionCode}`);
}
</script>
@endsection