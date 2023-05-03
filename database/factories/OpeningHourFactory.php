<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\Weekday;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OpeningHourFactory extends Factory
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
            'day' => Weekday::inRandomOrder()->first()->id,
            'from_hour' => $this->faker->time('h'),
            'to_hour' => $this->faker->time('h'),
            'from_minute' => $this->faker->time('i'),
            'to_minute' => $this->faker->time('i')
        ];
    }
}
