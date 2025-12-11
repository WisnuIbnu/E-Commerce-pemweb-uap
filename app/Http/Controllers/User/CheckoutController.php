<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.productImages', 'product.store')
                    ->where('user_id', auth()->id())
                    ->get();

        if($carts->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $subtotal = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('user.checkout.index', compact('carts', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_service' => 'required|in:Same Day,Express,Regular',
            'bank' => 'required|string',
        ]);

        $user = auth()->user();
        
        // Ensure Buyer record exists
        $buyer = \App\Models\Buyer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => '08123456789', // Default/Dummy
                'profile_picture' => null
            ]
        );

        $carts = Cart::with('product')->where('user_id', $user->id)->get();
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Determine Shipping Cost per Store transaction
        // Simplify: The shipping cost applies PER TRANSACTION (Per Store)
        $shippingCosts = [
            'Same Day' => 50000,
            'Express' => 30000,
            'Regular' => 10000,
        ];
        $shippingCost = $shippingCosts[$request->shipping_service] ?? 10000;

        // Group items by Store
        $groupedCarts = $carts->groupBy('product.store_id');
        $createdTransactionIds = [];

        foreach ($groupedCarts as $storeId => $items) {
            // Calculate Item Subtotal for this store
            $storeSubtotal = $items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Grand Total = Subtotal + Shipping Cost
            $grandTotal = $storeSubtotal + $shippingCost;

            // Create Transaction
            $transaction = \App\Models\Transaction::create([
                'code' => 'TRX-' . strtoupper(uniqid()),
                'buyer_id' => $buyer->id,
                'store_id' => $storeId,
                'address' => $request->address,
                'address_id' => 'ADDR-' . rand(100, 999), // Dummy logic
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE', // Dummy courier
                'shipping_type' => $request->shipping_service,
                'shipping_cost' => $shippingCost,
                'tracking_number' => null,
                'tax' => 0,
                'grand_total' => $grandTotal,
                'payment_status' => 'unpaid',
            ]);

            // Create Transaction Details
            foreach ($items as $item) {
                \App\Models\TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            $createdTransactionIds[] = $transaction->id;
        }

        // Clear Cart
        Cart::where('user_id', $user->id)->delete();

        // Pass transaction IDs to payment page via session
        return redirect()->route('checkout.payment', ['ids' => implode(',', $createdTransactionIds)])
            ->with('selected_bank', $request->bank);
    }

    public function payment(Request $request)
    {
        $ids = explode(',', $request->query('ids', ''));
        $transactions = \App\Models\Transaction::whereIn('id', $ids)->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('dashboard');
        }

        $totalAmount = $transactions->sum('grand_total');
        $bank = session('selected_bank', 'BCA'); // Default if missing
        $vaNumber = '8800' . rand(1000000000, 9999999999); // Dummy VA

        return view('user.checkout.payment', compact('transactions', 'totalAmount', 'bank', 'vaNumber', 'ids'));
    }

    public function processPayment(Request $request)
    {
        $ids = explode(',', $request->input('transaction_ids', ''));
        $transactions = \App\Models\Transaction::whereIn('id', $ids)->get();

        foreach ($transactions as $transaction) {
            if ($transaction->payment_status === 'paid') continue;

            // 1. Update Transaction Status
            $transaction->update(['payment_status' => 'paid']);

            // 2. Reduce Product Stock
            foreach ($transaction->transactionDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    $product->decrement('stock', $detail->qty);
                }
            }

            // 3. Update Seller Balance
            // Logic: Seller receives Subtotal (Product Prices).
            // Exclude shipping cost from the income added to store balance.
            $income = $transaction->grand_total - $transaction->shipping_cost;
            
            $store = $transaction->store;
            if ($store) {
                $balance = \App\Models\StoreBalance::firstOrCreate(
                    ['store_id' => $store->id],
                    ['balance' => 0]
                );
                $balance->increment('balance', $income);
                
                // Record History
                \App\Models\StoreBalanceHistory::create([
                    'store_balance_id' => $balance->id,
                    'type' => 'income',
                    'reference_id' => $transaction->id,
                    'reference_type' => \App\Models\Transaction::class,
                    'amount' => $income,
                    'remarks' => 'Sales Revenue from ' . $transaction->code,
                ]);
                ]);
                
                // Sync to Orders table (Legacy Support)
                \App\Models\Order::create([
                    'store_id' => $transaction->store_id,
                    'user_id' => $transaction->buyer->user_id,
                    'total_price' => $transaction->grand_total,
                    'status' => 'pending',
                    'shipping_address' => $transaction->address,
                    'payment_status' => 'paid',
                    'shipping_status' => 'unshipped',
                    'created_at' => $transaction->created_at,
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('history')->with('success', 'Payment successful! Transaction details processed.');
    }
}
