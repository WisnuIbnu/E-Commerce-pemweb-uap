<p align="center">
  <h1 align="center" style="color:#4B47FF">🛒 TechStore – E-Commerce Elektronik dengan Laravel 12</h1>
</p>

TechStore adalah aplikasi marketplace modern yang dibangun menggunakan **Laravel 12** dan **Laravel Breeze** sebagai starter kit Authentication.  
Aplikasi ini menyediakan fitur lengkap untuk menghubungkan **Customer**, **Seller**, dan **Admin** dalam satu platform e-commerce.

TechStore berfokus pada penjualan berbagai **produk elektronik**, seperti:

- Laptop  
- Smartphone  
- Aksesoris komputer  
- Gadget & perangkat elektronik lainnya  

Platform ini memungkinkan pengguna untuk:
- Menjelajahi katalog produk elektronik
- Melakukan pembelian & checkout
- Mengelola toko (untuk seller)
- Admin dapat memverifikasi toko & mengelola pengguna

TechStore dirancang dengan struktur CRUD yang jelas, UI minimalis modern, serta alur yang mudah dipahami untuk pengembangan dan penilaian UAP.



---

## 📦 Fitur Utama

### 👤 Customer (User)
1. **Homepage**
   - List semua produk
   - List produk berdasarkan kategori
2. **Product Page**
   - Detail produk, gambar, kategori, dan review
3. **Checkout Page**
   - Mengisi alamat, jenis pengiriman, dan menyelesaikan pembelian
4. **Transaction History**
   - Melihat riwayat transaksi dan detail pembelian

---

### 🏬 Seller Dashboard
1. **Store Registration Page**
   - Registrasi/pendaftaran toko
2. **Order Management Page**
   - Melihat dan mengelola pesanan yang masuk
3. **Store Balance Page**
   - Melihat saldo toko dan riwayat saldo
4. **Withdrawal Page**
   - Request penarikan dana dan melihat riwayat tarik dana
   - Mengelola data bank (nama bank, nama pemilik rekening, nomor rekening)
5. **Seller Store Page**
   - Mengelola profil toko (update/delete)
   - CRUD produk
   - CRUD kategori produk
   - CRUD gambar produk

---

### 🛠 Admin (Owner E-Commerce)
1. **Store Verification Page**
   - Verifikasi atau menolak pengajuan toko baru
2. **User & Store Management Page**
   - Melihat dan mengelola seluruh user dan toko

---

## 🗄 Struktur Database

Struktur database mengikuti diagram berikut:

![db structure](https://github.com/WisnuIbnu/E-Commerce-pemweb-uap/blob/main/public/db_structure.png?raw=true)

---

## ⚙️ Requirements

Pastikan environment kamu sudah memenuhi:

- PHP **>= 8.3**
- Composer
- Node.js & NPM
- MySQL / MariaDB / PostgreSQL / SQLite
- Git

---

## 🚀 Cara Menjalankan Project (Local Setup)

Langkah-langkah untuk menjalankan project di lokal:

---

1️⃣ Clone Repository

```bash
git https://github.com/arkadianabi/e-commerce-group-2.git
cd e-commerce-group-2

2️⃣ Install Dependency PHP
composer install

3️⃣ Setup File Environment

Copy file .env.example menjadi .env:
cp .env.example .env

Lalu edit konfigurasi database di .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_commerce_uap
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Generate Application Key
php artisan key:generate

5️⃣ Migrasi Database (+ Optional Seeder)

Tanpa seeder:
php artisan migrate

Dengan seeder (jika ingin data dummy):
php artisan migrate --seed

6️⃣ Jalankan Server Laravel
php artisan serve

Akses lewat browser:
http://localhost:8000

7️⃣ Install Dependency Frontend

Di terminal lain, jalankan:
npm install

Build asset:
npm run build

Untuk mode development (hot reload):
npm run dev

🔑 Akun Default (Jika Seeder Dipakai)

Sesuaikan dengan seeder kalian, contoh umum:

👑 Admin
email: admin@gmail.com
password: admin

🏬 Seller
email: budianto@gmail.com
password: 12345678

👤 User
email: budianto@gmail.com
password: 12345678
