<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FoodCategory::factory()->count(10)->create();

        $names = ['Breakfast Meal', 'Chinese', 'Combo', 'Fast Food', 'Specials', 'African', 'Drinks'];
        foreach($names as $name) {
            FoodCategory::factory()->create([
                'restaurant_id' => Restaurant::inRandomOrder()->first()->id, 
                'name' => $name,
            ]);
        }
    }
}
