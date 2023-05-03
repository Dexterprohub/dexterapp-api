<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;
use App\Models\FoodCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['Refuel Max Chicken Meal', 'Spicy Jollof', '', 'Chicken Pepper Soup' , 'Grilled Catfish', 'Barbecue Turkey'];

        return [
            // 'restaurant_id' => Restaurant::inRandomOrder()->first()->id, 
            // 'food_category_id' => FoodCategory::inRandomOrder()->first()->id,
            // 'name' => $this->faker->company,
            // 'image' => $this->faker->imageUrl(),
            // 'price' => $this->faker->numberBetween(0,12000)
        ];
    }
}
