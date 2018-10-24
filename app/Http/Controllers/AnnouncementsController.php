<?php

namespace App\Http\Controllers;

use Auth;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\Announcement;

class AnnouncementsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcements  = Announcement::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy('announcement')->get();

    return(
      view( 'announcements.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'announcements'       => $announcements
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    return(
      view( 'announcements.create' )
      ->with(
        [
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance                  = AnnouncementsController::GetEventInstanceByName( $event_instance_name );

    $announcement                    = new Announcement();
    $announcement->event_instance_id = $event_instance->id;
    $announcement->announcement      = $request->input( 'announcement' );
    $announcement->save();

    return(
      redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'New Announcement Added',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $announcement ) )
    {

      return(
        view( 'announcements.update' )
        ->with(
          [
            'event_instance_name' => $event_instance_name,
            'announcement'        => $announcement
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $announcement ) )
    {

      $announcement->announcement = $request->input( 'announcement' );
      $announcement->save();

      return(
        redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Announcement Updated',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function activate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();
    $announcement->active = true;
    $announcement->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Announcement ' . $announcement->id . ' activated',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function deactivate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();
    $announcement->active = false;
    $announcement->save();

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Announcement ' . $announcement->id . ' deactivated',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $announcement ) )
    {

      $announcement->delete();

      return(
        redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Announcement Deleted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
