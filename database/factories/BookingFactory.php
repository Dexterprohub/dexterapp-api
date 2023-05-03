<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Business;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\Service;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
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
            'service_id' => Service::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'time' => $this->faker->dateTime(),
            'address' => $this->faker->address(),
            'total_cost' => $this->faker->numberBetween(1600,16798),
            'status' => $this->faker->numberBetween(0,3),
            'scheduledate' => $this->faker->dateTime(),
            'completedate' => $this->faker->dateTime(),
        ];
    }
}
