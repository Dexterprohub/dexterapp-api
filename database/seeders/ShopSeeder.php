<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Auth;
use App\Models\Shop;
use App\Models\Vendor;
use App\Models\Service;


class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendor_id = Vendor::inRandomOrder()->first()->id;
        $name = "The Shop One";
        $bio = "Everything you know about the shop";
        $cover_image = "https://img.freepik.com/free-photo/young-african-american-man-doing-laundry_273609-23238.jpg?w=996&t=st=1677102769~exp=1677103369~hmac=01569e63b0312a504743af0f5c241a3b0c5f75268232bddbf865d94133ec2e53";
        $opened_from = "8:00";
        $opened_to = "9:30";
        $discount = 0;
        $address = "the address email";
        $email = "emlail@gmail.com";
        $phone = "+2349018278154";
        $min_order = 1200;
        $additionalcharge = 800;
        $shippingcost = 700;

        $vendor_id1 = Vendor::inRandomOrder()->first()->id;
        $name1 = "The Park and The Shop";
        $bio1 = "Everything you know about the part and the shop";
        $cover_image1 = "https://img.freepik.com/free-photo/brushes-accessories-accessories-makeup_78826-2191.jpg?w=996&t=st=1677104676~exp=1677105276~hmac=fd139e86f49c6b62b94c6e432875de0eb05724002903fbb2b0efbfc9ca446295";
        $opened_from1 = "8:00";
        $opened_to1 = "9:30";
        $discount1 = 0;
        $address1 = "the address email";
        $email1 = "emaill@gmail.com";
        $phone1 = "+2349018223556";
        $min_order1 = 1200;
        $additionalcharge1 = 800;
        $shippingcost1 = 700;

        $shop = [
            'vendor_id' => $vendor_id,
            'name' => $name,
            'bio' => $bio,
            'opened_from' => $opened_from,
            'opened_to' => $opened_to,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'min_order' => $min_order,
            'additionalcharge' => $additionalcharge,
            'shippingcost' => $shippingcost,
        ];


        $shop1 = [
            'vendor_id' => $vendor_id1,
            'name' => $name1,
            'bio' => $bio1,
            'cover_image' => $cover_image1,
            'opened_from' => $opened_from1,
            'opened_to' => $opened_to1,
            'address' => $address1,
            'email' => $email1,
            'phone' => $phone1,
            'min_order' => $min_order1,
            'additionalcharge' => $additionalcharge1,
            'shippingcost' => $shippingcost1,
        ];

        Shop::create($shop);
        Shop::create($shop1);
    }
}
