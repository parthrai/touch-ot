<?php

namespace App\Fetchers;

use Exception;
use DateTime;
use Twitter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

use App\EventInstance;

use App\SocialCardConfig;
use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\SocialCardTweet;
use App\SocialCardPost;

use App\ScoreboardTeamConfig;
use App\TwitterHashtagConfig;

class SocialCardsTweetsFetch
{

  /****************************************************************************/

  private $show_output = false;

  /****************************************************************************/

  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct ( Bool $show_output = false )
  {
    $this->show_output = $show_output;
  }

  /****************************************************************************/

  /**
   * Fetch Tweets.
   *
   * @return void
   */
  public function FetchTweets ()
  {
  
    $event_instances = EventInstance::where( 'name', '!=', 'default' )->get();

    foreach( $event_instances as $event_instance )
    {
      if( $this->show_output ) echo( "FetchTweets: " . $event_instance->name ."\n" );
      $this->ProcessTweets( $event_instance );
    }

  }

  /****************************************************************************/

  /**
   * Process the Tweets.
   *
   * @return Bool
   */
  public function ProcessTweets ( $event_instance )
  {

    $dirty           = false;
    $hashtag_configs = TwitterHashtagConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'enabled', '=', 1 ]
      ]
    )
    ->get();

    if( count( $hashtag_configs ) == 0 )
    {
      if( $this->show_output ) echo( "ERROR: NO TWITTER HASHTAGS FOUND!\n" );
      return( true );
    }

    if( $this->show_output ) echo( "FETCHING TWEETS:\n" );

    foreach( $hashtag_configs as $hashtag_config )
    {

      $query_hashtag = strtolower( $hashtag_config->hashtag );

      if( $this->show_output ) echo( "\tQUERY_HASHTAG: " . $query_hashtag . "\n" );

      $team_hashtags = ScoreboardTeamConfig::GetHashtags( $event_instance->name );

      $since_id      = SocialCardTweet::where(
        'event_instance_id', '=', $event_instance->id
      )
      ->orderBy( 'card_created_at', 'desc' )
      ->pluck( 'tweet_id' )
      ->first();

      if( ! isset( $since_id ) )
      {
        $since_id = 0;
      }

      if( $this->QueryTweets( $event_instance, '#' . $query_hashtag, $since_id ) )
      {
        $dirty = true;
      }

      foreach( $team_hashtags as $team_name => $team_hashtag )
      {

        $query = join(
          ' ',
          [
            '#' . $query_hashtag,
            '#' . strtolower( $team_hashtag )
          ]
        );

        if( $this->show_output ) echo( "\tTEAM_HASHTAG: " . $team_hashtag . "\n" );

        if( $this->QueryTweets( $event_instance, $query, $since_id ) )
        {
          $dirty = true;
        }
  
      }

    }

    return( $dirty );

  }

  /****************************************************************************/

  /**
   * Query for tweets.
   *
   * @return Bool
   */
  private function QueryTweets ( $event_instance, $query, $since_id )
  {

    
    $social_cards_config = SocialCardConfig::GetConfiguration( $event_instance->name );
    $dirty               = false;
    $items               = null;

    if( $this->show_output ) echo( "\t\tQUERY: " . $query . "\n" );

    try
    {
      // TODO: This probably needs pagination if more than n tweets:
      $json = Twitter::getSearch(
        [
          'q'          => $query,
          'count'      => $social_cards_config->fetch_batchsize_tweets,
          'since_id'   => $since_id,
          'format'     => 'json',
          'tweet_mode' => 'extended'
        ]
      );
      
      $items = json_decode( $json );

    }
    catch( Exception $ex )
    {
      if( $this->show_output ) echo( $ex->getMessage() . "\n" );
    }

    if( ! isset( $items ) )
    {
      return;
    }

    foreach( $items->statuses as $status )
    {

      $hashtags  = array();
      $text      = null;
      $image_url = null;

      if( $this->show_output ) echo( "\t\t\tTWEET: " . $status->id_str . "\n" );

      if( isset( $status->retweeted_status ) )
      {
        if( $this->show_output ) echo( "\t\t\t\tRETWEETED\n" );
        continue;
      }

      if( isset( $status->full_text ) )
      {
        $text = $status->full_text;
      }
      else if( isset( $status->text ) )
      {
        $text = $status->text;
      }
      else
      {
        $text = '';
      }

      foreach( $status->entities->hashtags as $hashtag )
      {
        $hashtag_text = str_replace( '#', '', $hashtag->text );
        if( $this->show_output ) echo( "\t\t\t\t" . $hashtag_text . "\n" );
        array_push( $hashtags, $hashtag_text );
      }

      try
      {
        if( isset( $status->entities ) )
        {
          if( isset( $status->entities->media ) )
          {
            foreach( $status->entities->media as $media )
            {
              if( isset( $media->media_url_https ) )
              {
                $image_url = $media->media_url_https;
                break;
              }
              else if( isset( $media->media_url ) )
              {
                $image_url = $media->media_url;
                break;
              }
            }
          }

        }
        if( $this->show_output ) echo( "\t\t\tIMAGE: " . $image_url . "\n" );
      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }

      $parsed_date = new DateTime( $status->created_at );

      $tweet = SocialCardTweet::where(
        [
          [ 'event_instance_id', '=', $event_instance->id ],
          [ 'tweet_id', '=', $status->id_str ]
        ]
      )
      ->first();

      if( ! isset( $tweet ) )
      {

        try
        {

          $tweet                    = new SocialCardTweet();
          $tweet->event_instance_id = $event_instance->id;
          $tweet->card_created_at   = $parsed_date->format( 'Y-m-d H:i:s' );
          $tweet->tweet_id          = $status->id_str;
          $tweet->tweet_text        = $text;
          $tweet->lang              = $status->metadata->iso_language_code;
          $tweet->user_name         = $status->user->name;
          $tweet->user_screen_name  = $status->user->screen_name;
          $tweet->user_location     = $status->user->location;
          $tweet->user_url          = $status->user->url;
          $tweet->user_image        = $status->user->profile_image_url_https;
          $tweet->image             = $image_url;
          $tweet->save();
      
          $tweet->SetApproved( false );
          $tweet->SetFeatured( false );

          $tweet->AddHashtags( $hashtags );

          $dirty = true;

        }
        catch( Exception $ex )
        {
          if( $this->show_output ) echo( $ex->getMessage() . "\n" );
        }

      }

    }

    return( $dirty );

  }

  /****************************************************************************/

}
