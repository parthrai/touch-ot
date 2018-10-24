<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouchscreenImageTables extends Migration
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
      'touchscreen_images',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name', 255 );

        $table->string( 'image_xs', 255 )->nullable();
        $table->string( 'image_sm', 255 )->nullable();
        $table->string( 'image_md', 255 )->nullable();
        $table->string( 'image_lg', 255 )->nullable();

        $table->string( 'link', 1024 )->nullable();

        $table->timestamps();

      }
    );

    Schema::table(
      'touchscreen_images',
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
    Schema::dropIfExists( 'touchscreen_images' );
  }

  /****************************************************************************/

}
