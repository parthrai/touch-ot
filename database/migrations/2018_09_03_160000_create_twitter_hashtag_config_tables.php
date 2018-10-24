<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterHashtagConfigTables extends Migration
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
      'twitter_hashtag_configs',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'hashtag', 128 );
        $table->boolean( 'enabled' )->default( true )->index();

        $table->timestamps();

      }
    );

    Schema::table(
      'twitter_hashtag_configs',
      function ( Blueprint $table )
      {

        $table->unique( [ 'event_instance_id', 'hashtag' ] );

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
    Schema::dropIfExists( 'twitter_hashtag_configs' );
  }

  /****************************************************************************/

}
