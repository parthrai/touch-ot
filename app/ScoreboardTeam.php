<?php

namespace App;

use Exception;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\TraitEventInstanceModel;
use App\ScoreboardTeamConfig;
use App\ScoreboardMember;
use App\Observers\ScoreboardTeamObserver;

class ScoreboardTeam extends Model
{

  /****************************************************************************/

  use SoftDeletes;

  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'team_name',
    'points',
    'points_aggregate'
  ];

  /****************************************************************************/

  protected $team_display_name     = null;
  protected $team_hashtag          = null;
  protected $team_background_color = null;
  protected $team_text_color       = null;
  
  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /****************************************************************************/

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  public $appends = [
    'team_display_name',
    'team_hashtag',
    'team_background_color',
    'team_text_color'
  ];

  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => ScoreboardTeamObserver::class,
    'saved'   => ScoreboardTeamObserver::class,
    'deleted' => ScoreboardTeamObserver::class
  ];

  /** RELATIONSHIPS ***********************************************************/

  public function event_instance ()
  {
    return(
      $this->belongsTo(
        'App\EventInstance',
        'event_instance_id'
      )
    );
  }

  /** ---------------------------------------------------------------------- **/

  public function members ()
  {
    return( $this->hasMany( 'App\ScoreboardMember', 'team_id' ) );
  }

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  public function getTeamDisplayNameAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'name', '=', $this->team_name ]
        ]
      )
      ->first();
      $this->team_display_name = $team->display_name;
    }
    catch( Exception $ex )
    {
      // NO-OP
    }
    return( $this->team_display_name );
  }

  /** ---------------------------------------------------------------------- **/

  public function getTeamHashtagAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'name', '=', $this->team_name ]
        ]
      )
      ->first();
      $this->team_hashtag = $team->hashtag;
    }
    catch( Exception $ex )
    {
      // NO-OP
    }
    return( $this->team_hashtag );
  }

  /** ---------------------------------------------------------------------- **/

  public function getTeamBackgroundColorAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'name', '=', $this->team_name ]
        ]
      )
      ->first();
      $this->team_background_color = $team->hex_background_color;
    }
    catch( Exception $ex )
    {
      $this->team_background_color = "#000000";
    }
    return( $this->team_background_color );
  }

  /** ---------------------------------------------------------------------- **/


  public function getTeamTextColorAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'name', '=', $this->team_name ]
        ]
      )
      ->first();
      $this->team_text_color = $team->hex_text_color;
    }
    catch( Exception $ex )
    {
      $this->team_text_color = "#000000";
    }
    return( $this->team_text_color );
  }

  /****************************************************************************/

  /**
  * Get array of team names.
  *
  * @return Array
  */
  public static function GetTeamNames ( $event_instance_name )
  {

    $team_names     = [];
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames( $event_instance_name );
    $teams          = ScoreboardTeam::whereNotIn(
      'team_name', $excluded_teams
    )
    ->orderBy( 'team_name', 'asc' )
    ->get();

    if( isset( $teams ) && ( count( $teams ) > 0 ) )
    {
      foreach( $teams as $team )
      {
        array_push( $team_names, strtolower( $team->team_name ) );
      }
    }

    return( $team_names );

  }

  /****************************************************************************/

  /**
  * Get array of team names and hashtags.
  *
  * @return Array
  */
  public static function GetTeamSets ( $event_instance_name, $sets )
  {

    $event_instance = ScoreboardTeam::GetEventInstanceByName( $event_instance_name );
    $team_sets      = [];
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames( $event_instance_name );

    $teams          = ScoreboardTeam::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->whereNotIn(
      'team_name', $excluded_teams
    )
    ->orderBy( 'team_name', 'asc' )
    ->get();

    $boundary = ceil( count( $teams ) / $sets );

    if( isset( $teams ) && ( count( $teams ) > 0 ) )
    {

      $count           = 0;
      $set             = 0;
      $team_sets[$set] = [];

      foreach( $teams as $team )
      {

        if( $count >= $boundary )
        {
          $set++;
          $team_sets[$set] = [];
          $count           = 0;
        }

        $team_details = ScoreboardTeamConfig::where(
          [
            [ 'event_instance_id', '=', $event_instance->id ],
            [ 'name', '=', $team->team_name ]
          ]
        )
        ->first();

        if( isset( $team_details ) )
        {

          $team_sets[$set][$team->team_name] = [
            'team_name'             => $team->team_name,
            'team_display_name'     => $team_details->display_name,
            'team_hashtag'          => $team_details->hashtag,
            'team_background_color' => $team_details->hex_background_color,
            'team_text_color'       => $team_details->hex_text_color
          ];

          $count++;

        }

      }

    }

    return( $team_sets );

  }

  /****************************************************************************/

}
