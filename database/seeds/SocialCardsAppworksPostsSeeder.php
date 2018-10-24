<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\SocialCardPost;

class SocialCardsAppworksPostsSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $faker = Faker::create();
    $max   = 100;

    for( $i = 0 ; $i <= $max ; $i++ )
    {

      $card                    = new SocialCardPost();

      $card->card_created_at  = $faker->dateTimeBetween( '-7 days', 'now', null );
      $card->post_id           = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $card->post_text         = $faker->text( 255 );
      $card->lang             = $faker->languageCode();
      $card->first_name        = $faker->firstName();
      $card->last_name         = $faker->lastName();
      $card->title             = $faker->jobTitle();
      $card->company           = $faker->company();
      $card->profile_photo     = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      $card->appworks_event_id = $faker->unique()->numerify( str_repeat( '#', $faker->numberBetween( 8, 255 ) ) );
      $card->game_team_uuid    = $faker->uuid();

      if( $faker->boolean() )
      {
        $card->image = $faker->url() . '.' . $faker->randomElement( [ 'jpg', 'gif', 'png' ] );
      }

      $card->save();

      $card->SetApproved( $faker->boolean() );

      $card->SetFeatured( $faker->boolean() );

    }

  }

  /****************************************************************************/

}
