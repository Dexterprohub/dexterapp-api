<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            //  'vendor_id' => Vendor::inRandomOrder()->first()->id,
            //'booking_id' => Booking::inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'review' => $this->faker->text,
            'rating' => $this->faker->numberBetween(1,10),
            'review_date' => $this->faker->dateTime()
        ];
    }
}
