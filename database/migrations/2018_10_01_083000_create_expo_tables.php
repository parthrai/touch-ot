<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpoTables extends Migration
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
      'expo_maps',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'map_id', 64 );

        $table->string( 'name' );

        $table->integer( 'touchscreen_image_id' )->unsigned()->nullable();
        $table->foreign( 'touchscreen_image_id' )->references( 'id' )->on( 'touchscreen_images' );

        $table->boolean( 'default' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'expo_maps',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'map_id' ] );
        $table->unique( [ 'event_instance_id', 'name' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'expo_levels',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'expo_level_id', 64 );

        $table->string( 'name', 255 )->index();

        $table->boolean( 'hidden' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'expo_levels',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'expo_level_id' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'expo_stands',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'stand_id', 64 );

        $table->string( 'exhibitor', 255 )->index();
        $table->string( 'exhibitor_override', 255 )->index();
        $table->string( 'stand', 255 ); // This is a string instead of an integer, in case we need something like "123 A", "123 B", etc.

        $table->integer( 'expo_map_id' )->unsigned()->nullable()->index();
        $table->foreign( 'expo_map_id' )->references( 'id' )->on( 'expo_maps' );

        $table->decimal( 'position_x', 8, 4 )->default(0.0);;
        $table->decimal( 'position_y', 8, 4 )->default(0.0);;

        $table->integer( 'expo_level_id' )->unsigned()->nullable()->index();
        $table->foreign( 'expo_level_id' )->references( 'id' )->on( 'expo_levels' );

        $table->boolean( 'hidden' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'expo_stands',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'stand_id' ] );
        $table->unique( [ 'event_instance_id', 'stand' ] );

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
    Schema::dropIfExists( 'expo_stands' );
    Schema::dropIfExists( 'expo_levels' );
    Schema::dropIfExists( 'expo_maps' );
  }

  /****************************************************************************/

}
