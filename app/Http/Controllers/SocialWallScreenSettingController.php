<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceController;

use App\EventInstance;
use App\SocialWallScreenSetting;

class SocialWallScreenSettingController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
   * Show the screen settings page.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request, $event_instance_name )
  {
    
    $event_instance  = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $screen_settings = SocialWallScreenSetting::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'id', 'ASC' )
    ->get();

    return(
      view( 'screen-settings.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'settings'            => $screen_settings
        ]
      )
    );

  }

  /****************************************************************************/

  public function Enable ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $setting        = SocialWallScreenSetting::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $setting->status = true;
    $setting->save();

    return(
      back()
      ->with(
        [ 'flash_success' => 'Screen ' . $setting->screen . ' enabled' ]
      )
    );

  }

  /****************************************************************************/

  public function EnableAll ( Request $request, $event_instance_name )
  {

    $event_instance  = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $screen_settings = SocialWallScreenSetting::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->get();
    
    foreach( $screen_settings as $setting )
    {
      switch( $setting->screen )
      {
        case "countdown":
          break;
        case "announcement":
          break;
        default:
          $setting->status = true;
          break;
      }
      $setting->save();
    }
  
    return(
      back()
      ->with(
        [ 'flash_success' => 'All screens enabled' ]
      )
    );

  }

  /****************************************************************************/

  public function Disable ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $setting        = SocialWallScreenSetting::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $setting->status = false;
    $setting->save();

    return(
      back()
      ->with(
        [ 'flash_success' => 'Screen ' . $setting->screen . ' disabled' ]
      )
    );

  }

  /****************************************************************************/

  public function DisableAll ( Request $request, $event_instance_name )
  {

    $event_instance  = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $screen_settings = SocialWallScreenSetting::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->get();
    
    foreach( $screen_settings as $setting )
    {
      $setting->status = false;
      $setting->save();
    }
  
    return(
      back()
      ->with(
        [ 'flash_success' => 'All screens disabled' ]
      )
    );

  }

  /****************************************************************************/

  public function SetDuration ( Request $request, $event_instance_name, $id )
  {

    $duration       = $request->input( 'duration' );
    $event_instance = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $setting        = SocialWallScreenSetting::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $setting->duration = $duration;
    $setting->save();

    return(
      back()
      ->with(
        [ 'flash_success' => 'Screen ' . $setting->screen . ' duration set to ' . $setting->duration ]
      )
    );

  }

  /****************************************************************************/

  public function ResetToDefaults ( Request $request, $event_instance_name )
  {

    SocialWallScreenSetting::ResetToDefaults( $event_instance_name );

    return(
      redirect( route( 'screens', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success' => 'The screens have been reset to default settings.'
        ]
      )
    );

  }

  /****************************************************************************/

}
