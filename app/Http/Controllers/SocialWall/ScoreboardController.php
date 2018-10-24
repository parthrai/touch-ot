<?php

namespace App\Http\Controllers\SocialWall;

use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;

use App\ScoreboardTeamConfig;
use App\ScoreboardTeam;
use App\ScoreboardMember;

class ScoreboardController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  protected $cache_duration = 1; // Minutes

  /****************************************************************************/

  /**
  * Get scoreboard team scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetTeamScores ( Request $request, $event_instance_name )
  {

    $event_instance = ScoreboardController::GetEventInstanceByName( $event_instance_name );
    $teams          = null;
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames( $event_instance_name );
    $cache_key      = 'TeamScores';

    if( Cache::tags( [ 'Scoreboard', $event_instance_name ] )->has( $cache_key ) )
    {
      $teams = Cache::tags( [ 'Scoreboard', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $teams ) )
    {

      $teams = ScoreboardTeam::
      with( 'members' )
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->whereNotIn( 'team_name', $excluded_teams )
      ->orderBy( 'points_aggregate', 'desc' )
      ->get();

      if( isset( $teams ) )
      {
        Cache::tags( [ 'Scoreboard', $event_instance_name ] )->put( $cache_key, $teams, $this->cache_duration );
      }

    }

    return(
      response()
      ->json( $teams )
    );

  }

  /****************************************************************************/

  /**
  * Get scoreboard team member top scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetAllTopTeamMembersScores ( Request $request, $event_instance_name )
  {

    $event_instance = ScoreboardController::GetEventInstanceByName( $event_instance_name );
    $members        = null;
    $cache_key      = 'AllTeamMembersScores';

    if( Cache::tags( [ 'Scoreboard', $event_instance_name ] )->has( $cache_key ) )
    {
      $members = Cache::tags( [ 'Scoreboard', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $members ) )
    {

      $members = ScoreboardMember::
      with( 'team' )
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'points', 'desc' )
      ->get();
    
      if( isset( $members ) )
      {
        Cache::tags( [ 'Scoreboard', $event_instance_name ] )->put( $cache_key, $members, $this->cache_duration );
      }

    }

    return(
      response()
      ->json( $members )
    );

  }

  /****************************************************************************/

  /**
  * Get scoreboard team member top scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetTopTeamMembersScores ( Request $request, $event_instance_name, $team_name )
  {

    $event_instance = ScoreboardController::GetEventInstanceByName( $event_instance_name );
    $members        = null;
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames( $event_instance_name );
    $cache_key      = 'TeamMembersScores:' . $team_name;

    if( Cache::tags( [ 'Scoreboard', $event_instance_name ] )->has( $cache_key ) )
    {
      $members = Cache::tags( [ 'Scoreboard', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $members ) )
    {

      $members = ScoreboardMember::
      with( 'team' )
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->whereHas(
        'team', function ( $query ) use ( $team_name, $excluded_teams )
        {
          $query->where( 'team_name', '=', $team_name )
          ->whereNotIn( 'team_name', $excluded_teams );
        }  
      )
      ->orderBy( 'points', 'desc' )
      ->limit( 5 )
      ->get();
  
      if( isset( $members ) )
      {
        Cache::tags( [ 'Scoreboard',$event_instance_name ] )->put( $cache_key, $members, $this->cache_duration );
      }

    }

    return(
      response()
      ->json( $members )
    );

  }

  /****************************************************************************/

}
