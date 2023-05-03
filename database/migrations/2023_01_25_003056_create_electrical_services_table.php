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
        Schema::create('electrical_services', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('additional_message_id');
            $table->string('item_name');
            $table->string('icon');
            $table->timestamps();
            // $table->text('specify_item')->nullable();
            // $table->datetime('inspection_time');
            // $table->text('message')->nullable();

            // $table->foreign('service_id')->references('id')->on('services');
            // $table->foreign('addtional_message_id')->references('id')->on('additional_messages');
        });

        // \DB::statement("ALTER TABLE electrical_services ADD icon MEDIUMBLOB ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electrical_services');
    }
};
