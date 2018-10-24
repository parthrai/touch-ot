<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use Tests\Unit\SocialCardsTweetsBase;
use App\EventInstance;
use App\SocialCardTweet;

class CreateManyTweetsTest extends SocialCardsTweetsBase
{

  /****************************************************************************/

  /**
  * Test creating many SocialCardTweets.
  *
  * @return void
  */
  public function testCreateManyTweets ()
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
      $this->assertEquals( $tweet1->card_created_at, $tweet2->card_created_at );
      $this->assertEquals( $tweet1->tweet_id, $tweet2->tweet_id );
      $this->assertEquals( $tweet1->tweet_text, $tweet2->tweet_text );
      $this->assertEquals( $tweet1->lang, $tweet2->lang );
      $this->assertEquals( $tweet1->user_name, $tweet2->user_name );
      $this->assertEquals( $tweet1->user_screen_name, $tweet2->user_screen_name );
      $this->assertEquals( $tweet1->user_location, $tweet2->user_location );
      $this->assertEquals( $tweet1->user_url, $tweet2->user_url );
      $this->assertEquals( $tweet1->user_image, $tweet2->user_image );
      $this->assertEquals( $tweet1->image, $tweet2->image );
      
    }

  }

  /****************************************************************************/

}
