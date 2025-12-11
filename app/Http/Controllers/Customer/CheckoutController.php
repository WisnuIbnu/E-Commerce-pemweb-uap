<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Get cart items from session or request
        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty');
        }

        // Get products with current price
        $productIds = array_keys($cartItems);
        $products = Product::whereIn('id', $productIds)
            ->with(['store', 'productImages'])
            ->get();

        // Calculate subtotal
        $subtotal = 0;
        $items = [];
        
        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];
            $itemSubtotal = $product->price * $quantity;
            
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $itemSubtotal
            ];
            
            $subtotal += $itemSubtotal;
        }

        // Calculate tax (e.g., 10%)
        $tax = $subtotal * 0.10;
        
        // Shipping options (you can make this dynamic)
        $shippingOptions = [
            ['name' => 'Regular', 'cost' => 10000, 'type' => 'regular'],
            ['name' => 'Express', 'cost' => 20000, 'type' => 'express'],
            ['name' => 'Same Day', 'cost' => 30000, 'type' => 'same_day'],
        ];

        $buyer = Buyer::where('user_id', auth()->id())->first();

        return view('customer.checkout', compact(
            'items',
            'subtotal',
            'tax',
            'shippingOptions',
            'buyer'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'address_id' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
            'phone_number' => 'required|string',
        ]);

        // Get or create buyer profile
        $buyer = Buyer::firstOrCreate(
            ['user_id' => auth()->id()],
            ['phone_number' => $validated['phone_number']]
        );

        // Get cart items
        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty');
        }

        // Group products by store
        $productIds = array_keys($cartItems);
        $products = Product::whereIn('id', $productIds)->with('store')->get();
        
        $storeGroups = [];
        foreach ($products as $product) {
            $storeId = $product->store_id;
            if (!isset($storeGroups[$storeId])) {
                $storeGroups[$storeId] = [];
            }
            $storeGroups[$storeId][] = [
                'product' => $product,
                'quantity' => $cartItems[$product->id]['quantity']
            ];
        }

        DB::beginTransaction();
        
        try {
            // Create transaction for each store
            foreach ($storeGroups as $storeId => $items) {
                $subtotal = 0;
                
                // Calculate subtotal for this store
                foreach ($items as $item) {
                    $subtotal += $item['product']->price * $item['quantity'];
                }
                
                $tax = $subtotal * 0.10;
                $grandTotal = $subtotal + $tax + $validated['shipping_cost'];
                
                // Generate unique transaction code
                $code = 'TRX-' . strtoupper(Str::random(10));
                
                // Create transaction
                $transaction = Transaction::create([
                    'code' => $code,
                    'buyer_id' => $buyer->id,
                    'store_id' => $storeId,
                    'address' => $validated['address'],
                    'address_id' => $validated['address_id'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'shipping' => $validated['shipping_type'],
                    'shipping_type' => $validated['shipping_type'],
                    'shipping_cost' => $validated['shipping_cost'],
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => 'unpaid',
                ]);
                
                // Create transaction details
                foreach ($items as $item) {
                    $product = $item['product'];
                    $quantity = $item['quantity'];
                    
                    // Check stock
                    if ($product->stock < $quantity) {
                        throw new \Exception("Product {$product->name} is out of stock");
                    }
                    
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'qty' => $quantity,
                        'subtotal' => $product->price * $quantity,
                    ]);
                    
                    // Reduce stock
                    $product->decrement('stock', $quantity);
                }
            }
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('transactions.index')
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to process order: ' . $e->getMessage());
        }
    }
}
