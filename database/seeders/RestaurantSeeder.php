<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food_delivery = 'Food Delivery';
        $service_id = Service::whereName($food_delivery)->first()->id;
        $vendor_id = Vendor::inRandomOrder()->first()->id;
        $name = 'Crunchies';
        $min_order = '1400';
        $delivery_fee = '300';
        $service_type = Service::get()->first->id;
        $description = "lorem ipsum is the descrioption of the restuarnt";
        $image = "https://img.freepik.com/free-photo/restaurant-hall-with-red-brick-walls-wooden-tables-pipes-ceiling_140725-8504.jpg?w=826&t=st=1677000314~exp=1677000914~hmac=7e075684cbb74a19d9d1aa5493ebc7231982495f3b93f72e643c3dc68ea4b1ee";
        $address = "803 Runolfsdottir Club\nReynoldshaven, OK 61630";
        $phone = "09876543210";
        $mail = "user@gmail.com";

        $service_id1 = Service::whereName($food_delivery)->first()->id;
        $vendor_id1 = Vendor::inRandomOrder()->first()->id;
        $name1 = 'Jeepers Pans';
        $min_order1 = '1500';
        $delivery_fee1 = '450';
        $service_type1 = 'Fast Delivery';
        $description1 = "lorem ipsum is the descrioption of the restuarnt";
        $image1 = "https://img.freepik.com/free-photo/luxury-restaurant-grill-bar-interior-with-chandeliers-furniture_114579-2341.jpg?w=996&t=st=1677000424~exp=1677001024~hmac=92395ff5a703c430a6267f937da86eea9e0bca0d5e693165fce2a15fc22d1204";
        $address1 = "803 Runolfsdottir Club\nReynoldshaven, OK 61630";
        $phone1 = "09876543211";
        $mail1 = "first@gmail.com";


        $service_id2 = Service::whereName($food_delivery)->first()->id;
        $vendor_id2 = Vendor::inRandomOrder()->first()->id;
        $name2 = 'Chicken Joint';
        $min_order2 = '1800';
        $delivery_fee2 = '400';
        $service_type2 = 'Fast Delivery';
        $description2 = "lorem ipsum is the descrioption of the restuarnt";
        $image2 = "https://img.freepik.com/free-photo/white-interior-blur-blurred-chair_1203-4272.jpg?2&w=996&t=st=1677000448~exp=1677001048~hmac=188f6c4fb793433268901dbeca62fa845daf8eb3a886bf1aec3e8c7c9ae09bca";
        $address2 = "803 Runolfsdottir Club\nReynoldshaven, OK 61630";
        $phone2 = "09876543212";
        $mail2 = "second@gmail.com";


        $service_id3 = Service::whereName($food_delivery)->first()->id;
        $vendor_id3 = Vendor::inRandomOrder()->first()->id;
        $name3 = 'Crucks & Mocks';
        $min_order3 = '1200';
        $delivery_fee3 = '200';
        $service_type3 = 'Fast Delivery';
        $description3 = "lorem ipsum is the descrioption of the restuarnt";
        $image3 = "https://img.freepik.com/free-photo/healthy-lunch-table-restaurant_140725-6523.jpg?w=740&t=st=1677000477~exp=1677001077~hmac=3edc58abf5b17c805c7acd71076ce7f2b34161f7f03e4698f9c726ccb2fd83c0";
        $address3 = "803 Runolfsdottir Club\nReynoldshaven, OK 61630";
        $phone3 = "09876543213";
        $mail3 = "third@gmail.com";


        $service_id4 = Service::whereName($food_delivery)->first()->id;
        $vendor_id4 = Vendor::inRandomOrder()->first()->id;
        $name4 = 'Kemi\'s Kitchen ';
        $min_order4 = '1500';
        $delivery_fee4 = '500';
        $service_type4 = 'Fast Delivery';
        $description4 = "lorem ipsum is the descrioption of the restuarnt";
        $image4 = "https://img.freepik.com/free-photo/restaurant-interior_1127-3393.jpg?w=996&t=st=1677000505~exp=1677001105~hmac=05c521c45db64f35c932f05beb4a3bdcb2d9d85baf3932a107953490b2a86d2d";
        $address4 = "803 Runolfsdottir Club\nReynoldshaven, OK 61630";
        $phone4 = "09876543214";
        $mail4 = "five@gmail.com";

    
        $restaurant = [
            'service_id' => $service_id,
            'vendor_id' => $vendor_id,
            'name' => $name,
            'min_order' => $min_order,
            'delivery_fee' => $delivery_fee,
            'description' => $description,
            'image' => $image,
            'address' => $address,
            'phone' => $phone,
            'email' => $mail
        ];
        $restaurant1 = [
            'service_id' => $service_id1,
            'vendor_id' => $vendor_id1,
            'name' => $name1,
            'min_order' => $min_order1,
            'delivery_fee' => $delivery_fee1,
            'description' => $description1,
            'image' => $image1,
            'address' => $address1,
            'phone' => $phone1,
            'email' => $mail1
        ];
        $restaurant2 = [
            'service_id' =>1,
            'vendor_id' => $vendor_id2,
            'name' => $name2,
            'min_order' => $min_order2,
            'delivery_fee' => $delivery_fee2,
            'description' => $description2,
            'image' => $image2,
            'address' => $address2,
            'phone' => $phone2,
            'email' => $mail2
        ];
        $restaurant3 = [
            'service_id' =>1,
            'vendor_id' => $vendor_id3,
            'name' => $name3,
            'min_order' => $min_order3,
            'delivery_fee' => $delivery_fee3,
            'description' => $description3,
            'image' => $image3,
            'address' => $address3,
            'phone' => $phone3,
            'email' => $mail3
        ];
        $restaurant4 = [
            'service_id' =>1,
            'vendor_id' => $vendor_id4,
            'name' => $name4,
            'min_order' => $min_order4,
            'delivery_fee' => $delivery_fee4,
            'description' => $description4,
            'image' => $image4,
            'address' => $address4,
            'phone' => $phone4,
            'email' => $mail4
        ];
        Restaurant::create($restaurant);
        Restaurant::create($restaurant1);
        Restaurant::create($restaurant2);
        Restaurant::create($restaurant3);
        Restaurant::create($restaurant4);
        

        
       
       

    }
}
