<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon;
use App\Models\Shopdetail;

class ShopdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Shopdetail::factory()->count(2)->create();
        // $table->unsignedBigInteger('shop_id');
            // $table->integer('discount')->default(0);
            // $table->time('opened_from');
            // $table->time('opened_to');
            // $table->string('address');
            // $table->string('rating')->default(2);
            // // $table->string('cover_image')->nullable();
            // //$table->string('offers')->nullable();
            // $table->string('email')->unique();
            // $table->string('phone')->unique();
            // $table->string('min_order')->nullable();
            // $table->string('vat')->nullable();
            // $table->string('additional_charge')->nullable();
            // $table->string('delivery_fee')->nullable();
            // $table->string('jobs_completed')->default(3);
            // $table->double('longitude')->default(27.487);
            // $table->double('latitude')->default(27.3326);


            // $opened_from = Carbon::createFromTime($hour, $min);
    }
}
