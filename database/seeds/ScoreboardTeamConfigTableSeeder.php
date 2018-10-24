<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\ScoreboardTeamConfig;

class ScoreboardTeamConfigTableSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {
    ScoreboardTeamConfig::ResetToDefaultTeams( 'default' );
  }

  /****************************************************************************/

}
