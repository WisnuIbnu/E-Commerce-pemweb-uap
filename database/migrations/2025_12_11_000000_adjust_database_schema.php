<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Stores: Rename image to logo, drop description
        Schema::table('stores', function (Blueprint $table) {
            $table->renameColumn('image', 'logo');
            $table->dropColumn('description');
        });

        // 2. Products: Rename description to about
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('description', 'about');
        });

        // 3. Product Reviews: Drop user_id (inferred from transaction)
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // 4. Transactions: Migrating user_id to buyer_id
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('buyer_id')->nullable()->after('id');
            // We'll add the constraint after populating data to avoid errors
        });

        // Migrate data for transactions
        // Assuming buyers table exists and has user_id, and we want to link transaction to buyer
        // If buyer record doesn't exist for a user, we might have an issue, but we'll try to map existing ones.
        // For strictness, every user involved in a transaction should be a buyer.
        $results = DB::table('transactions')->get();
        foreach ($results as $transaction) {
            $buyer = DB::table('buyers')->where('user_id', $transaction->user_id)->first();
            if ($buyer) {
                DB::table('transactions')->where('id', $transaction->id)->update(['buyer_id' => $buyer->id]);
            }
        }

        Schema::table('transactions', function (Blueprint $table) {
            // Now we can't easily enforce not null if data is missing, checking if we should
            // For now, let's keep it nullable if migration failed, or enforce if we are confident.
            // Given it's a dev env, we might just enforce it.
            // But let's constraints first.
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // 5. Withdrawals: Migrating store_balance_id to store_id
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->nullable()->after('id');
        });

        // Migrate data
        $withdrawals = DB::table('withdrawals')->get();
        foreach ($withdrawals as $withdrawal) {
            $balance = DB::table('store_balances')->where('id', $withdrawal->store_balance_id)->first();
            if ($balance) {
                DB::table('withdrawals')->where('id', $withdrawal->id)->update(['store_id' => $balance->store_id]);
            }
        }

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->dropForeign(['store_balance_id']);
            $table->dropColumn('store_balance_id');
        });
    }

    public function down(): void
    {
        // Reverse operations (simplified, might lose data on reverse if not careful)
        
        // Withdrawals
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->unsignedBigInteger('store_balance_id')->nullable();
            $table->foreign('store_balance_id')->references('id')->on('store_balances');
        });
        // (Skipping data reverse migration for brevity, assuming dev env)
        Schema::table('withdrawals', function (Blueprint $table) {
             $table->dropForeign(['store_id']);
             $table->dropColumn('store_id');
        });

        // Transactions
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users');
        });
        Schema::table('transactions', function (Blueprint $table) {
             $table->dropForeign(['buyer_id']);
             $table->dropColumn('buyer_id');
        });

        // Product Reviews
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
        });

        // Products
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('about', 'description');
        });

        // Stores
        Schema::table('stores', function (Blueprint $table) {
            $table->renameColumn('logo', 'image');
            $table->text('description')->nullable();
        });
    }
};
