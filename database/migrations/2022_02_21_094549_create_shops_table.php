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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('name')->unique();
            $table->text('bio');
            $table->string('cover_image');
            $table->time('opened_from')->default('08:00');
            $table->time('opened_to')->default('10:00');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('discount')->nullable();
            $table->float('min_order')->nullable();
            $table->float('additionalcharge')->nullable()->default(700.00);
            $table->float('shippingcost')->nullable();
            $table->double('longitude')->default(87.487);
            $table->double('latitude')->default(97.3326);
            
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
