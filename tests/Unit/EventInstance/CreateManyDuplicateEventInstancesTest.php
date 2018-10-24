<?php

namespace Tests\Unit;

use Exception;

use Faker\Factory as Faker;

use Illuminate\Database\QueryException;

use App\EventInstance;

class CreateManyDuplicateEventInstancesTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many duplicate Event Instances.
  *
  * @return void
  */
  public function testCreateManyDuplicateEventInstances ()
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

    $entries = EventInstance::inRandomOrder()->limit( $max )->get();

    foreach( $entries as $event3 )
    {

      $result = null;

      try
      {

        $event4               = new EventInstance();
        $event4->event_uuid   = $event3->event_uuid;
        $event4->active       = $event3->active;
        $event4->name         = $event3->name;
        $event4->display_name = $event3->display_name;
        $event4->timezone     = $event3->timezone;
        $event4->date_start   = $event3->date_start;
        $event4->date_end     = $event3->date_end;
        $event4->game_enabled = $event3->game_enabled;
        $event4->save();
  
        $result = true;

        $this->fail( 'Expected QueryException' );

      }
      catch( Exception $ex )
      {
        $this->assertEquals( get_class( $ex ), QueryException::class );
      }

      $this->assertNull( $result );

    }

  }

  /****************************************************************************/

}
