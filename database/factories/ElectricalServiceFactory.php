<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use App\Models\ElectricalService;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ElectricalService>
 */
class ElectricalServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            // 'service_id' => Service::find(1),
            // 'name' => $this->faker->text('AC UNIT')
            // // // 'icon' => $this->faker->image(storage_path('app/public/icons'),false)
        ];
    }
}
