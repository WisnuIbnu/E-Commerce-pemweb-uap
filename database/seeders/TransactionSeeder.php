<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('transactions') || ! Schema::hasTable('buyers') || ! Schema::hasTable('stores') || ! Schema::hasTable('products')) {
            $this->command->warn('Skipping TransactionSeeder: missing tables (transactions/buyers/stores/products).');
            return;
        }

        $now = Carbon::now();

        // Ambil satu buyer, satu store, dan beberapa produk belonging to that store (fallback if none)
        $buyerId = DB::table('buyers')->value('id');
        $storeId = DB::table('stores')->value('id');

        if (! $buyerId || ! $storeId) {
            $this->command->warn('Missing buyer or store. Ensure BuyerSeeder and UserAndStoreSeeder ran.');
            return;
        }

        // pilih produk dari store
        $productIds = DB::table('products')->where('store_id', $storeId)->pluck('id')->toArray();
        if (empty($productIds)) {
            // fallback: ambil produk umum
            $productIds = DB::table('products')->pluck('id')->toArray();
        }
        if (empty($productIds)) {
            $this->command->warn('No products found to create transaction details.');
            return;
        }

        // buat transaction contoh
        $shipping_cost = 10000.00;
        $tax = 0.00;

        $total = 0.00;
        // buat subtotal untuk beberapa produk (ambil 1-2 item)
        $detailItems = [];
        foreach (array_slice($productIds, 0, 2) as $pid) {
            $product = DB::table('products')->where('id', $pid)->first();
            $qty = rand(1,2);
            $price = (float) $product->price;
            $subtotal = $price * $qty;
            $total += $subtotal;
            $detailItems[] = [
                'product_id' => $pid,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        $grandTotal = $total + $shipping_cost + $tax;

        $code = 'TRX-' . strtoupper(Str::random(8));

        $transactionId = DB::table('transactions')->insertGetId([
            'code' => $code,
            'buyer_id' => $buyerId,
            'store_id' => $storeId,
            'address' => 'Jl. Demo No.1',
            'address_id' => 'ADDR-TRX-001',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'shipping' => 'JNE',
            'shipping_type' => 'REG',
            'shipping_cost' => $shipping_cost,
            'tracking_number' => null,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'payment_status' => 'paid',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // insert details
        foreach ($detailItems as $d) {
            DB::table('transaction_details')->insert([
                'transaction_id' => $transactionId,
                'product_id' => $d['product_id'],
                'qty' => $d['qty'],
                'subtotal' => $d['subtotal'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info("Inserted transaction {$code} with details.");
    }
}
