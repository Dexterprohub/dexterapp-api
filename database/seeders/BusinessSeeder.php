<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Service;
use App\Models\Shop;
class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Business::factory()->count(20)->create();

        $services = Service::all();
        $service_name = ['Shortlet', 'Fashion Designer', 'Grocery Shopping'];
        
        $shop_id = Shop::inRandomOrder()->first()->id;
        // $service_id = Service::whereName('Laundry')->first()->id;
        $name = 'Mermaid\'s Laundry & Dry Cleaning';
        $bio = 'this is really the bio of the business';
        $address = '25b Nelson Street, Ducor Hill';
        $image = 'https://img.freepik.com/free-photo/young-african-american-man-doing-laundry_273609-23238.jpg?w=996&t=st=1677102769~exp=1677103369~hmac=01569e63b0312a504743af0f5c241a3b0c5f75268232bddbf865d94133ec2e53';
        
        
        $shop_id1 = Shop::inRandomOrder()->first()->id;
        // $service_id1 = Service::whereName('Beauty Services')->first()->id;
        $name1 = 'Kemi\'s Beauty';
        $bio1 = 'this is really the bio of the business';
        $address1 = '33 Ashmun St.M';
        $image1 = 'https://img.freepik.com/free-photo/make-up-products-arrangement-top-view_23-2149096666.jpg?w=996&t=st=1677104380~exp=1677104980~hmac=cfcc6fcbfc99888606ab14a7856a95d42dd9b7a96bb85a5b5aabdb7c04a8f4b0';
        
        
        $shop_id2 = Shop::inRandomOrder()->first()->id;
        // $service_id2 = Service::whereName('House Cleaning')->first()->id;
        $name2 = 'Gross Pain Plumbing Services';
        $bio2 = 'this is really the bio of the business';
        $address2 = '12 Abc Street';
        $image2 = 'https://img.freepik.com/free-photo/closeup-shot-pipe-wrench-screwing-nut_181624-49738.jpg?w=996&t=st=1677104460~exp=1677105060~hmac=999ac0d879ac8e714cdcefeb833ff47038826d867338b1a9736cb1b1162a59dd';
        
        $shop_id3 = Shop::inRandomOrder()->first()->id;
        // $service_id3 = Service::whereName('Beauty Services')->first()->id;
        $name3 = 'Siji ( and the rest ) Beauty Salon';
        $bio3 = 'this is really the bio of the business';
        $address3 = '12 Abc Street';
        $image3 = 'https://img.freepik.com/free-photo/brushes-accessories-accessories-makeup_78826-2191.jpg?w=996&t=st=1677104676~exp=1677105276~hmac=fd139e86f49c6b62b94c6e432875de0eb05724002903fbb2b0efbfc9ca446295';
       
        $shop_id4 = Shop::inRandomOrder()->first()->id;
        // $service_id4 = Service::whereName('Beauty Services')->first()->id;
        $name4 = 'Mermaid\'s Laundry & Dry Cleaning';
        $bio4 = 'this is really the bio of the business';
        $address4 = '3a Meclin Street, Mamba Point';
        $image4 = 'https://img.freepik.com/free-photo/young-african-american-man-doing-laundry_273609-23238.jpg?w=996&t=st=1677102769~exp=1677103369~hmac=01569e63b0312a504743af0f5c241a3b0c5f75268232bddbf865d94133ec2e53';
        
        $shop_id5 = Shop::inRandomOrder()->first()->id;
        // $service_id5 = Service::whereName('Grocery Shopping')->first()->id;
        $name5 = 'Almighty Groceries Store';
        $bio5 = 'Buy your groceries';
        $address5 = '12 Broad Street Ave. Monrovia';
        $image5 = 'https://img.freepik.com/premium-photo/trays-raspberries-strawberries-mirabelle-plums-market-stall_633872-1568.jpg';
    
        $business = [
            'shop_id' => $shop_id,
            // 'service_id' => $service_id,
            'address' => $address,
        ];
        $business1 = [
            'shop_id' => $shop_id1,
            // 'service_id' => $service_id1,
            'address' => $address1,
        ];
        $business2 = [
            'shop_id' => $shop_id2,
            // 'service_id' => $service_id2,
            'address' => $address2,
        ];
        $business3 = [
            'shop_id' => $shop_id3,
            // 'service_id' => $service_id3,
            'address' => $address3,
        ];
        $business4 = [
            'shop_id' => $shop_id4,
            // 'service_id' => $service_id4,
            'address' => $address4,
        ];
        $business5 = [
            'shop_id' => $shop_id5,
            // 'service_id' => $service_id5,
            'address' => $address5,
        ];
        Business::create($business);
        Business::create($business1);
        Business::create($business2);
        Business::create($business3);
        Business::create($business4);
        Business::create($business5);
    
    }
}
