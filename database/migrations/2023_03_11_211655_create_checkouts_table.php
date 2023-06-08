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
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('cart_id')->constrained();
            $table->string('phone');
            $table->string('address');
            $table->string('payment_method');
            $table->string('subtotal');
            $table->string('discount');
            $table->date('order_date');
            $table->string('order_number')->unique();
            $table->decimal('tax')->default(7.50);
            $table->string('shippingcost');
            $table->string('additionalcharge')->nullable();
            $table->text('notes')->nullable();
            $table->string('review')->nullable();
            $table->string('total');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending'); //paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
