<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ElectricalService;
use App\Models\Restaurant;
use App\Models\Service;
class ServiceElectricalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $es = ElectricalService::all();

        $s1 = Service::whereName('Electrical Services')->first();

        foreach($eses as $es) {
            \DB::table('service_electrical_services')->insert([

                'service_id' => $s1->id,
                'electrical_service_id' => $es->id
            ]);
        }

        
    }
}
