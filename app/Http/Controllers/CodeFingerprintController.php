<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\TraitEventInstanceController;
use App\CodeFingerprint;

class CodeFingerprintController extends Controller
{

  /****************************************************************************/
  
  use TraitEventInstanceController;
  
  /****************************************************************************/

  /**
   * Show the code fingerprint settings page.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = CodeFingerprintController::GetEventInstanceByName( $event_instance_name );
    $fingerprints   = CodeFingerprint::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->get();

    if( ! isset( $fingerprints ) )
    {
      $this->Poke( $event_instance_name, 'touch-screen' );
      $this->Poke( $event_instance_name, 'social-wall' );
      $fingerprints = CodeFingerprint::get();
    }

    return(
      view( 'code-fingerprint.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'fingerprints'        => $fingerprints
        ]
      )
    );

  }

  /****************************************************************************/

  /**
  * Get current code fingerprint.
  *
  * @return \Illuminate\Http\Response
  */
  public function Current ( Request $request, $event_instance_name, $screen_type )
  {

    $event_instance = CodeFingerprintController::GetEventInstanceByName( $event_instance_name );
    $fingerprint    = CodeFingerprint::GetCurrentFingerprint( $event_instance, $screen_type );
    $current        = 1;

    if( isset( $fingerprint ) )
    {
      $current = $fingerprint->id;
    }

    return(
      response()
      ->json( $current )
    );

  }

  /****************************************************************************/

  public function Poke ( Request $request, $event_instance_name, $screen_type )
  {

    $event_instance = CodeFingerprintController::GetEventInstanceByName( $event_instance_name );

    $this->_Poke( $event_instance_name, $screen_type );

    $fingerprints = CodeFingerprint::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->get();

    return(
      view( 'code-fingerprint.index' )
      ->with(
        [
          'flash_success' => 'Code fingerprint updated, all screens will reload.',
          'event_instance_name' => $event_instance_name,
          'fingerprints'        => $fingerprints
        ]
      )
    );

  }

  /****************************************************************************/

  /**
  * Increment code fingerprint.
  *
  * @return \Illuminate\Http\Response
  */
  public function ApiPoke ( Request $request, $event_instance_name, $screen_type )
  {

    $fingerprint = $this->_Poke( $event_instance_name, $screen_type );

    return( response()->json( $fingerprint ) );

  }

  /****************************************************************************/

  /**
  * Increment code fingerprint.
  *
  * @return CodeFingerprint
  */
  private function _Poke ( $event_instance_name, $screen_type )
  {

    $event_instance                 = CodeFingerprintController::GetEventInstanceByName( $event_instance_name );
    $fingerprint                    = new CodeFingerprint();
    $fingerprint->event_instance_id = $event_instance->id;
    $fingerprint->screen_type       = $screen_type;
    $fingerprint->save();

    $poketron = CodeFingerprint::
    where( 'event_instance_id', '=', $fingerprint->event_instance_id )
    ->where(
      function ( $query ) use ( $fingerprint )
      {
        $query
        ->where( 'screen_type', '=', $fingerprint->screen_type )
        ->where( 'id', '<>', $fingerprint->id );
      }
    )
    ->delete();

    return( $fingerprint );

  }

  /****************************************************************************/

}
