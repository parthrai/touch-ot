<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorScreensTables extends Migration
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
      'sponsor_screens',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name' )->unique();
        $table->boolean( 'active' )->default( false )->index();

        $table->string( 'tab_label' )->index();
        $table->integer( 'display_order' )->default( 0 )->index();

        $table->integer( 'touchscreen_image_id' )->unsigned()->nullable();
        $table->foreign( 'touchscreen_image_id' )->references( 'id' )->on( 'touchscreen_images' );

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
    Schema::dropIfExists( 'sponsor_screens' );
  }

  /****************************************************************************/

}
