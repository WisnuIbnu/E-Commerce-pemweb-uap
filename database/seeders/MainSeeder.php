<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Admin FlexSport',
            'email' => 'admin@flexsport.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $seller = User::create([
            'name' => 'Seller Pro',
            'email' => 'seller@flexsport.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        $buyer = User::create([
            'name' => 'John Buyer',
            'email' => 'buyer@flexsport.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 2. Create Single Store for Seller
        $store = Store::create([
            'user_id' => $seller->id,
            'name' => 'FlexSport Official',
            'slug' => 'flexsport-official',
            'description' => 'The premier destination for professional sports equipment.',
            'address' => 'Jakarta Sports Complex, Building A',
            'city' => 'Jakarta',
            'phone' => '08123456789',
            'is_verified' => true,
        ]);

        // 3. Create Categories
        $categories = [
            ['name' => 'Footwear', 'icon' => '👟', 'slug' => 'footwear', 'bg' => '1a0500', 'color' => 'FF4500'],
            ['name' => 'Apparel', 'icon' => '👕', 'slug' => 'apparel', 'bg' => '1e293b', 'color' => 'f43f5e'],
            ['name' => 'Rackets', 'icon' => '🎾', 'slug' => 'rackets', 'bg' => '0f172a', 'color' => 'FF8C00'],
            ['name' => 'Gym Gear', 'icon' => '💪', 'slug' => 'gym-gear', 'bg' => '000000', 'color' => 'ffffff'],
            ['name' => 'Accessories', 'icon' => '🎒', 'slug' => 'accessories', 'bg' => '475569', 'color' => 'ffd700'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[] = ProductCategory::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'image' => "https://placehold.co/100x100/{$cat['bg']}/{$cat['color']}?text={$cat['icon']}",
                'description' => "Best {$cat['name']} for professionals.",
            ]);
        }

        // 4. Create Multiple Products (All in Single Store)
        $productsData = [
            // Footwear
            [
                'cat_idx' => 0, 'name' => 'Neon Striker Elite', 'price' => 1250000, 
                'desc' => 'Top-tier soccer cleats with neon glow technology.',
                'image' => 'https://placehold.co/600x600/1a0500/FF4500?text=Neon+Striker'
            ],
            [
                'cat_idx' => 0, 'name' => 'AirWalker Pro Run', 'price' => 890000, 
                'desc' => 'Lightweight running shoes for marathon training.',
                'image' => 'https://placehold.co/600x600/ff5733/ffffff?text=AirWalker+Pro'
            ],
            [
                'cat_idx' => 0, 'name' => 'CourtMaster Basketball', 'price' => 1500000, 
                'desc' => 'High-grip soles for indoor courts.',
                'image' => 'https://placehold.co/600x600/0066cc/ffffff?text=CourtMaster'
            ],
            
            // Apparel
            [
                'cat_idx' => 1, 'name' => 'CyberRun Smart Jersey', 'price' => 450000, 
                'desc' => 'Moisture-wicking fabric with breathable mesh.',
                'image' => 'https://placehold.co/600x600/1e293b/f43f5e?text=CyberRun+Jersey'
            ],
            [
                'cat_idx' => 1, 'name' => 'FlexFit Compression Shorts', 'price' => 300000, 
                'desc' => 'Muscle support for intense workouts.',
                'image' => 'https://placehold.co/600x600/1e293b/FF4500?text=FlexFit'
            ],
            [
                'cat_idx' => 1, 'name' => 'ProTech Training Jacket', 'price' => 750000, 
                'desc' => 'Windproof and water-resistant.',
                'image' => 'https://placehold.co/600x600/2d3748/fbbf24?text=ProTech'
            ],

            // Rackets
            [
                'cat_idx' => 2, 'name' => 'Vortex Pro Tennis Racket', 'price' => 2800000, 
                'desc' => 'Carbon fiber frame for maximum power.',
                'image' => 'https://placehold.co/600x600/0f172a/FF8C00?text=Vortex+Pro'
            ],
            [
                'cat_idx' => 2, 'name' => 'SmashLite Badminton Set', 'price' => 1200000, 
                'desc' => 'Includes 2 rackets and shuttlecocks.',
                'image' => 'https://placehold.co/600x600/0f172a/ffd700?text=SmashLite'
            ],

            // Gym Gear
            [
                'cat_idx' => 3, 'name' => 'Titanium Grip Dumbbells', 'price' => 850000, 
                'desc' => 'Anti-slip grip, available in 5kg-20kg.',
                'image' => 'https://placehold.co/600x600/000000/ffffff?text=Titanium+Grip'
            ],
            [
                'cat_idx' => 3, 'name' => 'PowerBench Press 3000', 'price' => 3500000, 
                'desc' => 'Adjustable bench for home gyms.',
                'image' => 'https://placehold.co/600x600/333333/ffffff?text=PowerBench'
            ],
            [
                'cat_idx' => 3, 'name' => 'Elite Resistance Bands', 'price' => 250000, 
                'desc' => 'Set of 5 bands with varying tension.',
                'image' => 'https://placehold.co/600x600/1a1a1a/22c55e?text=Resistance'
            ],

             // Accessories
             [
                'cat_idx' => 4, 'name' => 'HydraMax Water Bottle', 'price' => 150000, 
                'desc' => 'Keep your drink cold for 24 hours.',
                'image' => 'https://placehold.co/600x600/475569/ffd700?text=HydraMax'
            ],
        ];

        $productModels = [];
        foreach ($productsData as $p) {
            $product = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $catModels[$p['cat_idx']]->id,
                'name' => $p['name'],
                'slug' => \Illuminate\Support\Str::slug($p['name']),
                'description' => $p['desc'],
                'condition' => 'new',
                'price' => $p['price'],
                'weight' => rand(200, 2000),
                'stock' => rand(5, 50),
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $p['image'],
            ]);
            
            // Random Reviews
            if (rand(0, 1)) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $buyer->id,
                    'rating' => rand(3, 5),
                    'review' => 'Great product! Highly recommended.',
                ]);
            }

            $productModels[] = $product;
        }

        // 5. Create Sample Transactions with Different Statuses
        // Transaction 1: Delivered
        $t1 = Transaction::create([
            'user_id' => $buyer->id,
            'store_id' => $store->id,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10110',
            'shipping' => 'JNE',
            'shipping_type' => 'Regular',
            'shipping_cost' => 15000,
            'tax' => 0,
            'grand_total' => 1265000,
            'payment_status' => 'paid',
            'order_status' => 'delivered',
        ]);

        TransactionDetail::create([
            'transaction_id' => $t1->id,
            'product_id' => $productModels[0]->id, // Neon Striker
            'qty' => 1,
            'price' => 1250000,
            'subtotal' => 1250000,
        ]);

        // Transaction 2: Shipped
        $t2 = Transaction::create([
            'user_id' => $buyer->id,
            'store_id' => $store->id,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10110',
            'shipping' => 'JNE',
            'shipping_type' => 'Regular',
            'shipping_cost' => 20000,
            'tax' => 0,
            'grand_total' => 470000,
            'payment_status' => 'paid',
            'order_status' => 'shipped',
        ]);

        TransactionDetail::create([
            'transaction_id' => $t2->id,
            'product_id' => $productModels[3]->id, // CyberRun Jersey
            'qty' => 1,
            'price' => 450000,
            'subtotal' => 450000,
        ]);

        // Transaction 3: Processing
        $t3 = Transaction::create([
            'user_id' => $buyer->id,
            'store_id' => $store->id,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => 'Jl. Thamrin No. 5',
            'city' => 'Jakarta',
            'postal_code' => '10230',
            'shipping' => 'JNE',
            'shipping_type' => 'Regular',
            'shipping_cost' => 15000,
            'tax' => 0,
            'grand_total' => 865000,
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        TransactionDetail::create([
            'transaction_id' => $t3->id,
            'product_id' => $productModels[8]->id, // Titanium Grip
            'qty' => 1,
            'price' => 850000,
            'subtotal' => 850000,
        ]);
    }
}
