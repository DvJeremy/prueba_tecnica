<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class ExpirePendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fecha límite de 24 horas
        $limitdate = Carbon::now()->subDay();

        // Buscar pedidos pendientes mayores a 24 horas
        $orders = Order::where('status', 'pending')
            ->where('created_at', '<', $limitdate)
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No hay pedidos pendientes para expirar.');
            return 0;
        }

        // Actualizar estado y mostrar en consola
        foreach ($orders as $order) {
            $order->update(['status' => 'expired']);
            $this->info("Pedido #{$order->id} marcado como expirado");
        }

        return 0;
    }
}
