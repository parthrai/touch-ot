<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use App\EventInstance;
use App\Point;
use App\User;

class CreateManyPointsTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many Points.
  *
  * @return void
  */
  public function testCreateManyPoints ()
  {

    $faker          = Faker::create();
    $max            = 1000;
    $event_instance = EventInstance::GetDefaultInstance();

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $point1                    = new Point();
      $point1->event_instance_id = $event_instance->id;
      $point1->team              = $faker->randomElement( [ 'red', 'green', 'blue', 'yellow', 'purple', 'orange', 'beige' ] );
      $point1->points            = $faker->numberBetween( 50, 10000 );
      $point1->audit             = User::inRandomOrder()->value( 'id' );
      $point1->source            = $faker->randomElement( [ 'SYSTEM', 'ARCADE' ] );
      $point1->save();

      $point2 = Point::find( $point1->id );

      $this->assertEquals( $point1->id, $point2->id );
      $this->assertEquals( $point1->event_instance_id, $point2->event_instance_id );
      $this->assertEquals( $point1->team, $point2->team );
      $this->assertEquals( $point1->points, $point2->points );
      $this->assertEquals( $point1->audit, $point2->audit );
      $this->assertEquals( $point1->source, $point2->source );

    }

  }

  /****************************************************************************/

}
