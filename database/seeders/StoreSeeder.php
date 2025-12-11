<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'id' => 1,
                'user_id' => 2,
                'name' => 'Premium Tumbler Co',
                'logo' => 'stores/premium-tumbler-logo.png',
                'about' => 'Your trusted source for premium insulated tumblers and drinkware. We specialize in high-quality YETI, Stanley, and Hydro Flask products.',
                'phone' => '+62812-3456-7890',
                'address_id' => 'JKT-001',
                'city' => 'Jakarta Selatan',
                'address' => 'Jl. Sudirman No. 123, Senayan, Kebayoran Baru',
                'postal_code' => '12190',
                'is_verified' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'name' => 'Elite Drinkware Hub',
                'logo' => 'stores/elite-drinkware-logo.png',
                'about' => 'Elite collection of world-class tumblers and bottles. Official distributor of premium brands including S\'well, Zojirushi, and Contigo.',
                'phone' => '+62813-9876-5432',
                'address_id' => 'JKT-002',
                'city' => 'Jakarta Pusat',
                'address' => 'Jl. Thamrin No. 456, Menteng, Tanah Abang',
                'postal_code' => '10350',
                'is_verified' => 1,
            ],
            [
                'id' => 3,
                'user_id' => 7,
                'name' => 'Tupperware',
                'logo' => 'images/stores/1765102037_693551d5468e1.jpg',
                'about' => 'Tupperware berada di bawah naungan Tupperware Brands Corporation, perusahaan multinasional asal AS yang didirikan oleh Earl Silas Tupper pada 1946.\r\n\r\nTupper, yang lahir pada 1907, merupakan seorang pebisnis yang sejak muda terobsesi dengan riset. Ia menciptakan plastik ringan, fleksibel, dan tak berbau dari ampas polyethylene, bahan yang kemudian menjadi dasar produk-produk Tupperware.\r\n\r\nProduk pertamanya, Wonderlier Bowl, adalah wadah plastik kedap udara yang menjadi simbol dapur modern pasca Perang Dunia II.\r\n\r\nPopularitasnya melejit lewat strategi penjualan unik bernama Tupperware Home Party, yang dipopulerkan oleh Brownie Wise. Lewat acara ini, penjualan dilakukan dalam format sosial dan edukatif, yang kemudian diadopsi oleh banyak perusahaan lain.\r\n\r\nSaat ini, Tupperware Brands Corporation berbasis di Orlando, Florida, dan sempat mengalami krisis finansial serius.\r\n\r\nBaca artikel CNN Indonesia \"Siapa Pemilik Tupperware yang Tutup di Indonesia per 31 Januari 2025?\" selengkapnya di sini: https://www.cnnindonesia.com/ekonomi/20250415101511-92-1218857/siapa-pemilik-tupperware-yang-tutup-di-indonesia-per-31-januari-2025.\r\n\r\nDownload Apps CNN Indonesia sekarang https://app.cnnindonesia.com/',
                'phone' => '082330281602',
                'address_id' => null,
                'city' => 'Kab. Lamongan',
                'address' => 'Dadapan, Solokuro, Lamongan',
                'postal_code' => '12345',
                'is_verified' => 1,
            ],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate(
                ['id' => $store['id']],
                $store
            );
        }
    }
}