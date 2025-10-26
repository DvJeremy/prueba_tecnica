<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // usuarios
        $users = User::factory(5)->create();

        $firstUser = $users->first();
        $token = $firstUser->createToken('api-token')->plainTextToken;
        $this->command->info("Token para el primer usuario: $token");

        // productos
        $products = Product::factory(20)->create();

        // ordenes para cada usuario
        $users->each(function ($user) use ($products) {
            $orders = Order::factory(2)->create([
                'user_id' => $user->id,
            ]);

            // para cada orden productos aleatorios
            $orders->each(function ($order) use ($products) {
                $selectedProducts = $products->random(rand(2, 5));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $subtotal = $product->price * $quantity;

                    $order->products()->attach($product->id, [
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);
                }

                $order->total = $order->products->sum('pivot.subtotal');
                $order->save();
            });
        });
    }
}
