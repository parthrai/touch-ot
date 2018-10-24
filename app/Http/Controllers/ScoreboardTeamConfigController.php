<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

use App\Traits\TraitEventInstanceController;
use App\ScoreboardTeamConfig;

class ScoreboardTeamConfigController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $teams          = ScoreboardTeamConfig::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'name' )
    ->get();

    return(
      view( 'scoreboard-team-configs.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'teams'               => $teams
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $team           = new ScoreboardTeamConfig();

    $team->event_instance_id = $event_instance->id;

    return(
      view( 'scoreboard-team-configs.create' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'team'                => $team
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );

    $team                       = new ScoreboardTeamConfig();
    $team->event_instance_id    = $event_instance->id;
    $team->name                 = $request->input( 'name' );
    $team->display_name         = $request->input( 'display_name' );
    $team->hashtag              = $request->input( 'hashtag' );
    $team->hex_background_color = $request->input( 'hex_background_color' );
    $team->hex_text_color       = $request->input( 'hex_text_color' );
    $team->invisible            = $request->input( 'invisible' );
    $team->save();

    $teams = ScoreboardTeamConfig::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'name' )
    ->get();

    Cache::tags( [ 'Scoreboard', $event_instance_name ] )->flush();

    return(
      view( 'scoreboard-team-configs.index' )
      ->with(
        [
          'flash_success'       => 'New Team Added',
          'event_instance_name' => $event_instance_name,
          'teams'               => $teams
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $team           = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $team ) )
    {

      return(
        view( 'scoreboard-team-configs.update' )
        ->with(
          [
            'event_instance_name' => $event_instance_name,
            'team'                => $team
          ]
        )
      );	

    }
    else
    {
      
      return(
        view( 'scoreboard-team-configs.index' )
        ->with(
          [
            'flash_error'         => 'Team Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $team           = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $team ) )
    {

      $team->name                 = $request->input( 'name' );
      $team->display_name         = $request->input( 'display_name' );
      $team->hashtag              = $request->input( 'hashtag' );
      $team->hex_background_color = $request->input( 'hex_background_color' );
      $team->hex_text_color       = $request->input( 'hex_text_color' );
      $team->invisible            = $request->input( 'invisible' );
      $team->save();

      Cache::tags( [ 'Scoreboard', $event_instance_name ] )->flush();

      $teams = ScoreboardTeamConfig::where(
        'event_instance_id', '=', $event_instance->id
      )
      ->orderBy( 'name' )
      ->get();

      return(
        view( 'scoreboard-team-configs.index' )
        ->with(
          [
            'flash_success'       => 'Team Updated',
            'event_instance_name' => $event_instance_name,
            'teams'               => $teams
          ]
        )
      );

    }
    else
    {

      $teams = ScoreboardTeamConfig::where(
        'event_instance_id', '=', $event_instance->id
      )
      ->orderBy( 'name' )
      ->get();

      return(
        view( 'scoreboard-team-configs.index' )
        ->with(
          [
            'flash_error'         => 'Team Not Found!',
            'event_instance_name' => $event_instance_name,
            'teams'               => $teams
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $team           = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $teams = ScoreboardTeamConfig::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'name' )
    ->get();

    if( isset( $team ) )
    {

      $team->delete();

      Cache::tags( [ 'Scoreboard', $event_instance_name ] )->flush();

      return(
        view( 'scoreboard-team-configs.index' )
        ->with(
          [
            'flash_success'       => 'Team Deleted',
            'event_instance_name' => $event_instance_name,
            'teams'               => $teams
          ]
        )
      );

    }
    else
    {

      return(
        view( 'scoreboard-team-configs.index' )
        ->with(
          [
            'flash_error'         => 'Team Not Found!',
            'event_instance_name' => $event_instance_name,
            'teams'               => $teams
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reset_teams ( Request $request, $event_instance_name )
  {

    ScoreboardTeamConfig::ResetToDefaultTeams( $event_instance_name );

    $event_instance = ScoreboardTeamConfigController::GetEventInstanceByName( $event_instance_name );
    $teams          = ScoreboardTeamConfig::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'name' )
    ->get();

    Cache::tags( [ 'Scoreboard', $event_instance_name ] )->flush();

    return(
      view( 'scoreboard-team-configs.index' )
      ->with(
        [
          'flash_success'       => 'Teams reset to default settings.',
          'event_instance_name' => $event_instance_name,
          'teams'               => $teams
        ]
      )
    );

  }

  /****************************************************************************/

}
