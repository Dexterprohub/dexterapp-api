<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            ['name' => 'Food Delivery', 'description' =>'Food Delivery Services'],
            ['name' => 'Laundry', 'description' => 'Laundry Services'],
            ['name' => 'Beauty Services', 'description' => 'Beauty Services'],
            ['name' => 'Technical Services', 'description' => 'Technical Services'],
            ['name' => 'House Cleaning', 'description' => 'House Cleaning Services'],
            ['name' => 'Grocery Shopping', 'description' => 'Grocery Services'],
            ['name' => 'Fashion Designer', 'description' => 'Fashion Design Services'],
            ['name' => 'Shortlet', 'description' => 'Shortles Services']
            
        ]);
    
    }
}
