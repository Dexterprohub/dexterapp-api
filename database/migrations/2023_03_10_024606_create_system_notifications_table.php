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
        Schema::create( 'system_notifications', static function ( Blueprint $table ) {
			$table->id();
			$table->integer('admin_id');
			$table->string( 'title' );
			$table->longText( 'body' );
			$table->longText( 'send_to_drivers' );
			$table->longText( 'send_to_users' );
			// $table->softDeletes();
			$table->timestamps();
		} );

		// Schema::table( 'system_notifications', static function ( Blueprint $table ) {
		// 	$table->foreign( 'admin_id' )
		// 	      ->references( 'id' )
		// 	      ->on( 'admins' );
		// } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_notifications');
    }
};
