<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Basicdetail>
 */
class BasicdetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'image' => $this->faker->imageUrl(),
            'street' => $this->faker->address,
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
        ];
    }
}
