<?php

namespace App\Fetchers;

use Exception;
use DateTime;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

use App\EventInstance;

use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\SocialCardTweet;
use App\SocialCardPost;
use App\ScoreboardTeam;

class SocialCardsAppWorksPostsFetch
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
   * Fetch posts from AppWorks.
   *
   * @return void
   */
  public function FetchPosts ()
  {

    $event_instances = EventInstance::where( 'name', '!=', 'default' )->get();

    foreach( $event_instances as $event_instance )
    {
      if( $this->show_output ) echo( "FetchPosts: " . $event_instance->name ."\n" );
      $this->ProcessPosts( $event_instance );
    }

  }

  /****************************************************************************/

  /**
   * Process the posts.
   *
   * @return Bool
   */
  public function ProcessPosts ( $event_instance )
  {

    $dirty = false;
    $http  = new Client();
    $items = null;

    if( $this->show_output ) echo( "FETCHING POSTS:\n" );

    try
    {

      $response = $http->request(
        'GET',
        'http://appworks.opentext.com/appworks-conference-service/api/v2/feed/latest',
        [
          'verify'      => false,
          'http_errors' => false,
          'headers'     => [
            'Content-Type'       => 'application/json',
            'Accept'             => 'application/json',
            'x-ew-app-key'       => getenv('AW_APP_KEY'),
            'AW_EVENTS_EVENT_ID' => $event_instance->event_uuid
          ]
        ]
      );

      $items = json_decode( (string) $response->getBody(), false );

    }
    catch( Exception $ex )
    {
      $items = null;
    }

    foreach( $items->posts as $appworks_post )
    {

      if( $this->show_output ) echo( "POST: " . $appworks_post->id->dataId . "\n" );

      try
      {

        $post          = null;
        $profile_photo = null;
        $image         = null;

        try
        {
          $profile_photo = "http://appworks.opentext.com" . $appworks_post->attendee->profilePhoto->publicUrl;
        }
        catch( Exception $ex )
        {
          $profile_photo = null;
        }

        try
        {
          $image = "http://appworks.opentext.com" . $appworks_post->photo->publicUrl;
        }
        catch( Exception $ex )
        {
          $image = null;
        }

        try
        {
          $post = SocialCardPost::where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'post_id', '=', $appworks_post->id->dataId ]
            ]
          )->first();
        }
        catch( Exception $ex )
        {
        }

        if( ! isset( $post ) )
        {

          $post                    = new SocialCardPost();
          $post->event_instance_id = $event_instance->id;
          $post->card_created_at   = gmdate( "Y-m-d H:i:s", ( $appworks_post->created / 1000 ) );
          $post->post_id           = $appworks_post->id->dataId;
          $post->post_text         = $appworks_post->content;

          $post->lang              = strtolower( $appworks_post->id->langCode );

          $post->first_name        = $appworks_post->attendee->firstName;
          $post->last_name         = $appworks_post->attendee->lastName;
          $post->title             = $appworks_post->attendee->title;
          $post->company           = $appworks_post->attendee->company;
          $post->profile_photo     = $profile_photo;
          $post->appworks_event_id = $appworks_post->attendee->eventId;
          $post->game_team_uuid    = $appworks_post->attendee->gameTeamUuid;
          $post->image             = $image;

          $post->save();
      
          $post->SetApproved( true );
          $post->SetFeatured( false );

          $hashtags = array();

          foreach( $appworks_post->tags as $hashtag )
          {
            if( $this->show_output ) echo( "\t" . $hashtag . "\n" );
            array_push( $hashtags, $hashtag );
          }
          
          $post->AddHashtags( $hashtags );

          $dirty = true;

        }

      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }
    
    }

    return( $dirty );

  }

  /****************************************************************************/

}
