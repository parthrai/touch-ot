<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $in_continuous_integration = false;
    
    if( getenv('TRAVIS') )
    {
      $in_continuous_integration = true;
    }
    else
    {
      $in_continuous_integration = false;
    }

    // Only run seeders in development and testing environments
    if( App::environment( 'local' ) || App::environment( 'testing' ) )
    {

      $this->call( UsersTableSeeder::class );
      $this->call( EventInstancesSeeder::class );
      $this->call( SocialWallScreenSettingsSeeder::class );
      
      if( $in_continuous_integration )
      {
      
        $this->call( ScoreboardTeamConfigTableSeeder::class );
        $this->call( TwitterHashtagConfigSeeder::class );

      }
      else
      {

        /*
        $this->call( ScoreboardTeamConfigTableSeeder::class );
        $this->call( PointsTableSeeder::class );
        $this->call( ScoreboardTablesSeeder::class );

        $this->call( TwitterHashtagConfigSeeder::class );
        $this->call( SocialCardsTweetsSeeder::class );
        $this->call( SocialCardsAppworksPostsSeeder::class );
        
        $this->call( TouchscreenImageSeeder::class );
        
        $this->call( AgendaSeeder::class );
        $this->call( AgendaScreensSeeder::class );
        $this->call( MapScreensSeeder::class );
        $this->call( ExpoLevelsSeeder::class );
        //$this->call( ExpoMapsSeeder::class );
        $this->call( ExpoStandsSeeder::class );
        $this->call( EventScreensSeeder::class );
        $this->call( SponsorScreensSeeder::class );
        */

      }

    }

  }

  /****************************************************************************/

}
