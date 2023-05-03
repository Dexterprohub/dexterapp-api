<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ElectricalService;
use App\Models\Service;

class ElectricalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $names = ['AC Unit', 'Fridge', 'Washing Machine', 'Gas Cooker', 'TVs'];
        
        $service = ElectricalService::all();
        foreach($names as $name) {
            ElectricalService::factory()->create([
                // 'service_id' => Service::find(1), 
                'item_name' => $name,
                // 'icon' => file_get_contents('storage/app/public/icons/fridge-icon.png') 
                'icon' => "https://via.placeholder.com/640x480.png/005566?text=accusamus"
            ]);
        }
        // ElectricalService::factory()->count(5)->create();
        // $service = ElectricalService::all();

        // $s1 = Service::whereName('Electrical Services')->first();

        // foreach( $services as $service) {
        //     \DB::table('service_electrical_services')->insert([

        //         'service_id' => $s1->id,
        //         'electrical_service_id' => $es->id
        //     ]);
        // }

        // $es1 = [
        //     // 'service_id' => Service::whereName('Electrical Services')->first(),
        //     'name' => 'AC Unit',
        //     'icon' =>  file_get_contents('storage/app/public/icons/ac-icon.png')
        // ];
        // $es2 = [
        //     // 'service_id' => Service::find(1),
        //     'name' => 'Fridge',
        //     'icon' =>  file_get_contents('storage/app/public/icons/fridge-icon.png')
        // ];
        // $es3 = [
        //     // 'service_id' => Service::find(1),
        //     'name' => 'Washing Machine',
        //     'icon' =>  file_get_contents('storage/app/public/icons/wash-machine-icon.png')
        // ];
        // $es4 = [
        //     // 'service_id' => Service::find(1),
        //     'name' => 'Gas Cooker',
        //     'icon' =>  file_get_contents('storage/app/public/icons/gas-cooker-icon.png')
        // ];
        // $es5 = [
        //     // 'service_id' => Service::find(1),
        //     'name' => 'TVs',
        //     'icon' =>  file_get_contents('storage/app/public/icons/tv-icon.png')
        // ];

        // ElectricalService::create($es1);
        // ElectricalService::create($es2);
        // ElectricalService::create($es3);
        // ElectricalService::create($es4);
        // ElectricalService::create($es5);
    }
}
