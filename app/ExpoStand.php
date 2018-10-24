<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceModel;
use App\Observers\ExpoStandObserver;

class ExpoStand extends Model
{

  /****************************************************************************/

  use Sortable;
  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'stand_id',
    'exhibitor',
    'exhibitor_override',
    'stand',
    'expo_map_id',
    'position_x',
    'position_y',
    'expo_level_id',
    'hidden',
    'fetch_batch'
  ];

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
  ];
    
  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'hidden' => 'boolean'
  ];

  /****************************************************************************/

  public $sortable = [
    'id',
    'stand_id',
    'exhibitor',
    'exhibitor_override',
    'stand',
    'created_at',
    'updated_at',
    'position_x',
    'position_y',
    'expo_level_id',
    'hidden'
  ];

  /** VIRTUAL ATTRIBUTES ******************************************************/

  // NONE
  
  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => ExpoStandObserver::class,
    'saved'   => ExpoStandObserver::class,
    'deleted' => ExpoStandObserver::class
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

  public function expo_map ()
  {
    return(
      $this->hasOne(
        'App\ExpoMap',
        'id',
        'expo_map_id'
      )
    );
  }

  /** ---------------------------------------------------------------------- **/

  public function expo_level ()
  {
    return(
      $this->hasOne(
        'App\ExpoLevel',
        'id',
        'expo_level_id'
      )
    );
  }

  /** MUTATORS ****************************************************************/

  public function setExhibitorAttribute ( $value )
  {

    $this->attributes['exhibitor'] = $value;

    if( ! array_key_exists( 'exhibitor_override', $this->attributes ) )
    {
      $this->attributes['exhibitor_override'] = $value;
    }
    elseif( array_key_exists( 'exhibitor_override', $this->attributes ) && ( strlen( $this->attributes['exhibitor_override'] ) == 0 ) )
    {
      $this->attributes['exhibitor_override'] = $value;
    }

  }

  /** ACCESSORS ***************************************************************/

  // NONE
  
  /****************************************************************************/

}
