<?php

namespace App\Http\Controllers;

use Auth;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\TouchscreenImage;
use App\EventScreen;

class TouchscreenEventScreensController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screens        = EventScreen::
    with( 'touchscreen_image' )
    ->sortable()
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'display_order', 'ASC' )
    ->paginate( 20 );

    return(
      view( 'touch-screen.ts-event-screens.index' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'screens' => $screens
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance     = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $touchscreen_images = TouchscreenImage::
    where( 'event_instance_id', '=', $event_instance->id )
    ->get();

    return(
      view( 'touch-screen.ts-event-screens.create' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'touchscreen_images'=> $touchscreen_images
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance       = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $touchscreen_image_id = $request->input( 'touchscreen_image_id' );
    $active               = $request->input( 'active' );

    if( ! isset( $active ) )
    {
      $active = false;
    }

    $screen                    = new EventScreen();
    $screen->event_instance_id = $event_instance->id;
    $screen->name              = $request->input( 'name' );
    $screen->active            = $active;
    $screen->tab_label         = $request->input( 'tab_label' );
    $screen->display_order     = $request->input( 'display_order' );

    if( isset( $touchscreen_image_id ) && ( strlen( $touchscreen_image_id ) > 0 ) )
    {
      $screen->touchscreen_image_id = $touchscreen_image_id;
    }

    try
    {
      $screen->save();
    }
    catch( Exception $ex )
    {
      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'     => 'Failed to create new Event Screen',
            'flash_exception' => $ex->getMessage(),
            'event_instance_name' => $event_instance->name
          ]
        )
      );
    }

    return(
      redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success' => 'New Event Screen Added',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance     = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    
    $touchscreen_images = TouchscreenImage::
    where( 'event_instance_id', '=', $event_instance->id )
    ->get();
    
    $screen = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $screen ) )
    {

      return(
        view( 'touch-screen.ts-event-screens.update' )
        ->with(
          [
            'event_instance_name' => $event_instance->name,
            'screen'             => $screen,
            'touchscreen_images' => $touchscreen_images
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Event Screen Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $screen ) )
    {

      $touchscreen_image_id = $request->input( 'touchscreen_image_id' );
      $active               = $request->input( 'active' );

      if( ! isset( $active ) )
      {
        $active = false;
      }
  
      $screen->name          = $request->input( 'name' );
      $screen->active        = $active;
      $screen->tab_label     = $request->input( 'tab_label' );
      $screen->display_order = $request->input( 'display_order' );
 
      if( isset( $touchscreen_image_id ) && ( strlen( $touchscreen_image_id ) > 0 ) )
      {
        $screen->touchscreen_image_id = $touchscreen_image_id;
      }

      try
      {
        $screen->save();
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
          ->with(
            [
              'flash_error'     => 'Failed to update Event Screen',
              'flash_exception' => $ex->getMessage(),
              'event_instance_name' => $event_instance->name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Event Screen Updated',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Event Screen Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderDown ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $screen ) )
    {

      $new_order = $screen->display_order - 1;

      if( $new_order <= 0 )
      {
        $new_order = 1;
      }

      $screen->display_order = $new_order;
      $screen->save();

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Event Screen Order Adjusted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Event Screen Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderUp ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $screen ) )
    {

      $new_order             = $screen->display_order + 1;
      $screen->display_order = $new_order;
      $screen->save();

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Event Screen Order Adjusted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Event Screen Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function activate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    $screen->active = true;
    $screen->save();

    return(
      redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success' => 'Event Screen ' . $screen->id . ' activated',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function deactivate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    $screen->active = false;
    $screen->save();

    return(
      redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success' => 'Event Screen ' . $screen->id . ' deactivated',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenEventScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = EventScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $screen ) )
    {

      $screen->delete();

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Event Screen Deleted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-event-screens', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Event Screen Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
