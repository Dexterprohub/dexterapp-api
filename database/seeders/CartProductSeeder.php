<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartProduct;


class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CartProduct::factory()->count(10)->create();
         // Cart::factory()->count(10)->create()
        // ->each(function (Cart $cart){
        //     \App\Models\Product::factory()->count(random_int(1,5))->create([
        //         "order_id" => $order->id
        //     ]);
        // });\
    //    $cartProducts = CartProduct::factory()
    //             ->count(5)
    //             ->state(new Sequence(
    //                 ['product_id' => 1],
    //                 ['product_id' => 2],
    //                 ['product_id' => 3],
    //                 ['product_id' => 4],
    //                 ['product_id' => 5],
    //             ))
    //             ->create();
       
        
        // Cart::factory()->count(5)->create()->each(
            
        //     function (Cart $cart)
        //     {
                
        //         // Product::factory()->count(random_int(1,5))->create([
        //             //     "id" => $cart->id
        //             // ]);
                
        //             // Product::factory()->count(random_int(1,5))->pluck('id');
                    
        //         $cart->products()->saveMany(Product::factory()->count(random_int(1, 4))->make());
        //     }
        // );     
    }
}
            