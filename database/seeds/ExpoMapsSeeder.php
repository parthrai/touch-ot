<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;
use App\ExpoMap;

class ExpoMapsSeeder extends Seeder
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
    ExpoMap::whereNotNull('id')->forceDelete();
    $this->SeedExpoMaps( $faker, 1 );
  }

  /****************************************************************************/

  public function SeedExpoMaps ( $faker, $max = 1 )
  {
    for( $i = 0 ; $i < $max ; $i++ )
    {
      $expo_map                       = new ExpoMap();
      $expo_map->name                 = $faker->unique()->regexify( '[a-z]{10}' );
      $expo_map->touchscreen_image_id = TouchscreenImage::inRandomOrder()->value('id');
      $expo_map->save();
    }
  }

  /****************************************************************************/

}
