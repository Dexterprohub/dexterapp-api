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
        Schema::create('shopdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->time('opened_from')->default('08:00');
            $table->time('opened_to')->default('10:00');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('discount')->nullable();
            $table->float('min_order')->nullable();
            $table->float('additionalcharge')->nullable();
            $table->float('shippingcost')->nullable();
            $table->unsignedBigInteger('review_id')->nullable();
            $table->unsignedInteger('jobscompleted')->default(0);
            $table->double('longitude')->default(87.487);
            $table->double('latitude')->default(97.3326);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('review_id')->references('id')->on('reviews');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopdetails');
    }
};
