<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventInstanceTables extends Migration
{
  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {
    Schema::create(
      'event_instances',
      function ( Blueprint $table )
      {
        $table->increments( 'id' );
        $table->uuid( 'event_uuid' )->unique();
        $table->boolean( 'active' )->default( false );
        $table->string( 'name', 255 )->index();
        $table->string( 'display_name', 255 )->index();
        $table->string( 'timezone', 255 )->index();
        $table->date( 'date_start' )->index();
        $table->date( 'date_end' )->index();
        $table->boolean( 'game_enabled' )->default( true );
        $table->softDeletes();
        $table->timestamps();
      }
    );
  }

  /****************************************************************************/

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down ()
  {
    Schema::dropIfExists( 'event_instances' );
  }

  /****************************************************************************/

}
