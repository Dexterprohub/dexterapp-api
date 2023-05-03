<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['Victoria Island', 'Lekki', 'Gbagada', 'Somolu ', 'Ajah','Sango','today','tomoreo','namde','Victoria Island', 'Lekki', 'Gbagada', 'Somolu ', 'Ajah','Sango','today','tomoreo','namde','Victoria Island', 'Lekki', 'Gbagada', 'Somolu ', 'Ajah','Sango','today','tomoreo','namde'];
       
        City::insert($cities);

    }
}
