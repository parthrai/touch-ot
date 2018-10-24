<?php

namespace App;

use Exception;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitNormalizeStrings;
use App\Observers\EventScreenObserver;

class EventScreen extends Model
{

  /****************************************************************************/

  use TraitNormalizeStrings;

  use Sortable;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'name',
    'active',
    'tab_label',
    'display_order',
    'touchscreen_image_id'
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
    'active' => 'boolean'
  ];

  /****************************************************************************/

  public $sortable = [
    'id',
    'name',
    'active',
    'tab_label',
    'display_order',
    'touchscreen_image_id'
  ];

  /** CUSTOM ATTRIBUTES *******************************************************/
    
  // NONE

  /** VIRTUAL ATTRIBUTES ******************************************************/

  // NONE
  
  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => EventScreenObserver::class,
    'saved'   => EventScreenObserver::class,
    'deleted' => EventScreenObserver::class
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
    $this->attributes['name'] = EventScreen::NormalizeObjectName( $value );
  }

  /** ---------------------------------------------------------------------- **/

  public function setTabLabelAttribute ( $value )
  {
    $this->attributes['tab_label'] = EventScreen::NormalizeLabel( $value );
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
