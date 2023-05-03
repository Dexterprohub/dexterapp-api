<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuType>
 */
class MenuTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id,
            'name' => $this->faker->title(),
            'description' => $this->faker->sentence()
        ];
    }
}
