<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;
use App\MapScreen;

class MapScreensSeeder extends Seeder
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

    MapScreen::whereNotNull('id')->forceDelete();

    $this->SeedMapScreens( $faker, 10 );
    
  }

  /****************************************************************************/

  public function SeedMapScreens ( $faker, $max = 10 )
  {

    for( $i = 0 ; $i < $max ; $i++ )
    {
      $screen                       = new MapScreen();
      $screen->name                 = $faker->unique()->regexify( '[a-z]{10}' );
      $screen->active               = true;
      $screen->tab_label            = $faker->word();
      $screen->display_order        = $i + 1;
      $screen->caption              = $faker->bs();
      $screen->touchscreen_image_id = TouchscreenImage::inRandomOrder()->value('id');
      $screen->save();
    }

  }

  /****************************************************************************/

}
