<?php

namespace App\Http\Controllers;

use Auth;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\TouchscreenImage;
use App\ExpoMap;

class TouchscreenExpoMapsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $expo_maps      = ExpoMap::
    with( 'touchscreen_image' )
    ->sortable()
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'name', 'ASC' )
    ->paginate( 20 );

    return(
      view( 'touch-screen.ts-expo-maps.index' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'expo_maps'           => $expo_maps
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance     = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $touchscreen_images = TouchscreenImage::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy('name')->get();

    return(
      view( 'touch-screen.ts-expo-maps.create' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'touchscreen_images'  => $touchscreen_images
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $default        = $request->input( 'default' );

    if( ! isset( $default ) )
    {
      $default = false;
    }

    $expo_map                       = new ExpoMap();
    $expo_map->event_instance_id    = $event_instance->id;
    $expo_map->map_id               = uniqid( 'CUSTOM-MAP-', false );
    $expo_map->name                 = $request->input( 'name' );
    $expo_map->default              = $default;
    $expo_map->touchscreen_image_id = $request->input( 'touchscreen_image_id' );

    try
    {

      $expo_map->save();

      if( $default == true )
      {

        $maps = ExpoMap::where(
          [
            [ 'event_instance_id', '=', $event_instance->id ],
            [ 'id', '!=', $expo_map->id ]
          ]
        )->get();

        foreach( $maps as $map )
        {
          $map->default = false;
          $map->save();
        }

      }

    }
    catch( Exception $ex )
    {
      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Failed to create new Expo Map',
            'flash_exception'     => $ex->getMessage(),
            'event_instance_name' => $event_instance->name
          ]
        )
      );
    }

    return(
      redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success'       => 'New Expo Map Added',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance     = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $touchscreen_images = TouchscreenImage::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy('name')
    ->get();
    $expo_map = ExpoMap::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $expo_map ) )
    {

      return(
        view( 'touch-screen.ts-expo-maps.update' )
        ->with(
          [
            'expo_map'            => $expo_map,
            'touchscreen_images'  => $touchscreen_images,
            'event_instance_name' => $event_instance->name
            ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Expo Map Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $expo_map       = ExpoMap::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $expo_map ) )
    {

      $default = $request->input( 'default' );
  
      if( ! isset( $default ) )
      {
        $default = false;
      }
  
      $expo_map->name                 = $request->input( 'name' );
      $expo_map->touchscreen_image_id = $request->input( 'touchscreen_image_id' );
      $expo_map->default              = $default;
    
      try
      {
        
        $expo_map->save();

        if( $default == true )
        {

          $maps = ExpoMap::where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'id', '!=', $expo_map->id ]
            ]
          )
          ->get();

          foreach( $maps as $map )
          {
            $map->default = false;
            $map->save();
          }

        }
  
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
          ->with(
            [
              'flash_error'         => 'Failed to update Expo Map',
              'flash_exception'     => $ex->getMessage(),
              'event_instance_name' => $event_instance->name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Expo Map Updated',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Expo Map Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenExpoMapsController::GetEventInstanceByName( $event_instance_name );
    $expo_map       = ExpoMap::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $expo_map ) )
    {

      try
      {
        $expo_map->delete();
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
          ->with(
            [
              'flash_error'         => 'Failed to delete Expo Map',
              'flash_exception'     => $ex->getMessage(),
              'event_instance_name' => $event_instance->name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Expo Map Deleted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Expo Map Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
