<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('websockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id')->index();
            $table->string('type')->index();
            $table->text('payload');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('websockets_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id')->index();
            $table->integer('peak_connection_count');
            $table->integer('websocket_message_count');
            $table->integer('api_message_count');
            $table->timestamp('last_ping_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
        });

        Schema::create('websockets_apps', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->text('key');
            $table->text('secret');
            $table->string('path');
            $table->integer('capacity');
            $table->boolean('enable_client_messages')->default(true);
            $table->boolean('enable_statistics')->default(true);
            $table->timestamps();
        });

        Schema::create('websockets_connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id');
            $table->string('socket_id')->unique();
            $table->string('user_id')->nullable()->index();
            $table->text('payload');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });

        Schema::create('websockets_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('connection_id');
            $table->string('channel_name')->index();
            $table->string('channel_type')->nullable()->index();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamps();

            $table->foreign('connection_id')
                ->references('id')
                ->on('websockets_connections')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('websockets_statistics_entries');
        Schema::dropIfExists('websockets_statistics');
        Schema::dropIfExists('websockets_apps');
        Schema::dropIfExists('websockets_connections');
        Schema::dropIfExists('websockets_subscriptions');
    }
};
