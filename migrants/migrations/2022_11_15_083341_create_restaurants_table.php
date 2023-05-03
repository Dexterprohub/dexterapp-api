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
            $table->string('name');
            $table->string('discount')->default(0);
            $table->string('vat')->default(0);
            $table->string('additional_charge')->default(0);
            $table->text('description');
            $table->string('cover_pic');
            $table->string('image');
            $table->float('rating');
            $table->string('min_order');
            $table->string('delivery_fee');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->boolean('status');
            $table->double('latitude')->default(27.23256);
            $table->double('longitude')->default(80.23256);
            
            $table->timestamps();
        });
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
