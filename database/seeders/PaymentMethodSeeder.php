<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $method = [
            
            [
                'name' => 'paystack'
            ],
            [
                'name' => 'cash on delivery'
            ],
        ];

        PaymentMethod::insert($method);
    }
}
