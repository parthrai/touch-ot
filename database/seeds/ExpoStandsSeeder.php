<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;
use App\ExpoLevel;
use App\ExpoMap;
use App\ExpoStand;

class ExpoStandsSeeder extends Seeder
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
    ExpoStand::whereNotNull('id')->forceDelete();
    $this->SeedExpoStands( $faker, 250 );
  }

  /****************************************************************************/

  public function SeedExpoStands ( $faker, $max = 10 )
  {
    for( $i = 0 ; $i < $max ; $i++ )
    {
      $expo_stand                = new ExpoStand();
      $expo_stand->stand_id      = $faker->uuid();
      $expo_stand->exhibitor     = $faker->company();
      $expo_stand->stand         = $i + 1;
      $expo_stand->expo_map_id   = ExpoMap::inRandomOrder()->value('id');
      $expo_stand->position_x    = $faker->numberBetween( 1.0, 100.0 );
      $expo_stand->position_y    = $faker->numberBetween( 1.0, 100.0 );
      $expo_stand->expo_level_id = ExpoLevel::inRandomOrder()->value('id');
      $expo_stand->hidden        = $faker->boolean();
      $expo_stand->save();
    }
  }

  /****************************************************************************/

}
