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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->integer('discount')->default(0);
            $table->time('opened_from');
            $table->time('opened_to');
            $table->string('address');
            $table->string('rating')->default(2);
            // $table->string('cover_image')->nullable();
            //$table->string('offers')->nullable();
            $table->string('vat')->nullable();
            $table->string('addtional_charge')->nullable();
            
            $table->string('jobs_completed')->default(3);
            $table->double('longitude')->default(27.487);
            $table->double('latitude')->default(27.3326);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('businesses');
            
        });
        // \DB::statement("ALTER TABLE businesses ADD cover_image MEDIUMBLOB ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
