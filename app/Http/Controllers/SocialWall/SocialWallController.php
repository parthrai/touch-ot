<?php

namespace App\Http\Controllers\SocialWall;

use Exception;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;

use App\EventInstance;
use App\SocialWallScreenSetting;
use App\Countdown;
use App\ScoreboardTeam;
use App\Leaderboard;
use App\SocialCardConfig;

class SocialWallController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
  * Show social wall page.
  *
  * @return \Illuminate\Http\Response
  */
  public function index ( Request $request, $event_instance_name )
  {

    $event_instance      = SocialWallController::GetEventInstanceByName( $event_instance_name );
    $debug               = $request->input( 'debug' );
    $debug_mode          = 'false';
    $screen_settings     = SocialWallScreenSetting::GetSimpleScreenStatuses( $event_instance_name ); //pluck( 'status', 'screen' )->toArray();
    $final_countdown     = Countdown::GetDefaultCountdown( $event_instance_name );
    $leaderboards        = Leaderboard::GetLeaderboardOrders( $event_instance_name );
    $teams               = new ScoreboardTeam();
    $team_names          = $teams->GetTeamNames( $event_instance_name );
    $team_sets           = $teams->GetTeamSets( $event_instance_name, 2 ); // Get n sets of team names and hashtags
    $social_cards_config = SocialCardConfig::GetConfiguration( $event_instance_name );

    foreach( $leaderboards as $key => $value )
    {
      $screen_settings[ 'leaderboard' . '_' . $value ] = $screen_settings['leaderboards'];
    }
    
    foreach( $team_names as $team_name )
    {
      $screen_settings[ join( '_', [ 'team_members_ranking', $team_name ] ) ] = $screen_settings['team_members_ranking'];
    }

    if( isset( $debug ) && ( $debug == true ) )
    {
      $debug_mode = 'true';
    }

    return(
      view(
        'social-wall.index',
        [
          'debug_mode'          => $debug_mode,
          'event_instance'      => $event_instance,
          'event_instance_name' => $event_instance_name,
          'screen_settings'     => $screen_settings,
          'final_countdown'     => $final_countdown,
          'team_sets'           => $team_sets,
          'social_cards_config' => $social_cards_config
        ]
      )
    );

  }

  /****************************************************************************/

  /**
  * Return social wall settings.
  *
  * @return \Illuminate\Http\Response
  */
  public function MonitorSettings ( Request $request, $event_instance_name )
  {

    $event_instance  = SocialWallController::GetEventInstanceByName( $event_instance_name );
    $teams           = new ScoreboardTeam();
    $team_names      = $teams->GetTeamNames( $event_instance_name );
    $leaderboards    = Leaderboard::GetLeaderboardOrders( $event_instance_name );

    $screen_settings = SocialWallScreenSetting::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'screen', '!=', 'test_card' ]
      ]
    )
    ->get();

    $test_card = SocialWallScreenSetting::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'screen', '=', 'test_card' ]
      ]
    )
    ->first();

    $settings        = [];
    $some_enabled    = false;

    foreach( $screen_settings as $screen_setting )
    {

      $screen            = $screen_setting->screen;
      $enabled           = $screen_setting->status;
      $duration          = $screen_setting->duration;

      $settings[$screen] = [
        'screen'   => $screen,
        'enabled'  => $enabled,
        'duration' => $duration
      ];

      if( $enabled == true )
      {
        $some_enabled = true;

      }
    }

    foreach( $team_names as $team_name )
    {
      $screen_name                        = join( '_', [ 'team_members_ranking', $team_name ] );
      $settings[ $screen_name ]           = $settings['team_members_ranking'];
      $settings[ $screen_name ]['screen'] = $screen_name;
    }

    unset( $settings['team_members_ranking'] );

    foreach( $leaderboards as $key => $value )
    {
      $screen_name                        = 'leaderboard' . '_' . $value;
      $settings[ $screen_name ]           = $settings['leaderboards'];
      $settings[ $screen_name ]['screen'] = $screen_name;
    }

    unset( $settings['leaderboards'] );

    if( $some_enabled  )
    {
      $settings[$test_card->screen] = [
        'screen'   => $test_card->screen,
        'enabled'  => false,
        'duration' => $test_card->duration
      ];
    }
    else
    {

      try
      {
        $settings[$test_card->screen] = [
          'screen'   => $test_card->screen,
          'enabled'  => true,
          'duration' => $test_card->duration
        ];
      }
      catch( Exception $ex )
      {
        abort( 503, "The screens do not appear to be configured yet." );
      }

    }

    return(
      response()
      ->json( $settings )
    );

  }

  /****************************************************************************/

}
