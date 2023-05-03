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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('cart_id');
            $table->string('phone');
            $table->string('address');
            $table->string('payment_method');
            $table->float('subtotal');
            $table->decimal('discount');
            $table->date('order_date');
            $table->string('order_number');
            $table->decimal('tax')->default(7.50);
            $table->float('shippingcost');
            $table->float('additionalcharge')->nullable();
            $table->text('notes')->nullable();
            $table->string('review')->nullable();
            $table->decimal('total');
            $table->tinyInteger('status');
            $table->tinyInteger('payment_status')->default(0); //paid
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('cart_id')->references('id')->on('carts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
};
