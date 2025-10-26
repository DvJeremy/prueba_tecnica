<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\OrderJob;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function CreateOrder(OrderRequest $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => 0,
            'status' => 'pending',
        ]);

        $total = 0;

        foreach ($request->products as $i) {
            $product = Product::find($i['id']);

            if ($product->stock < $i['quantity']) {
                return response()->json([
                    'error' => "Stock insuficiente para {$product->name}"
                ], 400);
            }

            // Descontar stock
            $product->decrement('stock', $i['quantity']);

            $subtotal = $product->price * $i['quantity'];
            $total += $subtotal;

            // Insertar en OrderProduct
            $order->products()->attach($product->id, [
                'quantity' => $i['quantity'],
                'subtotal' => $subtotal,
            ]);
        }

        // Guardar total
        $order->total = $total;
        $order->save();

        // disparar JOB al confirmar un pedido
        OrderJob::dispatch($order);

        // Devolver pedido
        return response()->json($order->load('products'));
    }
}
