<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\EventInstance;
use App\SocialCardTweet;

class SocialCardsTweetsSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $faker    = Faker::create();
    $max      = 1000;
    $event_id = EventInstance::GetDefaultInstance()->id;

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $card                    = new SocialCardTweet();
      $card->event_instance_id = $event_id;
      $card->card_created_at   = $faker->dateTimeBetween( '-7 days', 'now', null );
      $card->tweet_id          = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $card->tweet_text        = $faker->text( 255 );
      $card->lang              = $faker->languageCode();
      $card->user_name         = $faker->userName();
      $card->user_screen_name  = $faker->firstName() . ' ' . $faker->lastName();
      $card->user_location     = $faker->city();
      $card->user_url          = $faker->url();
      $card->user_image        = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );

      if( $faker->boolean() )
      {
        $card->image = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      }

      $card->save();

      $card->SetApproved( $faker->boolean() );

      $card->SetFeatured( $faker->boolean() );

      $hashtags = [];
      for( $j = 1 ; $j <= rand(1,10) ; $j++ )
      {
        array_push( $hashtags, '#' . $faker->word() );
      }
      $card->AddHashtags( $hashtags );

    }

  }

  /****************************************************************************/

}
