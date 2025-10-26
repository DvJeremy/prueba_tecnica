<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class ReportController extends Controller
{
    public function top5Selling()
    {
        $topProducts = Product::withSum('orders as total_sold', 'order_product.quantity')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return response()->json($topProducts);
    }

    public function userOrders()
    {
        $userId = request()->query('user_id');
        $user = User::with('orders.products')->findOrFail($userId);

        $orders = $user->orders->map(function($order) {
            return [
                'order_id' => $order->id,
                'total' => $order->total,
                'status' => $order->status,
                'products' => $order->products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'subtotal' => $product->pivot->subtotal,
                    ];
                })
            ];
        });

        $totalAccumulated = $user->orders->sum('total');

        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'total_accumulated' => $totalAccumulated,
            'orders' => $orders,
        ]);
    }
}