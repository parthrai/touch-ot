<?php

namespace App\Fetchers;

use Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

class AppWorksApiBase
{

  /** ENVIRONMENT VARIABLES USED **********************************************/
  /*
    APPWORKS_API_USERNAME=
    APPWORKS_API_PASSWORD=
  */

  /****************************************************************************/

  protected $show_output = false;

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
   * Log in to API.
   *
   * @return String $otag_token
   */
  public function Login ()
  {

    $http       = new Client();
    $package    = null;
    $otag_token = null;

    try
    {

      $response = $http->request(
        'POST',
        'https://appworks.opentext.com/v3/admin/auth',
        [
          'json' => [
            "userName" => getenv( 'APPWORKS_API_USERNAME' ),
            "password" => getenv( 'APPWORKS_API_PASSWORD' ),
            "runtime" => "event-kiosk",
            "clientData" => [
              "clientInfo" => [
                "type"    => "web",
                "app"     => "event-kiosk",
                "runtime" => "event-kiosk",
                "version" => "1.0",
                "os"      => "Android"
              ]
            ]
          ]
        ]
      );

      $package = json_decode( (string) $response->getBody(), false );

    }
    catch( Exception $ex )
    {
      $package = null;
    }

    if( isset( $package ) )
    {
      $otag_token = $package->otagtoken;
    }

    return( $otag_token );

  }

  /****************************************************************************/

}
