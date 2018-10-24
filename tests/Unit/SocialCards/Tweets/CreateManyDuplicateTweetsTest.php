<?php

namespace Tests\Unit;

use Exception;

use Faker\Factory as Faker;

use Illuminate\Database\QueryException;

use Tests\Unit\SocialCardsTweetsBase;
use App\EventInstance;
use App\SocialCardTweet;

class CreateManyDuplicateTweetsTest extends SocialCardsTweetsBase
{

  /****************************************************************************/

  /**
  * Test creating many SocialCardTweets.
  *
  * @return void
  */
  public function testCreateManyDuplicateTweets ()
  {

    $faker    = Faker::create();
    $max      = 100;
    $event_id = EventInstance::GetDefaultInstance()->id;

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $tweet1                    = new SocialCardTweet();
      $tweet1->event_instance_id = $event_id;
      $tweet1->card_created_at   = $faker->date( 'Y-m-d' ) . ' ' . $faker->time( 'H:i:s' );
      $tweet1->tweet_id          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $tweet1->tweet_text        = $faker->text( 255 );
      $tweet1->lang              = $faker->languageCode();
      $tweet1->user_name         = $faker->userName();
      $tweet1->user_screen_name  = $faker->firstName() . ' ' . $faker->lastName();
      $tweet1->user_location     = $faker->city();
      $tweet1->user_url          = $faker->url();
      $tweet1->user_image        = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );

      if( $faker->boolean() )
      {
        $tweet1->image = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      }

      $tweet1->save();

      $tweet2 = SocialCardTweet::find( $tweet1->id );

      $this->assertEquals( $tweet1->id, $tweet2->id );

    }

    $tweets = SocialCardTweet::inRandomOrder()->limit( $max )->get();

    foreach( $tweets as $tweet3 )
    {

      $result = null;

      try
      {

        $tweet4                    = new SocialCardTweet();
        $tweet4->event_instance_id = $tweet3->event_instance_id;
        $tweet4->card_created_at   = $tweet3->card_created_at;
        $tweet4->tweet_id          = $tweet3->tweet_id;
        $tweet4->tweet_text        = $tweet3->tweet_text;
        $tweet4->lang              = $tweet3->lang;
        $tweet4->user_name         = $tweet3->user_name;
        $tweet4->user_screen_name  = $tweet3->user_screen_name;
        $tweet4->user_location     = $tweet3->user_location;
        $tweet4->user_url          = $tweet3->user_url;
        $tweet4->user_image        = $tweet3->user_image;
        $tweet4->image             = $tweet3->image;
        $tweet4->save();

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
