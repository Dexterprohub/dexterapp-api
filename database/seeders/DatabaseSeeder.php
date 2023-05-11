<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\InternalUser;

use App\Models\Role;
use App\Models\Vendor;
use App\Models\Food;
use App\Models\Address;
use App\Models\CartProduct;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RoleTableSeeder::class,
            UserSeeder::class,
            VendorSeeder::class,
            ServiceSeeder::class,
            ItemSeeder::class,
            ShopSeeder::class,
            CategorySeeder::class,     
            ProductTableSeeder::class,
            // CartSeeder::class,
            // CartProductSeeder::class,
            // AddressSeeder::class,
            // ElectricalServiceSeeder::class,
            
            OfferSeeder::class,
            // BookingSeeder::class,
            ReviewSeeder::class,
            // FavouriteSeeder::class,
            // StateSeeder::class,
            // CitySeeder::class,
            // QualificationSeeder::class
            // CategorySeeder::class,
            
            // PermissionTableSeeder::class,
            // RolePermissionSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
