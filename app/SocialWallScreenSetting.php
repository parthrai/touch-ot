<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\TraitEventInstanceModel;

class SocialWallScreenSetting extends Model
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
    'screen',
    'status',
    'duration'
  ];

  /****************************************************************************/

  public $timestamps = false;

  /****************************************************************************/

  protected $casts = [
    'status' => 'boolean'
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

  /****************************************************************************/

  private static $ScreenDefaults = [
    'test_card'            => [ 'enabled' => true, 'duration' => 3000 ],
    'countdown'            => [ 'enabled' => false, 'duration' => 10000 ],
    'announcement'         => [ 'enabled' => false, 'duration' => 15000 ],
    'splash_screen'        => [ 'enabled' => true, 'duration' => 5000 ],
    'team_ranking'         => [ 'enabled' => true, 'duration' => 5000 ],
    'team_members_ranking' => [ 'enabled' => true, 'duration' => 5000 ],
    'social_cards'         => [ 'enabled' => true, 'duration' => 15000 ],
    'leaderboards'         => [ 'enabled' => true, 'duration' => 5000 ]
  ];

  /** MUTATORS ****************************************************************/

  public function setDurationAttribute ( $value )
  {

    $duration = 10000;

    if( isset( $value ) && ( $value > 0 ) )
    {
      $duration = $value;
    }

    if( $duration < 3000 )
    {
      $duration = 3000;
    }

    $this->attributes['duration'] = $duration;
    
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

  /**
   * Clear table and insert default values.
   *
   * @return void
   */
  public static function ResetToDefaults ( $event_instance_name )
  {

    $event_instance = SocialWallScreenSetting::GetEventInstanceByName( $event_instance_name );

    SocialWallScreenSetting::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '!=', null ]
      ]
    )
    ->forceDelete();

    foreach( SocialWallScreenSetting::$ScreenDefaults as $name => $struct )
    {

      $setting                    = new SocialWallScreenSetting();
      $setting->event_instance_id = $event_instance->id;
      $setting->screen            = $name;
      $setting->status            = $struct['enabled'];
      $setting->duration          = $struct['duration'];
      $setting->save();

    }

  }

  /****************************************************************************/

  /**
   * Get simple status for all screens.
   *
   * @return Array $screen_statuses
   */
  public static function GetSimpleScreenStatuses ( $event_instance_name )
  {

    $event_instance  = SocialWallScreenSetting::GetEventInstanceByName( $event_instance_name );
    
    $screen_statuses = SocialWallScreenSetting::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->pluck( 'status', 'screen' )
    ->toArray();

    return( $screen_statuses );

  }

  /****************************************************************************/

}
