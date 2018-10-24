<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapScreensTables extends Migration
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
      'map_screens',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name' );
        $table->boolean( 'active' )->default( false )->index();

        $table->string( 'tab_label' )->index();
        $table->integer( 'display_order' )->default( 0 )->index();

        $table->string( 'caption' )->index();

        $table->integer( 'touchscreen_image_id' )->unsigned()->nullable();
        $table->foreign( 'touchscreen_image_id' )->references( 'id' )->on( 'touchscreen_images' );

        $table->timestamps();

      }
    );

    Schema::table(
      'map_screens',
      function ( Blueprint $table )
      {
  
        $table->unique( [ 'event_instance_id', 'name' ] );
  
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
    Schema::dropIfExists( 'map_screens' );
  }

  /****************************************************************************/

}
