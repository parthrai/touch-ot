<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use App\EventInstance;
use App\Leaderboard;

class CreateManyLeaderboardEntriesTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
  * Test creating many Leaderboards.
  *
  * @return void
  */
  public function testCreateManyLeaderboardEntries ()
  {

    $faker          = Faker::create();
    $max            = 1000;
    $event_instance = EventInstance::GetDefaultInstance();

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $entry1                    = new Leaderboard();
      $entry1->event_instance_id = $event_instance->id;
      $entry1->name              = $faker->text( 255 );
      $entry1->image_xs          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 128 ) ) ) . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $entry1->image_sm          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 128 ) ) ) . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $entry1->image_md          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 128 ) ) ) . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $entry1->image_lg          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 128 ) ) ) . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $entry1->display_order     = $faker->numberBetween( 1, $max );
      $entry1->save();

      $entry2 = Leaderboard::find( $entry1->id );

      $this->assertEquals( $entry1->id, $entry2->id );
      $this->assertEquals( $entry1->event_instance_id, $entry2->event_instance_id );

      $this->assertEquals( $entry1->name, $entry2->name );

      $this->assertNotNull( $entry2->image_xs );
      $this->assertNotNull( $entry2->image_sm );
      $this->assertNotNull( $entry2->image_md );
      $this->assertNotNull( $entry2->image_lg );

      $this->assertEquals( $entry1->image_xs, $entry2->image_xs );
      $this->assertEquals( $entry1->image_sm, $entry2->image_sm );
      $this->assertEquals( $entry1->image_md, $entry2->image_md );
      $this->assertEquals( $entry1->image_lg, $entry2->image_lg );

      $this->assertEquals( $entry1->display_order, $entry2->display_order );

    }

  }

  /****************************************************************************/

}
