<?php

namespace App\Http\Controllers;

use Exception;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Traits\TraitEventInstanceController;

use App\Point;
use App\ScoreboardTeamConfig;

class PointsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = PointsController::GetEventInstanceByName( $event_instance_name );
    $teams          = ScoreboardTeamConfig::GetHashtags( $event_instance_name, true );
    $teams_colors   = ScoreboardTeamConfig::GetTeamColors( $event_instance_name, true );
    $query_string = $request->input('q');

    if( isset( $query_string ) && ( strlen( $query_string ) > 0 ) )
    {
      

      $search_results = Point::
      withTrashed()
      ->sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->where( 'team', 'RLIKE', $query_string )
          ->orWhere( 'source', 'RLIKE', $query_string );
        }
      )
      ->paginate( 20 );

      $search_results->appends( [ 'q' => $query_string ] );

      return(
        view( 'points.index' )
        ->with(
          [
            'event_instance_name' => $event_instance_name,
            'request'             => $request,
            'points'              => $search_results,
            'teams'               => $teams,
            'teams_colors'        => $teams_colors
          ]
        )
      );

    }

    $points = Point::
    withTrashed()
    ->sortable()
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'updated_at', 'desc' )
    ->paginate( 15 );

    return(
      view( 'points.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'request'             => $request,
          'points'              => $points,
          'teams'               => $teams,
          'teams_colors'        => $teams_colors
        ]
      )
    );

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = PointsController::GetEventInstanceByName( $event_instance_name );
    $point          = Point::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )->first();

    try
    {
      $point->delete();
    }
    catch( Exception $ex )
    {
      return( $ex->getMessage() );
    }

    return(
      back()
      ->with(
        [
          'flash_success'       => 'Points Deleted',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function restore ( Request $request, $event_instance_name, $id )
  {

    $event_instance = PointsController::GetEventInstanceByName( $event_instance_name );

    Point::
    onlyTrashed()
    ->where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->restore();
  
    return(
      back()
      ->with(
        [
          'flash_success'       => 'Points Restored',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /** AWARD POINTS APPLICATION ************************************************/

  public function AwardPointsForm ( Request $request, $event_instance_name )
  {

    $event_instance = PointsController::GetEventInstanceByName( $event_instance_name );
    $user           = Auth::user();
    $teams          = ScoreboardTeamConfig::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'invisible', '=', false ]
      ]
    )      
    ->get();

    return(
      view( 'points.award' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'user_id'             => $user->id,
          'teams'               => $teams
        ]
      )
    );

  }

  /** ---------------------------------------------------------------------- **/

  public function AwardPoints ( Request $request, $event_instance_name )
  {

    $event_instance = PointsController::GetEventInstanceByName( $event_instance_name );
    $points         = new Point();
    $name           = null;
    $user_id        = $request->input( 'user_id' );
    $team           = $request->input( 'team' );
    $score          = $request->input( 'score' );
    $team_config    = ScoreboardTeamConfig::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'hashtag', '=', strtolower( $team ) ]
      ]
    )
    ->first();

    $points->event_instance_id = $event_instance->id;

    if( isset( $team_config ) )
    {
      $name = $team_config->name;
    }
    else
    {
      $name = $team;
    }

    if( isset( $user_id ) )
    {
      $points->team   = $name;
      $points->points = $score;
      $points->source = "PointsApp";
      $points->audit  = $user_id;
    }
    else
    {
      $points->team   = $name;
      $points->points = $score;
      $points->source = "Arcade";
      $points->audit  = null;
    }

    $points->save();

    return( response()->json( 'New points added' ) );

  }

  /****************************************************************************/

  // TODO: Refactor this to use updated Points model.
  static function report ( Request $request, $event_instance_name )
  {
    return( PointsController::grab() );
  }

  /****************************************************************************/

}
