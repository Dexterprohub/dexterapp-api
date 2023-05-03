<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id' => Restaurant::inRandomOrder->first()->id,
            'name' => $faker->company,
            'address' => $faker->sentence(1, True),
            'picture' => $faker->imageUrl(200,100),
        ];
    }
}
