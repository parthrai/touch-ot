<?php

namespace Tests\Unit;

use Exception;

use Faker\Factory as Faker;

use Illuminate\Database\QueryException;

use App\EventInstance;
use App\EventRulesSurveySessionType;

class CreateManyDuplicateEventRulesSurveySessionTypesTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many duplicate EventRulesSurveySessionTypes.
  *
  * @return void
  */
  public function testCreateManyDuplicateEventRulesSurveySessionTypes ()
  {

    $faker          = Faker::create();
    $max            = 100;
    $event_instance = EventInstance::GetDefaultInstance();

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $session_type1                    = new EventRulesSurveySessionType();
      $session_type1->event_instance_id = $event_instance->id;
      $session_type1->event_rule_uuid   = $faker->uuid();
      $session_type1->name              = $faker->text( 255 );
      $session_type1->enabled           = $faker->boolean();
      $session_type1->save();

      $session_type2 = EventRulesSurveySessionType::find( $session_type1->id );

      $this->assertEquals( $session_type1->id, $session_type2->id );
      $this->assertEquals( $session_type1->event_instance_id, $session_type2->event_instance_id );
      $this->assertEquals( $session_type1->event_rule_uuid, $session_type2->event_rule_uuid );
      $this->assertEquals( $session_type1->name, $session_type2->name );
      $this->assertEquals( $session_type1->enabled, $session_type2->enabled );

    }

    $entries = EventRulesSurveySessionType::inRandomOrder()->limit( $max )->get();

    foreach( $entries as $session_type3 )
    {

      $result = null;

      try
      {

        $session_type4                    = new EventRulesSurveySessionType();
        $session_type4->event_instance_id = $session_type3->event_instance_id;
        $session_type4->event_rule_uuid   = $session_type3->event_rule_uuid;
        $session_type4->name              = $session_type3->name;
        $session_type4->enabled           = $session_type3->enabled;
        $session_type4->save();
  
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
