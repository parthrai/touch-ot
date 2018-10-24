<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialCardConfigTables extends Migration
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
      'social_card_configs',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->integer( 'fetch_batchsize_tweets' );

        $table->integer( 'display_max_items' );

        $table->integer( 'appworks_posts_ratio' );
        $table->integer( 'tweets_ratio' );

        $table->integer( 'appworks_posts_featured' );
        $table->integer( 'tweets_featured' );

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

    Schema::dropIfExists( 'social_card_configs' );

  }

  /****************************************************************************/

}
