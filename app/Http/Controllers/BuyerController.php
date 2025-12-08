<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::all();
        
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }

        $products = $query->with('productImages')->get();

        // MOCK DATA GENERATOR IF EMPTY (For visual preview)
        if ($products->isEmpty() && !$request->has('search') && !$request->has('category')) {
            $products = $this->getMockProducts();
        }

        return view('buyer.index', compact('categories', 'products'));
    }

    public function collection(Request $request)
    {
        $categories = ProductCategory::all();
        
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }

        $products = $query->with('productImages')->get();

        // MOCK DATA GENERATOR IF EMPTY
        if ($products->isEmpty() && !$request->has('search') && !$request->has('category')) {
            $products = $this->getMockProducts();
        }

        return view('buyer.collection', compact('categories', 'products'));
    }

    private function getMockProducts() {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Neon Striker Elite Cleats',
                'price' => 1250000,
                'condition' => 'new',
                'product_category_id' => 1,
                'productCategory' => (object)['name' => 'Footwear'],
                // Using placehold.co for visible images
                'productImages' => collect([(object)['image' => 'https://placehold.co/600x400/003459/00f2fe?text=Neon+Striker']])
            ],
            (object)[
                'id' => 2,
                'name' => 'Vortex Pro Tennis Racket',
                'price' => 2800000,
                'condition' => 'new',
                'product_category_id' => 2,
                'productCategory' => (object)['name' => 'Racket Sports'],
                'productImages' => collect([(object)['image' => 'https://placehold.co/600x400/0f172a/4facfe?text=Vortex+Pro']])
            ],
            (object)[
                'id' => 3,
                'name' => 'CyberRun Smart Jersey',
                'price' => 450000,
                'condition' => 'new',
                'product_category_id' => 3,
                'productCategory' => (object)['name' => 'Apparel'],
                'productImages' => collect([(object)['image' => 'https://placehold.co/600x400/1e293b/f43f5e?text=CyberRun']])
            ],
            (object)[
                'id' => 4,
                'name' => 'Titanium Grip Dumbbells',
                'price' => 850000,
                'condition' => 'used',
                'product_category_id' => 4,
                'productCategory' => (object)['name' => 'Gym Gear'],
                'productImages' => collect([(object)['image' => 'https://placehold.co/600x400/000000/ffffff?text=Titanium+Grip']])
            ],
        ]);
    }

    public function product($id)
    {
        // For mock data handling in detail view (optional, but good for consistency if DB is empty)
        // Ideally we fetch from DB, but if ID < 5 and DB empty, we could mock. 
        // For now, let's keep standard DB fetch but safeguard against 404 for demonstration if possible, 
        // though standard is fine. The simplified routes earlier relied on DB.
        
        $product = Product::with(['store', 'productCategory', 'productImages', 'productReviews.user'])->find($id);

        if (!$product) {
            abort(404);
        }

        $relatedProducts = Product::where('product_category_id', $product->product_category_id ?? 0)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();
            
        return view('buyer.product', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['qty'] += $request->qty;
        } else {
            $cart[$request->product_id] = [
                'name' => $product->name,
                'qty' => $request->qty,
                'price' => $product->price,
                'image' => $product->productImages->first()->image ?? '',
                'store_id' => $product->store_id,
                'store_name' => $product->store->name ?? 'Unknown Store', 
            ];
        }

        session()->put('cart', $cart);
        
        // Return JSON for AJAX or redirect back
        if($request->wantsJson()) {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('buyer.cart', compact('cart'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
             return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
        return view('buyer.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
             return redirect()->route('home')->with('error', 'Cart is empty');
        }

        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|in:transfer,cod',
        ]);

        // Group items by store_id manually to preserve product_id keys
        $itemsByStore = [];
        foreach($cart as $productId => $item) {
            $storeId = $item['store_id'];
            if(!isset($itemsByStore[$storeId])) {
                $itemsByStore[$storeId] = [];
            }
            // Preserve product_id as key
            $itemsByStore[$storeId][$productId] = $item;
        }

        // Create transactions per store
        foreach($itemsByStore as $storeId => $items) {
            $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
            $shippingCost = 15000;
            
            $transaction = \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'store_id' => $storeId,
                'code' => 'TRX-' . strtoupper(uniqid()),
                'address' => $request->address,
                'address_id' => 'Home',
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE',
                'shipping_type' => 'Regular',
                'shipping_cost' => $shippingCost,
                'tax' => 0,
                'grand_total' => $subtotal + $shippingCost,
                'payment_status' => $request->payment_method == 'cod' ? 'unpaid' : 'paid',
                'order_status' => 'pending',
            ]);

            // Product_id keys are now preserved
            foreach($items as $productId => $details) {
                 \App\Models\TransactionDetail::create([
                     'transaction_id' => $transaction->id,
                     'product_id' => $productId,
                     'qty' => $details['qty'],
                     'price' => $details['price'],
                     'subtotal' => $details['price'] * $details['qty']
                 ]);
            }
        }

        session()->forget('cart');
        return redirect()->route('transaction.history')->with('success', 'Order placed successfully!');
    }




    public function history()
    {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id()) // Refactored to user_id
                        ->with(['transactionDetails.product.productImages', 'store'])
                        ->latest()
                        ->get();
                        
        // Fallback for demo if empty and user is likely the seeded buyer
        if ($transactions->isEmpty() && auth()->user()->email === 'buyer@flexsport.com') {
             // We can optionally seed here or just show empty state. 
             // Better to actually seed the DB properly.
        }

        return view('buyer.transaction-history', compact('transactions'));
    }
}
