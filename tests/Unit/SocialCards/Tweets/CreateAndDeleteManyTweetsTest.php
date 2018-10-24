<?php

namespace Tests\Unit;

use Faker\Factory as Faker;

use Tests\Unit\SocialCardsTweetsBase;
use App\EventInstance;
use App\SocialCardHashtagLookup;
use App\SocialCardLookup;
use App\SocialCardTweet;

class CreateAndDeleteManyTweetsTest extends SocialCardsTweetsBase
{

  /****************************************************************************/

  /**
  * Test creating a tweet and then immediately deleting it.
  *
  * @return void
  */
  public function testCreateAndDeleteManyTweets ()
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

      $hashtags = [];

      for( $j = 1 ; $j <= 5 ; $j++ )
      {
        array_push( $hashtags,  '#' . $faker->word() );
      }

      $tweet1->AddHashtags( $hashtags );

      $tweet2 = SocialCardTweet::find( $tweet1->id );

      $result = $tweet2->delete();

      $this->assertTrue( $result );

      $tweet3 = SocialCardTweet::find( $tweet1->id );

      $this->assertNull( $tweet3 );

      $this->assertEquals( SocialCardHashtagLookup::count(), 0 );
      $this->assertEquals( SocialCardLookup::count(), 0 );

    }
    
  }

  /****************************************************************************/

}
