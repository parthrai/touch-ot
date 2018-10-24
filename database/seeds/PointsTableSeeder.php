<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\EventInstance;
use App\User;
use App\Point;

class PointsTableSeeder extends Seeder
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
    $max   = 1000;

    Point::whereNotNull('id')->forceDelete();

    for( $i = 0 ; $i < $max ; $i++ )
    {

      $point                     = new Point();
      $point->event_instance_id = EventInstance::inRandomOrder()->pluck('id')->first();
      $point->team              = $faker->randomElement( [ 'red', 'green', 'blue', 'yellow', 'beige', 'indigo' ] );
      $point->points            = $faker->randomElement( [ 100, 200, 500, 1000, 5000, 10000 ] );
      $point->audit             = User::inRandomOrder()->value('id');
      $point->source            = $faker->randomElement( [ 'SYSTEM', 'ARCADE' ] );

      $point->save();

    }

  }

  /****************************************************************************/

}
