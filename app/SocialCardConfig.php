<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;

use App\Traits\TraitEventInstanceModel;

class SocialCardConfig extends Model
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
    'fetch_batchsize_tweets',
    'display_max_items',
    'appworks_posts_ratio',
    'tweets_ratio',
    'appworks_posts_featured',
    'tweets_featured'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

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

  // NONE

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

  public static function GetConfiguration ( $event_instance_name )
  {
    
    $event_instance = Leaderboard::GetEventInstanceByName( $event_instance_name );
    $config         = SocialCardConfig::where(
      'event_instance_id', '=', $event_instance->id
    )->first();

    if( ! isset( $config ) )
    {
      $config                          = new SocialCardConfig();
      $config->event_instance_id       = $event_instance->id;
      $config->fetch_batchsize_tweets  = 100;
      $config->display_max_items       = 30;
      $config->appworks_posts_ratio    = 60;
      $config->tweets_ratio            = 100 - $config->appworks_posts_ratio;
      $config->appworks_posts_featured = 1;
      $config->tweets_featured         = 1;
      $config->save();
    }

    return( $config );
    
  }     

  /****************************************************************************/

  public static function ResetToDefault ( $event_instance_name )
  {

    $event_instance = Leaderboard::GetEventInstanceByName( $event_instance_name );

    DB::beginTransaction();

    SocialCardConfig::where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '!=', null ]
      ]
    )
    //whereNotNull('id')
    ->forceDelete();

    DB::commit();

    return( SocialCardConfig::GetConfiguration( $event_instance_name ) );
    
  }     

  /****************************************************************************/

}
