<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OTPDeliveryMethod;


class OTPDeliveryMethodSeeder extends Seeder
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
                'name' => 'phone'
            ],
            [
                'name' => 'email'
            ],
        ];

        OTPDeliveryMethod::insert($method);
    }
}
