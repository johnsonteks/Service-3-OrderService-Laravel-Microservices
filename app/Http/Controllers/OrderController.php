<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = Http::get('http://localhost:8001/api/user-list')->json();
        $products = Http::get('http://localhost:8002/api/product-list')->json();
        return view('orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $product = Http::get("http://localhost:8002/api/product/{$request->product_id}")->json();

        $total = $product['price'] * $request->quantity;

        Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total,
        ]);

        return redirect('/orders');
    }

    public function getOrdersByUser($userId)
    {
        return response()->json(Order::where('user_id', $userId)->get());
    }

    public function getOrdersByProduct($productId)
    {
        return response()->json(Order::where('product_id', $productId)->get());
    }

    public function apiStore(Request $request)
    {
        $product = Http::get("http://localhost:8002/api/product/{$request->product_id}")->json();

        $total = $product['price'] * $request->quantity;

        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total,
        ]);

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order
        ], 201); // Status code 201: Created
    }

    public function apiIndex() {
        return response()->json(Order::all());
    }
    
}
