<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceModel;
use App\Traits\TraitNormalizeStrings;
use App\Observers\ExpoMapObserver;

class ExpoMap extends Model
{

  /****************************************************************************/

  use Sortable;

  use TraitNormalizeStrings;
  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'map_id',
    'name',
    'touchscreen_image_id',
    'default',
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
    'default' => 'boolean'
  ];

  /****************************************************************************/

  public $sortable = [
    'id',
    'map_id',
    'name',
    'created_at',
    'updated_at'
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
    'created' => ExpoMapObserver::class,
    'saved'   => ExpoMapObserver::class,
    'deleted' => ExpoMapObserver::class
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

  public function touchscreen_image ()
  {
    return(
      $this->hasOne(
        'App\TouchscreenImage',
        'id',
        'touchscreen_image_id'
      )
    );
  }

  /** MUTATORS ****************************************************************/

  public function setNameAttribute ( $value )
  {
    $this->attributes['name'] = ExpoMap::NormalizeObjectName( $value );
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
