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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); //amount of food or menu
            $table->integer('product_id'); //number of orders
            $table->integer('quantity'); //quantity of the product ordered
            $table->decimal('tax',6,2)->default(7.50);
            $table->float('addtionalcharge')->default(700); //The additional charge of the products ordered (quantity * price).
            $table->string('shipping_cost')->nullable(); //The delivery fee of the products ordered (quantity * price).
            $table->decimal('subtotal'); //The subtotal cost of the products ordered (quantity * price).
            $table->float('total'); // The total cost of the order detail (subtotal + tax + shipping cost).
            $table->timestamps();


            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
