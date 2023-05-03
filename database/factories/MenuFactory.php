<?php

namespace Database\Factories;

use App\Models\MenuType;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
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
            'name' => $this->faker->userName(),
            'isActive' => $this->faker->numberBetween(0,1),
            'menu_type_id' => MenuType::inRandomOrder()->first()->id
        ];
    }
}
