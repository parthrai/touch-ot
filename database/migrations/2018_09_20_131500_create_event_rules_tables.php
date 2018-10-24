<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRulesTables extends Migration
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
      'event_rules_survey_session_types',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'event_rule_uuid', 64 )->index();
        $table->string( 'name', 255 )->index();
        $table->boolean( 'enabled' )->default( false )->index();
        $table->boolean( 'external' )->default( false )->index();

        $table->boolean( 'hard_coded' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'event_rules_survey_session_types',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'event_rule_uuid' ], 'event_rules_survey_session_types_uniq' );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'event_rules_session_type_visibilities',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'event_rule_uuid', 64 )->index();
        $table->string( 'name', 255 )->index();
        $table->boolean( 'enabled' )->default( false )->index();
        $table->boolean( 'external' )->default( false )->index();

        $table->boolean( 'hard_coded' )->default( false )->index();

        $table->integer( 'fetch_batch' )->nullable()->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'event_rules_session_type_visibilities',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'event_rule_uuid' ], 'event_rules_session_type_visibilities_uniq' );

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
    Schema::dropIfExists( 'event_rules_session_type_visibilities' );
    Schema::dropIfExists( 'event_rules_survey_session_types' );
  }

  /****************************************************************************/

}
