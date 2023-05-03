<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Service;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $service = Service::find(4);
       
        $items = [
            [
                'service_id' => $service->id,
                'item' => 'AC Unit',
                'image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1679742670/serviceItems/electricalRepair/yorzppq0uuu6a7i8tqsd.png',
            ],

            [
                'service_id' => $service->id,
                'item' => 'Fridge',
                'image' =>'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1679742908/serviceItems/electricalRepair/ybehmw0wlvm72s4vgcqj.png',
            ],
            [ 
                'service_id' => $service->id,
                'item' => 'Washing Machine',
                'image' => "https://res.cloudinary.com/dxjt9xfjb/image/upload/v1679743097/serviceItems/electricalRepair/f1oiewonnx1sbbtneawa.png",
            ],
            [
                'service_id' => $service->id,
                'item' => 'Gas Cooking',
                'image' => "https://res.cloudinary.com/dxjt9xfjb/image/upload/v1679743097/serviceItems/electricalRepair/f1oiewonnx1sbbtneawa.png",
            ],

            [
                'service_id' => $service->id,
                'item' => 'TVs',
                'image' => "https://res.cloudinary.com/dxjt9xfjb/image/upload/v1679743406/serviceItems/electricalRepair/civcsd9wlqkdnjq7d685.png",
            ],
            
        ];

        foreach ($items as $item) {
            $newItem = Item::create($item);
            // $service->items()->attach($newItem->id);
        }
    }
}
