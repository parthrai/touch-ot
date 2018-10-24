<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\TraitEventInstanceModel;
use App\Observers\ScoreboardTeamConfigObserver;

class ScoreboardTeamConfig extends Model
{

  /****************************************************************************/

  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'name',
    'display_name',
    'hashtag',
    'hex_background_color',
    'hex_text_color',
    'invisible'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'invisible' => 'boolean'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => ScoreboardTeamConfigObserver::class,
    'saved'   => ScoreboardTeamConfigObserver::class,
    'deleted' => ScoreboardTeamConfigObserver::class
  ];

  /****************************************************************************/

  private static $TeamDefaults = [
    'Blue' => [
      'display_name'         => 'Blue',
      'hashtag'              => 'BL',
      'hex_background_color' => '#2E3D98',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Grey' => [
      'display_name'         => 'Grey',
      'hashtag'              => 'GR',
      'hex_background_color' => '#7E929F',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Purple' => [
      'display_name'         => 'Purple',
      'hashtag'              => 'PL',
      'hex_background_color' => '#4F3690',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Red' => [
      'display_name'         => 'Red',
      'hashtag'              => 'RD',
      'hex_background_color' => '#D92A32',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Teal' => [
      'display_name'         => 'Teal',
      'hashtag'              => 'TL',
      'hex_background_color' => '#00B8BA',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Clear' => [
      'display_name'         => 'Clear',
      'hashtag'              => 'CL',
      'hex_background_color' => '#09BCEF',
      'hex_text_color'       => '#000000',
      'invisible'               => true
    ]
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

  /** MUTATORS ****************************************************************/

  public function setHashtagAttribute ( $value )
  {
    $hashtag = str_replace( '#', '', $value );
    $this->attributes['hashtag'] = $hashtag;
  }

  /** ---------------------------------------------------------------------- **/

  public function setHexBackgroundColorAttribute ( $value )
  {
    $color = $value;
    if( preg_match( '/^#[0-9a-fA-F]+$/', $color ) )
    {
      $color = strtoupper( $value );
    }
    $this->attributes['hex_background_color'] = $color;
  }

  /** ---------------------------------------------------------------------- **/

  public function setHexTextColorAttribute ( $value )
  {
    $color = $value;
    if( preg_match( '/^#[0-9a-fA-F]+$/', $color ) )
    {
      $color = strtoupper( $value );
    }
    $this->attributes['hex_text_color'] = $color;
  }

  /****************************************************************************/
  
  /**
   * Clear table and insert default values.
   *
   * @return void
   */
  public static function ResetToDefaultTeams ( $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfig::GetEventInstanceByName( $event_instance_name );

    DB::beginTransaction();
    ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '!=', null ]
      ]
    )
    ->forceDelete();
    DB::commit();

    foreach( ScoreboardTeamConfig::$TeamDefaults as $name => $struct )
    {

      $team                       = new ScoreboardTeamConfig();
      $team->event_instance_id    = $event_instance->id;
      $team->name                 = $name;
      $team->display_name         = $struct['display_name'];
      $team->hashtag              = $struct['hashtag'];
      $team->hex_background_color = $struct['hex_background_color'];
      $team->hex_text_color       = $struct['hex_text_color'];
      $team->invisible            = $struct['invisible'];
      $team->save();

    }

  }

  /****************************************************************************/

  /**
  * Load team names.
  *
  * @return Array
  */
  public static function GetTeamNames ( $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfig::GetEventInstanceByName( $event_instance_name );

    $team_names = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'invisible', '=', false ]
      ]
    )
    ->pluck( 'name' )
    ->toArray();

    return( $team_names );

  }

  /****************************************************************************/
  
  /**
  * Load team names.
  *
  * @return Array
  */
  public static function GetInvisibleTeamNames ( $event_instance_name )
  {

    $event_instance = ScoreboardTeamConfig::GetEventInstanceByName( $event_instance_name );

    $team_names = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'invisible', '=', true ]
      ]
    )
    ->pluck( 'name' )
    ->toArray();

    return( $team_names );

  }

  /****************************************************************************/
  
  /**
  * Load hashtags into associative array.
  *
  * @return Array
  */
  public static function GetHashtags ( $event_instance_name, bool $DowncaseTeamName = false )
  {
    
    $event_instance = ScoreboardTeamConfig::GetEventInstanceByName( $event_instance_name );
    $hashtags       = [];
    $teams          = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'invisible', '=', false ]
      ]
    )
    ->get();

    foreach( $teams as $team )
    {
      $team_name = $team->name;
      if( $DowncaseTeamName )
      {
        $team_name = strtolower( $team_name );
      }
      $hashtags[$team_name] = $team->hashtag;
    }

    return( $hashtags );

  }

  /****************************************************************************/
  
  /**
  * Load team colours into an array of arrays.
  *
  * @return Array
  */
  public static function GetTeamColors ( $event_instance_name, bool $DowncaseTeamName = false )
  {

    $event_instance = ScoreboardTeamConfig::GetEventInstanceByName( $event_instance_name );
    $colours        = [];
    $teams          = ScoreboardTeamConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'invisible', '=', false ]
      ]
    )
    ->get();
    
    foreach( $teams as $team )
    {
      $team_name = $team->name;
      if( $DowncaseTeamName )
      {
        $team_name = strtolower( $team_name );
      }
      $colours[$team_name] = [
        'hex_background_color' => $team->hex_background_color,
        'hex_text_color'       => $team->hex_text_color
      ];
    }

    return( $colours );

  }

  /****************************************************************************/

}
