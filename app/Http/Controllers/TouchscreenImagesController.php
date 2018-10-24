<?php

namespace App\Http\Controllers;

use Auth;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\TouchscreenImage;

class TouchscreenImagesController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenImagesController::GetEventInstanceByName( $event_instance_name );

    $images = TouchscreenImage::
    sortable()
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy('name')
    ->paginate( 6 );

    return(
      view( 'touch-screen.ts-images.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'images'              => $images
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    return(
      view( 'touch-screen.ts-images.create' )
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

    $event_instance           = TouchscreenImagesController::GetEventInstanceByName( $event_instance_name );
    $image                    = new TouchscreenImage();
    $image->event_instance_id = $event_instance->id;
    $image->name              = $request->input( 'name' );
    $image->link              = $request->input( 'link' );

    try
    {
      $this->StoreImages( $request, $event_instance_name, $image, false );
    }
    catch( Exception $ex )
    {
      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Failed to store images for new Touchscreen Image',
            'flash_exception'     => $ex->getMessage(),
            'event_instance_name' => $event_instance_name
          ]
        )
      );
    }

    try
    {
      $image->save();
    }
    catch( Exception $ex )
    {
      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Failed to create new Touchscreen Image',
            'flash_exception'     => $ex->getMessage(),
            'event_instance_name' => $event_instance_name
          ]
        )
      );
    }

    return(
      redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'New Touchscreen Image Added',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  private function StoreImages ( Request $request, $event_instance_name, TouchscreenImage $image, $delete_old = false )
  {

    foreach( TouchscreenImage::$image_sizes as $image_size )
    {

      if( $image_size != TouchscreenImage::$image_sizes[0] )
      {

        if( $request->file( $image_size ) == null )
        {
          $image->{$image_size} = $image->{TouchscreenImage::$image_sizes[0]};
        }

      }
      else
      {

        try
        {

          $filename = join(
            '.',
            [
              uniqid( 'touch-screen-image-', true ),
              $request->file( $image_size )->getClientOriginalExtension()
            ]
          );

          if( $delete_old == true )
          {
            try
            {
              unlink( storage_path( 'app/public/' . $image->{$image_size} ) );
            }
            catch( ErrorException $ex )
            {
              // NO-OP
            }
            catch( Exception $ex )
            {
              // NO-OP
            }
          }

          $request->file( $image_size )->storeAs( 'public', $filename );

          $image->{$image_size} = $filename;

        }
        catch( Exception $ex )
        {
          $image->{$image_size} = null;
        }

      }

    }

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenImagesController::GetEventInstanceByName( $event_instance_name );
    $image          = TouchscreenImage::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $image ) )
    {

      return(
        view( 'touch-screen.ts-images.update' )
        ->with(
          [
            'event_instance_name' => $event_instance_name,
            'image'               => $image
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Touchscreen Image Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenImagesController::GetEventInstanceByName( $event_instance_name );
    $image          = TouchscreenImage::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $image ) )
    {

      $image->name = $request->input( 'name' );
      $image->link = $request->input( 'link' );

      $this->StoreImages( $request, $event_instance_name, $image, true );

      try
      {
        $image->save();
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
          ->with(
            [
              'flash_error'         => 'Failed to update Touchscreen Image',
              'flash_exception'     => $ex->getMessage(),
              'event_instance_name' => $event_instance_name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Touchscreen Image Updated',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Touchscreen Image Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenImagesController::GetEventInstanceByName( $event_instance_name );
    $image          = TouchscreenImage::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $image ) )
    {

      $erasures = [];

      try
      {
        
        foreach( TouchscreenImage::$image_sizes as $image_size )
        {
          array_push( $erasures, $image->{$image_size} );
        }
        
        $image->delete();

      }
      catch( Exception $ex )
      {

        return(
          redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
          ->with(
            [
              'flash_error'         => 'Failed to delete Touchscreen Image',
              'flash_exception'     => $ex->getMessage(),
              'event_instance_name' => $event_instance_name
            ]
          )
        );

      }

      if( count( $erasures ) > 0 )
      {

        foreach( $erasures as $erasure )
        {
          try
          {
            unlink( storage_path( 'app/public/' . $erasure ) );
          }
          catch( Exception $ex )
          {
            // NO-OP
          }
        }

      }

      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Touchscreen Image Deleted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Touchscreen Image Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
