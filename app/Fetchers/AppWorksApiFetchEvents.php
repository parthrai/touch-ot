<?php

namespace App\Fetchers;

use Exception;
use DateTime;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

use App\Fetchers\AppWorksApiBase;
use App\EventInstance;

class AppWorksApiFetchEvents extends AppWorksApiBase
{

  /****************************************************************************/

  /**
   * Download the feed package.
   *
   * @return JSON
   */
  public function FetchPackage ( String $otag_token )
  {

    $http    = new Client();
    $package = null;
    $default = EventInstance::GetDefaultInstance(); // Trigger creation of default event instance if missing

    try
    {

      $response = $http->request(
        'GET',
        'https://appworks.opentext.com/appworks-conference-service/api/v2/events',
        [
          'verify'      => false,
          'http_errors' => false,
          'headers'     => [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
            'otagToken'    =>  $otag_token
          ],
        ]
      );

      $package = json_decode( (string) $response->getBody(), false );

    }
    catch( Exception $ex )
    {
      $package = null;
    }

    return( $package );

  }

  /****************************************************************************/

  /**
   * Process the Event feed.
   *
   * @return Bool
   */
  public function ProcessEvents ( &$package )
  {
    if( isset( $package ) )
    {

      foreach( $package as $event )
      {

        $event_uuid = $event->uuid;

        if( isset( $event_uuid ) )
        {

          if( $this->show_output ) echo( $event_uuid . "\n" );
          if( $this->show_output ) echo( "\t" . $event->name . "\n" );
          if( $this->show_output ) echo( "\t" . $event->active . "\n" );

          $event_instance               = EventInstance::firstOrNew( [ 'event_uuid' => $event_uuid ] );
          $event_instance->active       = true; //$event->active;
          $event_instance->name         = $event->name;
          $event_instance->display_name = $event->name;
          $event_instance->timezone     = $event->timeZone;
          $event_instance->date_start   = gmdate( "Y-m-d", ( $event->startDate / 1000 ) );
          $event_instance->date_end     = gmdate( "Y-m-d", ( $event->endDate / 1000 ) );
          $event_instance->game_enabled = $event->gamificationEnabled;

          $event_instance->save();

        }

      }

    }
    return( true );
  }

  /****************************************************************************/

}
