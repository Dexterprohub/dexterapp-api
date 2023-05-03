<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Restaurant;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Food::factory()->count(50)->create();

        // $names = ['', 'Spicy Jollof', '', 'Chicken Pepper Soup' , 'Grilled Catfish', 'Barbecue Turkey'];
        
        $restaurant_id = Restaurant::inRandomOrder()->first()->id;
        $name = "Refuel Max Chicken Meal";
        $food_category_id = FoodCategory::inRandomOrder()->first()->id;
        $image = "https://img.freepik.com/free-photo/baked-chicken-wings-asian-style-tomatoes-sauce-plate_2829-10657.jpg?w=996&t=st=1676999818~exp=1677000418~hmac=81388b6d859143f2448f5c4c1463d226ff1863f3a326f3dc9c6b57bcd4d4b532";
        $price = "1800";
        $description = 'Rice and a piece of chicken with drink';
        
        $restaurant_id1 = Restaurant::inRandomOrder()->first()->id;
        $name1 = "Chicken Pepper Soup";
        $food_category_id1 = FoodCategory::inRandomOrder()->first()->id;
        $image1 = "https://img.freepik.com/free-photo/tasty-soup-pan-gray-surface-close-up-copy-space_176420-7000.jpg?w=996&t=st=1677903349~exp=1677903949~hmac=b49eaf981a4ab1a0742747450de2198c597a1fe7b40a6656d8e281487f9e10f4";
        $price1 = "2500";
        $description1 = '8 pieces of chicken with soup tha\'ts all';
        
        $restaurant_id2 = Restaurant::inRandomOrder()->first()->id;
        $name2 = "Collard Greens";
        $food_category_id2 = FoodCategory::inRandomOrder()->first()->id;
        $image2 = "https://as1.ftcdn.net/v2/jpg/00/74/31/38/1000_F_74313867_CaqminkJDRDyFNjj14klvxQXNm3BrN8u.jpg";
        $price2 = "3000";
        $description2 = 'Yup. This is a collard green dish sheeesh';
        
        $restaurant_id3 = Restaurant::inRandomOrder()->first()->id;
        $name3 = "Gravy and White rice";
        $food_category_id3 = FoodCategory::inRandomOrder()->first()->id;
        $image3 = "https://t4.ftcdn.net/jpg/00/26/40/25/240_F_26402555_GJ4s4ANbfBIFbdTK5VLD8PsL71gL18o8.jpg";
        $price3 = "1340";
        $description3 = 'Kinda like Nigerian rice and stew man';
        
        $restaurant_id4 = Restaurant::inRandomOrder()->first()->id;
        $name4 = "Palm Butter";
        $food_category_id4 = FoodCategory::inRandomOrder()->first()->id;
        $image4 = "https://res.cloudinary.com/dxjt9xfjb/image/upload/c_pad,b_auto:predominant,fl_preserve_transparency/v1677904023/food/PalmButter_1024x.jpg_pyuoux.jpg";
        $price4 = "4500";
        $description4 = 'Another One';
        
        $restaurant_id5 = Restaurant::inRandomOrder()->first()->id;
        $name5 = "Refuel Max Chicken Meal";
        $food_category_id5 = FoodCategory::inRandomOrder()->first()->id;
        $image5 = "https://img.freepik.com/free-photo/baked-chicken-wings-asian-style-tomatoes-sauce-plate_2829-10657.jpg?w=996&t=st=1676999818~exp=1677000418~hmac=81388b6d859143f2448f5c4c1463d226ff1863f3a326f3dc9c6b57bcd4d4b532";
        $price5 = "3000";
        $description5 = 'this food is ugly';
        
        $restaurant_id5 = Restaurant::inRandomOrder()->first()->id;
        $name5 = "Potato Greens";
        $food_category_id5 = FoodCategory::inRandomOrder()->first()->id;
        $image5 = "https://asset.cloudinary.com/dxjt9xfjb/8a2538dd0cb7325b188b9a205e6d6b70";
        $price5 = "1200";
        $description5 = 'Lordprettysosaxbrodie';
        
        $restaurant_id6 = Restaurant::inRandomOrder()->first()->id;
        $name6 = "Chicken and chips";
        $food_category_id6 = FoodCategory::inRandomOrder()->first()->id;
        $image6 = "https://img.freepik.com/premium-photo/fried-chicken-with-french-fries-nuggets-meal_1339-54738.jpg?w=996";
        $price6 = "2300";
        $description6 = 'chicken and chips meal';
        
        $restaurant_id7 = Restaurant::inRandomOrder()->first()->id;
        $name7 = "Refuel Max Chicken Meal";
        $food_category_id7 = FoodCategory::inRandomOrder()->first()->id;
        $image7 = "https://img.freepik.com/free-photo/fresh-potatoes-fri-with-souce_144627-5503.jpg?w=996&t=st=1677904464~exp=1677905064~hmac=931013fc915aa89f8c86ca03d435069cf8439ef1b82264660379839a3a8c235b";
        $price7 = "800";
        $description7 = 'with too much sauce';


        // $image1 = "https://img.freepik.com/free-photo/baked-chicken-wings-asian-style-tomatoes-sauce-plate_2829-10657.jpg?w=996&t=st=1676999818~exp=1677000418~hmac=81388b6d859143f2448f5c4c1463d226ff1863f3a326f3dc9c6b57bcd4d4b532";
        // $image2 = "https://img.freepik.com/free-photo/delicious-fried-chicken-plate_144627-27383.jpg?w=996&t=st=1676999951~exp=1677000551~hmac=19c2590117840a0739925c0ec9b6817543ef1aaf6b663500a6466b1e23f46eb7";
        // $image3 = "https://img.freepik.com/free-photo/chicken-wings-barbecue-sweetly-sour-sauce-picnic-summer-menu-tasty-food-top-view-flat-lay_2829-6471.jpg?w=996&t=st=1677000017~exp=1677000617~hmac=7adb0fd2779c763cc14146e9e469b9f3941500056d87f766a601516f17c37313";
        // $image4 = "https://img.freepik.com/free-photo/penne-pasta-tomato-sauce-with-chicken-tomatoes-wooden-table_2829-19744.jpg?w=996&t=st=1677000044~exp=1677000644~hmac=bcdbf7e6e73314dc077b2187680fbb564e1664ed12c7ac5a386364aeccb7cfd6";
        // $image5 = "https://img.freepik.com/free-photo/crispy-fried-chicken-plate-with-salad-carrot_1150-20212.jpg?w=996&t=st=1677000062~exp=1677000662~hmac=4a86a8380ab2054e42a532aaf24bff1e9271ef5958e03465edc64673e5950912";
        // $image6 = "https://img.freepik.com/premium-photo/fresh-tasty-homemade-burger-wooden-table_147620-1307.jpg?w=996";
        // $image7 = "https://img.freepik.com/premium-photo/fresh-tasty-homemade-burger-wooden-table_147620-1307.jpg?w=996";
        // $image8 = "https://img.freepik.com/premium-photo/traditional-uzbek-oriental-cuisine-uzbek-family-table-from-different-dishes-new-year-holiday_127425-162.jpg?w=900";
        // $image5 = "https://img.freepik.com/free-photo/crispy-fried-chicken-plate-with-salad-carrot_1150-20212.jpg?w=996&t=st=1677000062~exp=1677000662~hmac=4a86a8380ab2054e42a532aaf24bff1e9271ef5958e03465edc64673e5950912";



        $food = [
            'restaurant_id' => $restaurant_id,
            'name' => $name,
            'food_category_id' => $food_category_id,
            'image' => $image,
            'price' => $price,
            'description' => $description
        ];
        $food1 = [
            'restaurant_id' => $restaurant_id1,
            'name' => $name1,
            'food_category_id' => $food_category_id1,
            'image' => $image1,
            'price' => $price1,
            'description' => $description1
        ];
        $food2 = [
            'restaurant_id' => $restaurant_id2,
            'name' => $name2,
            'food_category_id' => $food_category_id2,
            'image' => $image2,
            'price' => $price2,
            'description' => $description2
        ];
        $food3 = [
            'restaurant_id' => $restaurant_id3,
            'name' => $name3,
            'food_category_id' => $food_category_id3,
            'image' => $image3,
            'price' => $price3,
            'description' => $description3
        ];
        $food4 = [
            'restaurant_id' => $restaurant_id4,
            'name' => $name4,
            'food_category_id' => $food_category_id4,
            'image' => $image4,
            'price' => $price4,
            'description' => $description4
        ];
        $food5 = [
            'restaurant_id' => $restaurant_id5,
            'name' => $name5,
            'food_category_id' => $food_category_id5,
            'image' => $image5,
            'price' => $price5,
            'description' => $description5
        ];
        $food6 = [
            'restaurant_id' => $restaurant_id6,
            'name' => $name6,
            'food_category_id' => $food_category_id6,
            'image' => $image6,
            'price' => $price6,
            'description' => $description6
        ];
        $food7 = [
            'restaurant_id' => $restaurant_id7,
            'name' => $name7,
            'food_category_id' => $food_category_id7,
            'image' => $image7,
            'price' => $price7,
            'description' => $description7
        ];
        $food8 = [
            'restaurant_id' => $restaurant_id5,
            'name' => $name5,
            'food_category_id' => $food_category_id5,
            'image' => $image5,
            'price' => $price5,
            'description' => $description5
        ];
        $food9 = [
            'restaurant_id' => $restaurant_id6,
            'name' => $name6,
            'food_category_id' => $food_category_id6,
            'image' => $image6,
            'price' => $price6,
            'description' => $description6
        ];
        $food10 = [
            'restaurant_id' => $restaurant_id7,
            'name' => $name7,
            'food_category_id' => $food_category_id7,
            'image' => $image6,
            'price' => $price7,
            'description' => $description7
        ];
        $food11 = [
            'restaurant_id' => $restaurant_id4,
            'name' => $name4,
            'food_category_id' => $food_category_id4,
            'image' => $image4,
            'price' => $price4,
            'description' => $description4
        ];
        $food12 = [
            'restaurant_id' => $restaurant_id7,
            'name' => $name7,
            'food_category_id' => $food_category_id7,
            'image' => $image7,
            'price' => $price7,
            'description' => $description7
        ];
        $food13 = [
            'restaurant_id' => $restaurant_id3,
            'name' => $name3,
            'food_category_id' => $food_category_id3,
            'image' => $image3,
            'price' => $price3,
            'description' => $description3
        ];

        Food::create($food);
        Food::create($food1);
        Food::create($food2);
        Food::create($food3);
        Food::create($food4);
        Food::create($food5);
        Food::create($food6);
        Food::create($food7);
        Food::create($food8);
        Food::create($food9);
        Food::create($food10);
        Food::create($food11);
        Food::create($food12);
        Food::create($food13);

    }
}
