<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use Tests\Unit\SocialCardsPostsBase;
use App\EventInstance;
use App\SocialCardPost;

class CreateManyPostsTest extends SocialCardsPostsBase
{

  /****************************************************************************/

  /**
  * Test creating many SocialCardPosts.
  *
  * @return void
  * @test
  */
  public function testCreateManyPosts ()
  {

    $faker    = Faker::create();
    $max      = 100;
    $event_id = EventInstance::GetDefaultInstance()->id;

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $post1                    = new SocialCardPost();
      $post1->event_instance_id = $event_id;
      $post1->card_created_at   = $faker->date( 'Y-m-d' ) . ' ' . $faker->time( 'H:i:s' );
      $post1->post_id           = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $post1->post_text         = $faker->text( 255 );
      $post1->lang              = $faker->languageCode();
      $post1->first_name        = $faker->firstName();
      $post1->last_name         = $faker->lastName();
      $post1->title             = $faker->jobTitle();
      $post1->company           = $faker->company();
      $post1->profile_photo     = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $post1->appworks_event_id = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $post1->game_team_uuid    = $faker->uuid();

      if( $faker->boolean() )
      {
        $post1->image = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      }

      $post1->save();

      $post2 = SocialCardPost::find( $post1->id );

      $this->assertEquals( $post1->id, $post2->id );
      $this->assertEquals( $post1->card_created_at, $post2->card_created_at );
      $this->assertEquals( $post1->post_id, $post2->post_id );
      $this->assertEquals( $post1->post_text, $post2->post_text );
      $this->assertEquals( $post1->lang, $post2->lang );
      $this->assertEquals( $post1->first_name, $post2->first_name );
      $this->assertEquals( $post1->last_name, $post2->last_name );
      $this->assertEquals( $post1->title, $post2->title );
      $this->assertEquals( $post1->company, $post2->company );
      $this->assertEquals( $post1->profile_photo, $post2->profile_photo );
      $this->assertEquals( $post1->appworks_event_id, $post2->appworks_event_id );
      $this->assertEquals( $post1->game_team_uuid, $post2->game_team_uuid );
      $this->assertEquals( $post1->image, $post2->image );

    }

  }

  /****************************************************************************/

}
