<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaTables extends Migration
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
      'agenda_announcements',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'announcement' )->index();

        $table->timestamps();

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'agenda_schedule_events',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'session_id', 64 );

        $table->date( 'date' )->index();

        $table->time( 'time_start' )->index();
        $table->time( 'time_end' )->index();

        $table->integer( 'display_order' )->default(0)->index();

        $table->string( 'title', 1024 );
        $table->string( 'title_override', 1024 );

        $table->text( 'description' )->nullable();
        $table->text( 'description_override' )->nullable();

        $table->string( 'location', 255 );
        $table->string( 'location_override', 255 );

        $table->boolean( 'hidden' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'agenda_schedule_events',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'session_id' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'agenda_breakout_sessions',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'session_id', 64 );

        $table->date( 'date' )->index();

        $table->time( 'time_start' )->index();
        $table->time( 'time_end' )->index();

        $table->integer( 'display_order' )->default(0)->index();

        $table->string( 'icon', 255 )->nullable();

        $table->string( 'title', 1024 );
        $table->string( 'title_override', 1024 );

        $table->text( 'description' )->nullable();
        $table->text( 'description_override' )->nullable();

        $table->string( 'location', 255 );
        $table->string( 'location_override', 255 );

        $table->boolean( 'hidden' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'agenda_breakout_sessions',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'session_id' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'agenda_screens',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name' );
        $table->boolean( 'active' )->default( false )->index();
        $table->enum( 'type', [ 'announcement', 'image', 'schedule' ] );
        $table->date( 'date' )->index()->nullable();

        $table->string( 'tab_label' )->index();
        $table->integer( 'display_order' )->default(0)->index();

        $table->integer( 'agenda_announcement_id' )->unsigned()->nullable();
        $table->foreign( 'agenda_announcement_id' )->references( 'id' )->on( 'agenda_announcements' );

        $table->integer( 'touchscreen_image_id' )->unsigned()->nullable();
        $table->foreign( 'touchscreen_image_id' )->references( 'id' )->on( 'touchscreen_images' );

        $table->timestamps();

      }
    );

    Schema::table(
      'agenda_screens',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'name' ] );

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
    Schema::dropIfExists( 'agenda_screens' );
    Schema::dropIfExists( 'agenda_breakout_sessions' );
    Schema::dropIfExists( 'agenda_schedule_events' );
    Schema::dropIfExists( 'agenda_announcements' );
  }

  /****************************************************************************/

}
