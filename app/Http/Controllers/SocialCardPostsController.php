<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Traits\TraitEventInstanceController;

use App\SocialCardLookup;
use App\SocialCardPost;

class SocialCardPostsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $cards          = null;

    if( $request->input('q') !== null )
    {

      $query_string = $request->input('q');

      $cards = SocialCardPost::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->where( 'post_text', 'RLIKE', $query_string )
          ->orWhere( 'first_name', 'RLIKE', $query_string )
          ->orWhere( 'last_name', 'RLIKE', $query_string )
          ->orWhere( 'company', 'RLIKE', $query_string );
        }
      )
      ->orderBy( 'post_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

      $cards->appends( [ 'q' => $query_string ] );

    }
    else
    {

      $cards = SocialCardPost::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'post_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

    }

    return(
      view( 'social-cards.appworks-posts.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'request'             => $request,
          'cards'               => $cards
        ]
      )
    );

  }

  /****************************************************************************/

  public function approve ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardPost::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $card ) )
    {

      $card->SetApproved( true );

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Post Approved',
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
            'flash_error'         => 'No such post!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reject ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardPost::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $card ) )
    {

      $card->SetApproved( false );

      Cache::tags( [ 'SocialCards', $event_instance_name ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Post Rejected',
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
            'flash_error'         => 'No such post!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function feature ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardPost::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $card ) )
    {

      $card->SetFeatured( true );

      Cache::tags( [ 'SocialCards', $event_instance_name ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Post Featured',
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
            'flash_error'         => 'No such post!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function unfeature ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardPost::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $card ) )
    {

      $card->SetFeatured( false );

      Cache::tags( [ 'SocialCards', $event_instance_name ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Post Unfeatured',
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
            'flash_error'         => 'No such post!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardPostsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardPost::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $card ) )
    {

      $card->delete();

      Cache::tags( [ 'SocialCards', $event_instance_name ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success'       => 'Post Deleted',
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
            'flash_error'         => 'No such post!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
