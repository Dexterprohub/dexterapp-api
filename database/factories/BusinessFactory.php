<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'vendor_id' => Vendor::inRandomOrder()->first()->id,
            // 'service_id' => Service::inRandomOrder()->first()->id,
            // 'name' => $this->faker->company,
            // 'bio' => $this->faker->paragraph,
            // 'rating' => $this->faker->numberBetween(0,10),
            // 'longitude' => $this->faker->longitude,
            // 'latitude' => $this->faker->latitude,
            // 'image' => $this->faker->imageUrl
        ];
    }
}
