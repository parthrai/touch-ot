<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardsTables extends Migration
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
      'leaderboards',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name', 255 )->index();

        $table->string( 'image_xs', 255 )->nullable();
        $table->string( 'image_sm', 255 )->nullable();
        $table->string( 'image_md', 255 )->nullable();
        $table->string( 'image_lg', 255 )->nullable();

        $table->integer( 'display_order' )->index();

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

    Schema::dropIfExists( 'leaderboards' );

  }

  /****************************************************************************/

}
