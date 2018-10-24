<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Traits\TraitEventInstanceController;

use App\SocialCardLookup;
use App\SocialCardTweet;

class SocialCardTweetsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $cards          = null;

    if( $request->input('q') !== null )
    {

      $query_string = $request->input('q');

      $cards = SocialCardTweet::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->where( 'user_screen_name', 'RLIKE', $query_string )
          ->orWhere( 'tweet_text', 'RLIKE', $query_string );
        }
      )
      ->orderBy( 'tweet_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

      $cards->appends( [ 'q' => $query_string ] );

    }
    else
    {

      $cards = SocialCardTweet::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'tweet_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

    }

    return(
      view( 'social-cards.tweets.index' )
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

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardTweet::where(
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
            'flash_success'       => 'Tweet Approved',
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
            'flash_error'         => 'No such tweet!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reject ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardTweet::where(
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
            'flash_success'       => 'Tweet Rejected',
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
            'flash_error'         => 'No such tweet!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function feature ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardTweet::where(
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
            'flash_success'       => 'Tweet Featured',
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
            'flash_error'         => 'No such tweet!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function unfeature ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardTweet::where(
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
            'flash_success'       => 'Tweet Unfeatured',
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
            'flash_error'         => 'No such tweet!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = SocialCardTweetsController::GetEventInstanceByName( $event_instance_name );
    $card           = SocialCardTweet::where(
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
            'flash_success'       => 'Tweet Deleted',
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
            'flash_error'         => 'No such tweet!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
