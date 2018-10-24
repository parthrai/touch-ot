<?php

use Faker\Factory as Faker;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

use App\ScoreboardTeam;
use App\ScoreboardMember;

class ScoreboardTablesSeeder extends Seeder
{

  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run ()
  {

    DB::beginTransaction();    
    ScoreboardMember::whereNotNull('id')->forceDelete();
    DB::commit();

    DB::beginTransaction();    
    ScoreboardTeam::whereNotNull('id')->forceDelete();
    DB::commit();

    $faker = Faker::create();

    $teams = [
      "Blue",
      "Clear",
      "Grey",
      "Purple",
      "Red",
      "Teal",
    ];

    foreach( $teams as $team_name )
    {

      $team            = new ScoreboardTeam();
      $team->team_name = $team_name;
      $team->save();

      for( $i = 0 ; $i < 32 ; $i++ )
      {

        $member              = new ScoreboardMember();
        $member->team_id     = $team->id;
        $member->member_name = $faker->unique()->name();
        $member->points      = $faker->numberBetween( $min = 50, $max = 100000 );
        $member->save();

      }

    }

    Cache::tags( [ 'Scoreboard', $event_instance_name ] )->flush();

  }

}
