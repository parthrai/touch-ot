<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use App\EventInstance;

class CreateManyEventInstancesTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many Event Instances.
  *
  * @return void
  */
  public function testCreateManyEventInstances ()
  {

    $faker = Faker::create();
    $max   = 500;

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $event1               = new EventInstance();
      $event1->event_uuid   = $faker->uuid();
      $event1->active       = $faker->boolean();
      $event1->name         = $faker->text( 255 );
      $event1->display_name = $faker->text( 255 );
      $event1->timezone     = $faker->timezone();
      $event1->date_start   = $faker->dateTimeBetween( 'now', '+90 days' );
      $event1->date_end     = $faker->dateTimeBetween( '+91 days', '+180 days' );
      $event1->game_enabled = $faker->boolean();
      $event1->save();

      $event2 = EventInstance::find( $event1->id );
      $this->assertEquals( $event1->id, $event2->id );
      $this->assertEquals( $event1->event_uuid, $event2->event_uuid );
      $this->assertEquals( $event1->active, $event2->active );
      $this->assertEquals( $event1->name, $event2->name );
      $this->assertEquals( $event1->display_name, $event2->display_name );
      $this->assertEquals( $event1->timezone, $event2->timezone );
      $this->assertEquals( $event1->game_enabled, $event2->game_enabled );

    }

  }

  /****************************************************************************/

}
