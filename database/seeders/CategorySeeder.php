<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Shop;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Fruits & Vegetables',
            'cover_image' => 'https://img.freepik.com/free-photo/colorful-fruits-tasty-fresh-ripe-juicy-white-desk_179666-169.jpg?w=996&t=st=1677447458~exp=1677448058~hmac=f4fb4258323fac1290092fb45562f75c930c7cf4f3a6f4e049c2d5e0c758c2e5'
        ];
        $category1 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Breakfast',
            'cover_image' => 'https://as1.ftcdn.net/v2/jpg/00/78/87/94/1000_F_78879462_KyMC4iWhDHLlEEZDAOLiDWPuubnAaMMk.jpg'
        ];
        $category2 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Beverages',
            'cover_image' => 'https://as2.ftcdn.net/v2/jpg/02/79/69/21/1000_F_279692163_4O1mMxIe4KdK3GZYl8gDY02zBFn65Gj0.jpg'
        ];
        $category3 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Beef & Fish',
            'cover_image' => 'https://as2.ftcdn.net/v2/jpg/01/00/51/55/1000_F_100515508_vyTxVQp8uiwp0HQ8Y8DlCyjzX6E2NyT8.jpg'
        ];
        $category4 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Snacks',
            'cover_image' => 'https://as2.ftcdn.net/v2/jpg/00/63/35/35/1000_F_63353567_NsxAywllSY4oxvkOyrMVDMk24N0doBn1.jpg'
        ];
        $category5 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Diary',
            'cover_image' => 'https://as1.ftcdn.net/v2/jpg/00/81/20/18/1000_F_81201885_dnZ6sOivjDORmBCLhDBxg6rSJRR8PJ4t.jpg'
        ];
        $category6 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'AC Unit',
            'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464237/technicalserviceicons/taovn0pgmie5owv1jecp.png'
        ];
        $category7 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Fridge',
            'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464326/technicalserviceicons/iyr3ahuwhebvxsfpbvk7.png'
        ];
        $category8 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Washing Machine',
            'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464430/technicalserviceicons/d7xqh3y4sqzjcvvrnuti.png'
        ];
        $category9 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'Gas Cooker',
            'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464357/technicalserviceicons/twmlvocmfq1hevpzzdci.png'
        ];
        $category10 = [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => 'TV',
            'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464489/technicalserviceicons/gcunaregcg6ixw2cqxow.png'
        ];
        // $laundry = [
        //     'shop_id' => 2,
        //     'name' => 'Dry Clean',
        //     'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464489/technicalserviceicons/gcunaregcg6ixw2cqxow.png'
        // ];
        // $laundry1 = [
        //     'shop_id' => 2,
        //     'name' => 'Laundry',
        //     'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464489/technicalserviceicons/gcunaregcg6ixw2cqxow.png'
        // ];
        // $laundry2 = [
        //     'shop_id' => 2,
        //     'name' => 'Ironing',
        //     'cover_image' => 'https://res.cloudinary.com/dxjt9xfjb/image/upload/v1677464489/technicalserviceicons/gcunaregcg6ixw2cqxow.png'
        // ];

        Category::create($category);
        Category::create($category1);
        Category::create($category2);
        Category::create($category3);
        Category::create($category4);
        Category::create($category5);
        Category::create($category6);
        Category::create($category7);
        Category::create($category8);
        Category::create($category9);
        Category::create($category10);
        // Category::create($laundry);
        // Category::create($laundry1);
        // Category::create($laundry2);
    }
}
