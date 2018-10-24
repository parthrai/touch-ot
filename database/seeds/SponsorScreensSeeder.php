<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;
use App\SponsorScreen;

class SponsorScreensSeeder extends Seeder
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

    SponsorScreen::whereNotNull('id')->forceDelete();

    $this->SeedSponsorScreens( $faker, 10 );
    
  }

  /****************************************************************************/

  public function SeedSponsorScreens ( $faker, $max = 10 )
  {

    for( $i = 0 ; $i < $max ; $i++ )
    {
      $screen                       = new SponsorScreen();
      $screen->name                 = $faker->unique()->regexify( '[a-z]{10}' );
      $screen->active               = true;
      $screen->tab_label            = $faker->word();
      $screen->display_order        = $i + 1;
      $screen->touchscreen_image_id = TouchscreenImage::inRandomOrder()->value('id');
      $screen->save();
    }

  }

  /****************************************************************************/

}
