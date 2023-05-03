<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;
use App\Models\Food;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favourite>
 */
class FavouriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'user_id' => User::inRandomOrder->first()->id,
        'service_id' => Service::inRandomOrder->first()->id,
        'food_id' => Food::inRandomOrder->first()->id,
        ];
    }
}
