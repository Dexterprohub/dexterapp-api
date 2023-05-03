<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->default(1);
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->float('min_order');
            $table->time('opened_from')->nullable();
            $table->time('opened_to')->nullable();
            $table->string('cover_image')->default('restaurantImg.png');
            $table->string('image')->nullable();
            $table->string('address');
            $table->string('delivery_fee');
            $table->double('latitude')->default(27.23256);
            $table->integer('discount')->default(0);
            $table->float('vat')->default(7.50);
            $table->integer('additional_charge')->default(0);
            $table->double('longitude')->default(80.23256);
        //  $table->float('rating_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('vendor_id')->references('id')->on('vendors');

            
        });

        // \DB::statement("ALTER TABLE restaurants ADD img MEDIUMBLOB ");
        // \DB::statement("ALTER TABLE restaurants ADD cover_img MEDIUMBLOB ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
