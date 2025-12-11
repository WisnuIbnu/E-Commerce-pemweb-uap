<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            echo "Tidak ada produk, jalankan ProductSeeder dulu.\n";
            return;
        }

        foreach ($products as $product) {

            echo "\n[ProductImagesSeeder] Seeding images for Product ID {$product->id}\n";

            // Daftar file yang akan dicoba otomatis
            $candidates = [
                $product->id . '_thumb.png',  // thumbnail
                $product->id . '_1.png',      // tambahan 1
                $product->id . '_2.png',      // tambahan 2
                $product->id . '_3.png',      // tambahan 3 (opsional untuk fleksibilitas)
            ];

            foreach ($candidates as $index => $filename) {

                $path = "product_assets/" . $filename;

                // Cek apakah file benar-benar ada
                if (!Storage::disk('public')->exists($path)) {
                    echo "[SKIP] File tidak ditemukan: {$path}\n";
                    continue;
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0 ? true : false,
                ]);

                echo "[OK] Inserted: {$path}\n";
            }
        }

        echo "\n[ProductImagesSeeder] DONE!\n";
    }
}