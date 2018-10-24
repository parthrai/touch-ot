<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use App\EventInstance;
use App\EventRulesSessionTypeVisibility;

class CreateManyEventRulesSessionTypeVisibilitiesTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many EventRulesSessionTypeVisibility.
  *
  * @return void
  */
  public function testCreateManyEventRulesSessionTypeVisibilities ()
  {

    $faker          = Faker::create();
    $max            = 100;
    $event_instance = EventInstance::GetDefaultInstance();

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $session_type1                    = new EventRulesSessionTypeVisibility();
      $session_type1->event_instance_id = $event_instance->id;
      $session_type1->event_rule_uuid   = $faker->uuid();
      $session_type1->name              = $faker->text( 255 );
      $session_type1->enabled           = $faker->boolean();
      $session_type1->save();

      $session_type2 = EventRulesSessionTypeVisibility::find( $session_type1->id );

      $this->assertEquals( $session_type1->id, $session_type2->id );
      $this->assertEquals( $session_type1->event_instance_id, $session_type2->event_instance_id );
      $this->assertEquals( $session_type1->event_rule_uuid, $session_type2->event_rule_uuid );
      $this->assertEquals( $session_type1->name, $session_type2->name );
      $this->assertEquals( $session_type1->enabled, $session_type2->enabled );

    }

  }

  /****************************************************************************/

}
