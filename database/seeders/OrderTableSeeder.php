<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Order::factory()->count(10)->create()
        // ->each(function (Order $order){
        //     \App\Models\Food::factory()->count(random_int(1,5))->create([
        //         "order_id" => $order->id
        //     ]);
        // });

        Order::factory()->count(10)->create();
    }
}
