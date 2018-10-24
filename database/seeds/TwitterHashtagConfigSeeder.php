<?php

use Illuminate\Database\Seeder;

use App\TwitterHashtagConfig;

class TwitterHashtagConfigSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $hashtags = array(
      'otew',
    );

    DB::beginTransaction();    
    TwitterHashtagConfig::whereNotNull('id')->forceDelete();
    DB::commit();

    foreach( $hashtags as $hashtag )
    {

      DB::beginTransaction();

      try
      {

        $config          = new TwitterHashtagConfig();
        $config->hashtag = $hashtag;
        $config->enabled = true;
        $config->save();

        DB::commit();

      }
      catch( Exception $ex )
      {

        DB::rollBack();

        $this->command->info( $ex->getMessage() . "\n" );

      }

    }

  }

  /****************************************************************************/

}
