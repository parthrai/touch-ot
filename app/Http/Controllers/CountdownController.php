<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceController;

use App\Countdown;

class CountdownController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
   * Show the final countdown settings page.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request, $event_instance_name )
  {
    
    $event_instance = CountdownController::GetEventInstanceByName( $event_instance_name );
    $countdown      = Countdown::GetDefaultCountdown( $event_instance_name );

    if( isset( $countdown ) )
    {
      $datetime = new Carbon( join( ' ', [ $countdown->target_date, $countdown->target_time ] ) );
      $countdown->target_date = $datetime->toDateString();
      $countdown->target_time = $datetime->format('h:i');
    }
    else
    {
      $datetime               = Carbon::now(1);
      $countdown              = new Countdown();
      $countdown->target_date = $datetime->toDateString();
      $countdown->target_time = $datetime->format('h:i');
      $countdown->title       = 'The Final Countdown';
      $countdown->save();
    }

    return(
      view( 'countdown.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'countdown'           => $countdown
        ]
      )
    );

  }

  /****************************************************************************/

  public function Enable ( Request $request, $event_instance_name, $id )
  {

    $countdown          = Countdown::GetDefaultCountdown( $event_instance_name );
    $countdown->enabled = true;
    $countdown->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Final Countdown ' . $countdown->id . ' enabled',
          'event_instance_name' => $event_instance_name,
        ]
      )
    );

  }

  /****************************************************************************/

  public function Disable ( Request $request, $event_instance_name, $id )
  {

    $countdown          = Countdown::GetDefaultCountdown( $event_instance_name );
    $countdown->enabled = false;
    $countdown->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Final Countdown ' . $countdown->id . ' disabled',
          'event_instance_name' => $event_instance_name,
        ]
      )
    );

  }

  /****************************************************************************/

  public function SetCountdown ( Request $request, $event_instance_name, $id )
  {

    $target_date = $request->input( 'target_date' );
    $target_time = $request->input( 'target_time' );
    $title       = $request->input( 'title' );
    $countdown   = Countdown::GetDefaultCountdown( $event_instance_name );

    if( isset( $target_date ) )
    {
      $countdown->target_date = $target_date;
    }

    if( isset( $target_time ) )
    {
      $countdown->target_time = $target_time;
    }

    if( isset( $title ) )
    {
      $countdown->title = $title;
    }

    $countdown->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Final Countdown date set to ' . $countdown->target_date . ' ' . $countdown->target_time,
          'event_instance_name' => $event_instance_name,
        ]
      )
    );

  }

  /****************************************************************************/

}
