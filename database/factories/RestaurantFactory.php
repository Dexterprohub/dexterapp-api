<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use App\Models\Vendor;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // // 'user_id' => $this->faker->
            // 'service_id' => Service::find(1),
            // 'vendor_id' => Vendor::inRandomOrder()->first()->id,
            // 'name' => $this->faker->name(),
            // 'rating' => $this->faker->numberBetween(0,10),
            // 'min_order' => $this->faker->numberBetween(1000, 1800),
            // 'opened_from' => $this->faker->time('H:i:s'),
            // 'opened_to' => $this->faker->time('H:i:s'),
            // 'delivery_fee' => $this->faker->numberBetween(300,400),
            // 'description' => $this->faker->paragraph(mt_rand(2,6),True),
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'phone' => $this->faker->phoneNumber(),
            // 'address' => $this->faker->address(),
            // 'image' => "",
            // 'cover_image' => $this->faker->imageUrl(),
            // 'longitude' => $this->faker->longitude,
            // 'latitude' => $this->faker->latitude,
            // 'status' => $this->faker->numberBetween(0,1)
        ];
    }
}
