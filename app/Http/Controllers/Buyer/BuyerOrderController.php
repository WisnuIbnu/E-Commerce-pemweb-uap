<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use App\Models\Order;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('buyer.orders.index', ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('buyer.orders.show', ['order' => $order]);
    }
}