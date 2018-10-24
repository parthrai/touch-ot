<?php

namespace Tests\Unit;

use Exception;

use Faker\Factory as Faker;

use Illuminate\Database\QueryException;

use Tests\Unit\SocialCardsPostsBase;

use App\EventInstance;
use App\SocialCardPost;

class CreateManyDuplicatePostsTest extends SocialCardsPostsBase
{

  /****************************************************************************/

  /**
  * Test creating many duplicate SocialCardPosts.
  *
  * @return void
  */
  public function testCreateManyDuplicatePosts ()
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

    }

    $posts = SocialCardPost::inRandomOrder()->limit( $max )->get();

    foreach( $posts as $post3 )
    {

      $result = null;

      try
      {

        $post4                    = new SocialCardPost();
        $post4->event_instance_id = $post3->event_instance_id;
        $post4->card_created_at   = $post3->card_created_at;
        $post4->post_id           = $post3->post_id;
        $post4->post_text         = $post3->post_text;
        $post4->lang              = $post3->lang;
        $post4->first_name        = $post3->first_name;
        $post4->last_name         = $post3->last_name;
        $post4->title             = $post3->title;
        $post4->company           = $post3->company;
        $post4->profile_photo     = $post3->profile_photo;
        $post4->appworks_event_id = $post3->appworks_event_id;
        $post4->game_team_uuid    = $post3->game_team_uuid;
        $post4->image             = $post3->image;
        $post4->save();

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
