<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\ExpoLevel;

class ExpoLevelsSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {
    $faker = Faker::create();
    ExpoLevel::whereNotNull('id')->forceDelete();
    $this->SeedExpoLevels( $faker, 10 );
  }

  /****************************************************************************/

  public function SeedExpoLevels ( $faker, $max = 10 )
  {
    for( $i = 0 ; $i < $max ; $i++ )
    {
      $expo_level                = new ExpoLevel();
      $expo_level->expo_level_id = $faker->uuid();
      $expo_level->name          = $faker->bs();
      $expo_level->hidden        = $faker->boolean();
      $expo_level->save();
    }
  }

  /****************************************************************************/

}
