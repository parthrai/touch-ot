<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTables extends Migration
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
      'points',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'event_instance_id' )->unsigned();
        $table->foreign( 'event_instance_id' )->references( 'id' )->on( 'event_instances' );

        $table->string( 'team' )->default( 'Unknown' )->index();
        $table->integer( 'points' )->default( 0 )->index();
        $table->integer( 'audit' )->nullable()->index();
        $table->string( 'source' )->default( 'Unknown' )->index();

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
    Schema::dropIfExists( 'points' );
  }

  /****************************************************************************/

}
