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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('order_number');
            $table->string('order_date');
            $table->string('order_status');
            $table->string('payment_status');
            $table->string('address');
            $table->string('total_amount');
            $table->string('notes')->nullable();
            $table->date('delivery_date');  //expected date to be delivered
            $table->boolean('delivered')->default(0);
            $table->string('feedback')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');            
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
        Schema::dropIfExists('orders');
    }
};
