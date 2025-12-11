 👔 Mpruy Store

**Mpruy Store** adalah platform e-commerce eksklusif yang didedikasikan untuk menyediakan pakaian formal berkualitas tinggi, mencakup atasan (**Tops**) dan bawahan (**Bottoms**). Kami berkomitmen untuk memberikan pengalaman belanja online yang sempurna, elegan, dan memuaskan bagi para profesional yang mengutamakan gaya dan kualitas.

Nikmati pengalaman berbelanja yang mulus, diskon menarik, dan koleksi eksklusif yang dikurasi khusus untuk menunjang penampilan profesional Anda.

 ✨ Fitur Unggulan

- **Koleksi Eksklusif**: Fokus pada pakaian formal (Tops & Bottoms) dengan bahan premium.
- **Pengalaman E-Commerce Lengkap**: Mulai dari katalog produk, keranjang belanja, hingga proses checkout yang mudah.
- **Manajemen Seller Canggih**: Dashboard khusus seller untuk mengelola produk, pesanan, dan penarikan dana instan.
- **Verifikasi Toko**: Sistem keamanan dengan verifikasi admin untuk memastikan kredibilitas seller.
- **Promo & Penawaran**: Berbagai promo menarik untuk pelanggan setia.

---

## 📂 Struktur Folder Proyek

Berikut adalah gambaran umum struktur folder proyek ini (berbasis Laravel):

```
e-commerce-group-4/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Logika bisnis (Admin, Seller, User)
│   │   │   ├── Admin/          # Controller khusus fitur Admin
│   │   │   ├── Seller/         # Controller khusus fitur Seller (Dashboard, Produk, dll)
│   │   │   └── User/           # Controller fitur User (Belanja, Checkout)
│   │   └── Middleware/         # Middleware untuk autentikasi role
│   └── Models/                 # Model Database (Product, Store, Transaction, dll)
├── database/
│   └── migrations/             # Skema Database
├── resources/
│   ├── views/                  # Tampilan Antarmuka (Blade Templates)
│   │   ├── admin/              # View untuk Admin
│   │   ├── seller/             # View untuk Dashboard Seller
│   │   ├── user/               # View untuk Storefront User
│   │   └── layouts/            # Layout utama aplikasi
│   └── css/                    # File CSS (Tailwind)
├── routes/
│   └── web.php                 # Definisi Rute Aplikasi
└── public/
    └── images/                 # Aset gambar produk dan banner
```

---

## ⚠️ Masalah yang Diketahui (Known Issues)

### Konflik Sesi Multi-Akun (Login User, Admin, & Seller)

**Masalah:**
Sistem autentikasi saat ini menggunakan sesi browser tunggal. Jika Anda mencoba login sebagai **User**, **Admin**, dan **Seller** secara bersamaan dalam satu browser yang sama (meskipun di tab yang berbeda), sesi login terakhir akan menimpa sesi sebelumnya.

**Dampak:**
- Dashboard Seller mungkin akan berubah menjadi tampilan User, atau sebaliknya.
- Terjadi kesalahan "Unauthorized action" atau redirect yang tidak sesuai.
- Data yang ditampilkan mungkin tertukar antar peran.

**Solusi Sementara:**
Untuk menghindari masalah ini saat melakukan pengujian atau penggunaan:
1.  Gunakan **Browser yang Berbeda** untuk setiap akun (Contoh: Chrome untuk Admin, Firefox untuk Seller, Edge untuk User).
2.  Atau gunakan fitur **Incognito / Private Window** untuk login ke akun kedua atau ketiga.
3.  Pastikan untuk **Logout** terlebih dahulu sebelum berganti akun di browser yang sama.

---

**Developed by Group 4**
*Pemrograman Web Lanjut - Semester 3*