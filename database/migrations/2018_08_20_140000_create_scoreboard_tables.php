<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreboardTables extends Migration
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
      'scoreboard_team_configs',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'name', 128 )->index();
        $table->string( 'display_name', 128 )->index();
        $table->string( 'hashtag', 32 )->index();

        $table->string( 'hex_background_color', 7 )->default( "#000000" );
        $table->string( 'hex_text_color', 7 )->default( "#FFFFFF" );

        $table->boolean( 'invisible' )->default( false )->index();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    Schema::table(
      'scoreboard_team_configs',
      function ( Blueprint $table )
      {
        $table->unique( [ 'event_instance_id', 'name' ] );
        $table->unique( [ 'event_instance_id', 'hashtag' ] );
      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'scoreboard_teams',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'team_name' );

        $table->bigInteger( 'points' )->default(0)->index();
        $table->bigInteger( 'points_aggregate' )->default(0)->index();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    Schema::table(
      'scoreboard_teams',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'team_name' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'scoreboard_members',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->integer( 'team_id' )->unsigned()->nullable()->index();
        $table->foreign( 'team_id' )->references( 'id' )->on( 'scoreboard_teams' );

        $table->string( 'member_name' )->index();
        $table->bigInteger( 'points' )->default(0)->index();

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
    Schema::dropIfExists( 'scoreboard_members' );
    Schema::dropIfExists( 'scoreboard_teams' );
    Schema::dropIfExists( 'scoreboard_team_configs' );
  }

  /****************************************************************************/

}
