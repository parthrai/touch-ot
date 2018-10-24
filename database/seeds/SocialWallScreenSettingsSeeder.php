<?php

use Illuminate\Database\Seeder;

use App\EventInstance;
use App\SocialWallScreenSetting;

class SocialWallScreenSettingsSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {
    
    try
    {

      $event_instance_name = EventInstance::GetDefaultInstance()->value( 'name' );

      if( SocialWallScreenSetting::count() <= 0 )
      {
        SocialWallScreenSetting::ResetToDefaults( $event_instance_name );
      }

    }
    catch( Exception $ex )
    {

      $this->command->info( $ex->getMessage() . "\n" );

    }

  }

  /****************************************************************************/

}
