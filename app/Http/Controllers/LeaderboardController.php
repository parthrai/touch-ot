<?php

namespace App\Http\Controllers;

use Exception;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\Leaderboard;
use App\SocialWallScreenSetting;

class LeaderboardController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = LeaderboardController::GetEventInstanceByName( $event_instance_name );

    $leaderboards   = Leaderboard::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy('display_order')
    ->get();

    return(
      view( 'leaderboard.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'leaderboards'        => $leaderboards
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    return(
      view( 'leaderboard.create' )
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

    $event_instance                 = LeaderboardController::GetEventInstanceByName( $event_instance_name );
    $leaderboard                    = new Leaderboard;
    $leaderboard->event_instance_id = $event_instance->id;
    $leaderboard->name              = $request->input( 'name' );

    // TODO: Check for failure here:
    $this->StoreImages( $request, $event_instance_name, $leaderboard, false );

    $leaderboard->display_order = $request->input( 'display_order' );
    $leaderboard->save();

    return(
      redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'New Leaderboard Added',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      return(
        view( 'leaderboard.update' )
        ->with(
          [
            'event_instance_name' => $event_instance_name,
            'leaderboard'         => $leaderboard
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Leaderboard Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $leaderboard->name = $request->input( 'name' );
      $this->StoreImages( $request, $event_instance_name, $leaderboard, true );
      $leaderboard->display_order = $request->input( 'display_order' );
      $leaderboard->save();

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Leaderboard Updated',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Leaderboard Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      foreach( Leaderboard::$image_sizes as $image_size )
      {
        try
        {
          unlink( storage_path( 'app/public/' . $leaderboard->{$image_size} ) );
        }
        catch( Exception $ex )
        {
          // NO-OP
        }
      }

      $leaderboard->delete();

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Leaderboard Deleted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Leaderboard Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderDown ( Request $request, $event_instance_name, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $new_order = $leaderboard->display_order - 1;

      if( $new_order <= 0 )
      {
        $new_order = 1;
      }

      $leaderboard->display_order = $new_order;
      $leaderboard->save();

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Leaderboard Order Adjusted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Leaderboard Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderUp ( Request $request, $event_instance_name, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $new_order                  = $leaderboard->display_order + 1;
      $leaderboard->display_order = $new_order;
      $leaderboard->save();

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Leaderboard Order Adjusted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Leaderboard Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  private function StoreImages ( Request $request, $event_instance_name, Leaderboard $leaderboard, $delete_old = false )
  {

    foreach( Leaderboard::$image_sizes as $image_size )
    {

      if( $image_size != Leaderboard::$image_sizes[0] )
      {

        if( $request->file( $image_size ) == null )
        {
          $leaderboard->{$image_size} = $leaderboard->{Leaderboard::$image_sizes[0]};
        }

      }
      else
      {

        try
        {

          $filename = join(
            '.',
            [
              uniqid( 'leaderboard', true ),
              $request->file( $image_size )->getClientOriginalExtension()
            ]
          );

          if( $delete_old == true )
          {
            try
            {
              unlink( storage_path( 'app/public/' . $leaderboard->{$image_size} ) );
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

          $leaderboard->{$image_size} = $filename;

        }
        catch( Exception $ex )
        {
          $leaderboard->{$image_size} = null;
        }

      }

    }

  }

  /****************************************************************************/

}
