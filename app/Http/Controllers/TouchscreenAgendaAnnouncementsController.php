<?php

namespace App\Http\Controllers;

use Auth;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\AgendaAnnouncement;

class TouchscreenAgendaAnnouncementsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );

    $announcements = AgendaAnnouncement::
    sortable()
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'announcement' )
    ->paginate( 20 );

    return(
      view( 'touch-screen.ts-agenda-announcements.index' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'announcements'       => $announcements
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );

    return(
      view( 'touch-screen.ts-agenda-announcements.create' )
      ->with(
        [
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance                  = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement                    = new AgendaAnnouncement();
    $announcement->event_instance_id = $event_instance->id;
    $announcement->announcement      = $request->input( 'announcement' );

    $announcement->save();

    return(
      redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success'       => 'New Announcement Added',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = AgendaAnnouncement::
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
        view( 'touch-screen.ts-agenda-announcements.update' )
        ->with(
          [
            'event_instance_name' => $event_instance->name,
            'announcement'        => $announcement
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = AgendaAnnouncement::
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
        redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Announcement Updated',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaAnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = AgendaAnnouncement::
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
        redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Announcement Deleted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Announcement Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
