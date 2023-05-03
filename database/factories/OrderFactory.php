<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Address;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'order_number' => $this->faker->numerify('####-####'),
            'order_date' => $this->faker->date('Y-m-d', 'now'),
            'order_status' => $this->faker->numberBetween(0,3),
            'payment_status' => $this->faker->numberBetween(0,1),
            'address' => $this->faker->address(),
            'total_amount' => $this->faker->numberBetween(1, 50000),
            'delivery_date' => $this->faker->date('Y-m-d', 'now'),
        
            // 'processed_by' => User::inRandomOrder()->first()->id,
            
        ];
    }
}
