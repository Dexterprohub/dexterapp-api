<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Food;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodCart>
 */
class FoodCartFactory extends Factory
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
            'food_id' => Food::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->randomNumber(3, True),
        ];
    }
}
