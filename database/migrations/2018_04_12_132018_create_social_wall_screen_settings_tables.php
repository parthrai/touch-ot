<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialWallScreenSettingsTables extends Migration
{
  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'social_wall_screen_settings',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'screen' );
        $table->boolean( 'status' )->default( true );
        $table->integer( 'duration' )->default( 10000 )->index(); // Milliseconds

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::table(
      'social_wall_screen_settings',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'screen' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

  }

  /****************************************************************************/

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down ()
  {
    Schema::dropIfExists( 'social_wall_screen_settings' );
  }

  /****************************************************************************/

}
