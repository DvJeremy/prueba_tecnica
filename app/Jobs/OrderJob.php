<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class OrderJob implements ShouldQueue
{
    use Queueable;

    protected $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Generar recibo
        $receipt = "Recibo del Pedido #" . $this->order->id . "\n";
        $receipt .= "Usuario: " . $this->order->user->name . " (ID: " . $this->order->user->id . ")\n";
        $receipt .= "Total: $" . $this->order->total . "\n";
        $receipt .= "Productos:\n";

        foreach ($this->order->products as $product) {
            $receipt .= "- {$product->name} x {$product->pivot->quantity} = {$product->pivot->subtotal}\n";
        }

        // Guardar en storage/logs
        Log::channel('single')->info($receipt);

        // Simular envío email
        Log::info("Correo simulado enviado a {$this->order->user->email} para el pedido #{$this->order->id}");

    }
}
