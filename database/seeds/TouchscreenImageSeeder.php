<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;

class TouchscreenImageSeeder extends Seeder
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

    $this->SeedTouchscreenImages( $faker, 100 );
    
  }

  /****************************************************************************/

  public function SeedTouchscreenImages ( $faker, $max = 100 )
  {

    TouchscreenImage::whereNotNull('id')->forceDelete();

    for( $i = 0 ; $i < $max ; $i++ )
    {
      $image           = new TouchscreenImage();
      $image->name     = $faker->unique()->regexify( '[A-Za-z0]{10}' );
      $image->image_xs = $faker->unique()->regexify( '[a-z09-9]{32}\.png' );
      $image->image_sm = $faker->unique()->regexify( '[a-z09-9]{32}\.png' );
      $image->image_md = $faker->unique()->regexify( '[a-z09-9]{32}\.png' );
      $image->image_lg = $faker->unique()->regexify( '[a-z09-9]{32}\.png' );
      $image->link     = $faker->url();
      $image->save();
    }

  }

  /****************************************************************************/

}
