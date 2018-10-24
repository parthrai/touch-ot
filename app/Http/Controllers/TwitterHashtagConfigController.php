<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;
use App\TwitterHashtagConfig;

class TwitterHashtagConfigController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TwitterHashtagConfigController::GetEventInstanceByName( $event_instance_name );
    $configs        = TwitterHashtagConfig::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'hashtag' )
    ->get();

    return(
      view( 'twitter-configs.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'configs'             => $configs
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance            = TwitterHashtagConfigController::GetEventInstanceByName( $event_instance_name );
    $config                    = new TwitterHashtagConfig();
    $config->event_instance_id = $event_instance->id;
    $config->hashtag           = $request->input( 'hashtag' );
    $config->enabled           = true;
    $config->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'New hashtag added',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function enable ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TwitterHashtagConfigController::GetEventInstanceByName( $event_instance_name );
    $config         = TwitterHashtagConfig::where(
    [
      [ 'event_instance_id', '=', $event_instance->id ],
      [ 'id', '=', $id ]
    ]
    )
    ->first();

    if( isset( $config ) )
    {

      $config->enabled = true;
      $config->save();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Hashtag enabled',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error'         => 'Hashtag not found',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function disable ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TwitterHashtagConfigController::GetEventInstanceByName( $event_instance_name );
    $config         = TwitterHashtagConfig::where(
    [
      [ 'event_instance_id', '=', $event_instance->id ],
      [ 'id', '=', $id ]
    ]
    )
    ->first();

    if( isset( $config ) )
    {

      $config->enabled = false;
      $config->save();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Hashtag disabled',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error'         => 'Hashtag not found',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TwitterHashtagConfigController::GetEventInstanceByName( $event_instance_name );
    $config         = TwitterHashtagConfig::where(
    [
      [ 'event_instance_id', '=', $event_instance->id ],
      [ 'id', '=', $id ]
    ]
    )
    ->first();

    if( isset( $config ) )
    {

      $config->delete();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Hashtag Deleted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error'         => 'Hashtag not found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
