<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('products')) {
            $this->command->warn('❌ Table products does not exist, skipping ProductSeeder.');
            return;
        }

        $now = Carbon::now();

        // Pastikan store ada
        $storeId = Schema::hasTable('stores') ? DB::table('stores')->value('id') : null;

        // Ambil kategori
        $categoryIds = Schema::hasTable('product_categories')
            ? DB::table('product_categories')->pluck('id')->toArray()
            : [];

        if (!$storeId) {
            $this->command->error('❌ No store found. Run UserAndStoreSeeder first.');
            return;
        }

        if (empty($categoryIds)) {
            $this->command->error('❌ No categories found. Run ProductCategorySeeder first.');
            return;
        }

        // Mapping kategori
        $babyWear      = $categoryIds[0];
        $toys          = $categoryIds[1];
        $accessories   = $categoryIds[2];
        $careBath      = $categoryIds[3];
        $shoes         = $categoryIds[4];
        $bags          = $categoryIds[5];

        // --- LIST PRODUK dengan Description & Features ---
        $products = [

            // Babywear
            [
                'name' => 'Baby Cotton Romper',
                'category_id' => $babyWear,
                'description' => 'Premium soft cotton romper designed for newborn comfort. Made from 100% organic cotton that is gentle on delicate baby skin. Features snap buttons for easy diaper changes and cute animal prints. Perfect for daily wear and special occasions.',
                'features' => json_encode([
                    '100% organic cotton material',
                    'Soft and breathable fabric',
                    'Easy snap button closure',
                    'Machine washable',
                    'Hypoallergenic and safe for sensitive skin'
                ]),
                'price' => 120000,
                'weight' => 150,
                'stock' => 20
            ],
            [
                'name' => 'Baby Hoodie Soft Fleece',
                'category_id' => $babyWear,
                'description' => 'Cozy fleece hoodie to keep your baby warm during cold weather. Ultra-soft interior lining with adorable animal ear design on the hood. Perfect for outdoor activities and playtime.',
                'features' => json_encode([
                    'Premium fleece material',
                    'Warm and comfortable',
                    'Cute animal ear hood design',
                    'Front zipper closure',
                    'Available in multiple colors'
                ]),
                'price' => 155000,
                'weight' => 250,
                'stock' => 14
            ],
            [
                'name' => 'Baby Pajamas Set',
                'category_id' => $babyWear,
                'description' => 'Complete pajama set for a good night\'s sleep. Includes matching top and bottom with fun patterns. Made from soft, breathable fabric that keeps baby comfortable all night long.',
                'features' => json_encode([
                    'Two-piece matching set',
                    'Soft cotton blend fabric',
                    'Elastic waistband for comfort',
                    'Non-slip feet for toddlers',
                    'Cute bedtime prints'
                ]),
                'price' => 135000,
                'weight' => 230,
                'stock' => 18
            ],
            [
                'name' => 'Newborn Swaddle Blanket',
                'category_id' => $babyWear,
                'description' => 'Essential swaddle blanket for newborns. Helps babies feel secure and sleep better. Large size suitable for various swaddling techniques. Made from super soft muslin fabric.',
                'features' => json_encode([
                    'Large size (120cm x 120cm)',
                    'Breathable muslin fabric',
                    'Gets softer with each wash',
                    'Versatile use as blanket or nursing cover',
                    'Gentle on baby\'s skin'
                ]),
                'price' => 90000,
                'weight' => 200,
                'stock' => 30
            ],

            // Toys
            [
                'name' => 'Plush Bear Toy',
                'category_id' => $toys,
                'description' => 'Adorable plush teddy bear that becomes your baby\'s best friend. Super soft and huggable with embroidered safety eyes. Perfect companion for naptime and playtime.',
                'features' => json_encode([
                    'Ultra-soft plush material',
                    'Safety tested and certified',
                    'Embroidered eyes (no small parts)',
                    'Machine washable',
                    'Perfect size for cuddling'
                ]),
                'price' => 80000,
                'weight' => 180,
                'stock' => 20
            ],
            [
                'name' => 'Rattle Baby Toy',
                'category_id' => $toys,
                'description' => 'Colorful rattle toy to stimulate baby\'s senses. Makes gentle sounds to attract attention and helps develop motor skills. Easy for tiny hands to grip.',
                'features' => json_encode([
                    'BPA-free safe materials',
                    'Bright colors for visual stimulation',
                    'Gentle rattle sound',
                    'Easy-grip handle',
                    'Suitable from 0-12 months'
                ]),
                'price' => 45000,
                'weight' => 80,
                'stock' => 40
            ],
            [
                'name' => 'Stacking Ring Toy',
                'category_id' => $toys,
                'description' => 'Classic educational toy that teaches size, color, and stacking. Helps develop hand-eye coordination and problem-solving skills. Colorful rings in graduated sizes.',
                'features' => json_encode([
                    'Educational and fun',
                    'Develops motor skills',
                    'Non-toxic materials',
                    '5 colorful rings',
                    'Smooth rounded edges'
                ]),
                'price' => 65000,
                'weight' => 150,
                'stock' => 25
            ],
            [
                'name' => 'Soft Block Toy Set',
                'category_id' => $toys,
                'description' => 'Set of soft foam building blocks perfect for safe play. Various colors, shapes, and textures to explore. Squeezable and lightweight for easy handling by babies.',
                'features' => json_encode([
                    'Soft foam blocks',
                    'Safe for teething',
                    'Multiple textures',
                    'Bright colors',
                    'Set of 8 blocks'
                ]),
                'price' => 120000,
                'weight' => 300,
                'stock' => 15
            ],

            // Accessories
            [
                'name' => 'Baby Cotton Hat',
                'category_id' => $accessories,
                'description' => 'Soft cotton hat to protect baby\'s head from sun and cold. Stretchy material that grows with baby. Adorable designs available.',
                'features' => json_encode([
                    '100% cotton material',
                    'Stretchy and comfortable fit',
                    'Protects from sun and cold',
                    'Cute designs',
                    'Easy to wash'
                ]),
                'price' => 30000,
                'weight' => 50,
                'stock' => 50
            ],
            [
                'name' => 'Baby Socks Pack (3 pcs)',
                'category_id' => $accessories,
                'description' => 'Pack of 3 warm baby socks with anti-slip grips. Soft elastic that won\'t leave marks. Keeps tiny feet warm and cozy.',
                'features' => json_encode([
                    'Pack of 3 pairs',
                    'Anti-slip grips',
                    'Soft elastic band',
                    'Warm and breathable',
                    'Various cute patterns'
                ]),
                'price' => 25000,
                'weight' => 30,
                'stock' => 60
            ],
            [
                'name' => 'Baby Mittens Set',
                'category_id' => $accessories,
                'description' => 'Essential mittens to prevent baby from scratching face. Soft fabric with secure elastic. Perfect for newborns with sharp nails.',
                'features' => json_encode([
                    'Prevents scratching',
                    'Soft cotton material',
                    'Secure but gentle elastic',
                    'Set of 2 pairs',
                    'Machine washable'
                ]),
                'price' => 20000,
                'weight' => 25,
                'stock' => 55
            ],
            [
                'name' => 'Baby Headband Bow',
                'category_id' => $accessories,
                'description' => 'Adorable headband with bow decoration. Soft elastic band that won\'t hurt baby\'s head. Perfect for photos and special occasions.',
                'features' => json_encode([
                    'Soft elastic headband',
                    'Cute bow decoration',
                    'Adjustable size',
                    'Lightweight design',
                    'Multiple color options'
                ]),
                'price' => 28000,
                'weight' => 20,
                'stock' => 40
            ],

            // Care & Bath
            [
                'name' => 'Baby Shampoo Gentle',
                'category_id' => $careBath,
                'description' => 'Gentle no-tears formula shampoo specially designed for baby\'s delicate hair and scalp. Hypoallergenic and pediatrician tested. Leaves hair soft and clean.',
                'features' => json_encode([
                    'No-tears formula',
                    'Hypoallergenic',
                    'Pediatrician tested',
                    'pH balanced',
                    'Natural ingredients'
                ]),
                'price' => 50000,
                'weight' => 300,
                'stock' => 30
            ],
            [
                'name' => 'Baby Lotion Mild',
                'category_id' => $careBath,
                'description' => 'Moisturizing lotion that keeps baby\'s skin soft and hydrated. Quick absorbing formula with natural ingredients. Safe for daily use.',
                'features' => json_encode([
                    'Deep moisturizing',
                    'Quick absorbing',
                    'Natural ingredients',
                    'Dermatologist tested',
                    'Mild fragrance'
                ]),
                'price' => 45000,
                'weight' => 250,
                'stock' => 35
            ],
            [
                'name' => 'Baby Powder Soft',
                'category_id' => $careBath,
                'description' => 'Gentle talc-free powder to keep baby\'s skin dry and fresh. Helps prevent diaper rash and absorbs moisture. Dermatologist recommended.',
                'features' => json_encode([
                    'Talc-free formula',
                    'Prevents diaper rash',
                    'Absorbs moisture',
                    'Gentle fragrance',
                    'Dermatologist recommended'
                ]),
                'price' => 30000,
                'weight' => 200,
                'stock' => 40
            ],
            [
                'name' => 'Baby Bath Towel',
                'category_id' => $careBath,
                'description' => 'Extra soft and absorbent bath towel with cute hooded design. Large size wraps baby completely. Made from premium cotton terry.',
                'features' => json_encode([
                    'Hooded design',
                    'Extra absorbent',
                    'Large size (80cm x 80cm)',
                    'Premium cotton terry',
                    'Cute animal hood'
                ]),
                'price' => 70000,
                'weight' => 400,
                'stock' => 20
            ],

            // Shoes
            [
                'name' => 'Soft Baby Shoes',
                'category_id' => $shoes,
                'description' => 'First step shoes with soft flexible sole. Supports natural foot development. Easy slip-on design with elastic opening.',
                'features' => json_encode([
                    'Soft flexible sole',
                    'Supports foot development',
                    'Easy slip-on design',
                    'Breathable material',
                    'Non-slip grip'
                ]),
                'price' => 60000,
                'weight' => 150,
                'stock' => 22
            ],
            [
                'name' => 'Baby Sneakers',
                'category_id' => $shoes,
                'description' => 'Lightweight sneakers for active toddlers. Velcro strap for easy on and off. Cushioned insole for comfort during play.',
                'features' => json_encode([
                    'Lightweight design',
                    'Velcro strap closure',
                    'Cushioned insole',
                    'Flexible sole',
                    'Sporty design'
                ]),
                'price' => 85000,
                'weight' => 250,
                'stock' => 16
            ],
            [
                'name' => 'Baby Sandals',
                'category_id' => $shoes,
                'description' => 'Comfortable rubber sandals perfect for summer. Soft straps won\'t hurt baby\'s feet. Easy to clean and quick-drying.',
                'features' => json_encode([
                    'Soft rubber material',
                    'Comfortable straps',
                    'Easy to clean',
                    'Quick-drying',
                    'Anti-slip sole'
                ]),
                'price' => 55000,
                'weight' => 120,
                'stock' => 25
            ],

            // Bags
            [
                'name' => 'Mommy Diaper Bag',
                'category_id' => $bags,
                'description' => 'Spacious and stylish diaper bag with multiple compartments. Includes insulated bottle holders and changing mat. Comfortable shoulder straps.',
                'features' => json_encode([
                    'Multiple compartments',
                    'Insulated bottle holders',
                    'Free changing mat',
                    'Water-resistant material',
                    'Adjustable straps'
                ]),
                'price' => 180000,
                'weight' => 800,
                'stock' => 10
            ],
            [
                'name' => 'Travel Milk Cooler Bag',
                'category_id' => $bags,
                'description' => 'Insulated cooler bag to keep milk and food fresh during travel. Thermal lining maintains temperature. Compact and portable design.',
                'features' => json_encode([
                    'Thermal insulation',
                    'Keeps items cool/warm',
                    'Compact design',
                    'Easy to carry',
                    'Easy to clean interior'
                ]),
                'price' => 125000,
                'weight' => 600,
                'stock' => 12
            ],
        ];

        // Format insert
        $insertData = [];
        foreach ($products as $p) {
            $insertData[] = [
                'store_id' => $storeId,
                'product_category_id' => $p['category_id'],
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['description'],
                'features' => $p['features'],
                'condition' => 'new',
                'price' => $p['price'],
                'weight' => $p['weight'],
                'stock' => $p['stock'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('products')->insert($insertData);

        $this->command->info('✅ Inserted 20 sample products with descriptions and features successfully.');
    }
}