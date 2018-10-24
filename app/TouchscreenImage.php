<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitNormalizeStrings;
use App\Observers\TouchscreenImageObserver;

class TouchscreenImage extends Model
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
    'image_xs',
    'image_sm',
    'image_md',
    'image_lg',
    'link'
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

  public $sortable = [
    'id',
    'name',
    'image_xs',
    'image_sm',
    'image_md',
    'image_lg',
    'link'
  ];

  /** CUSTOM ATTRIBUTES *******************************************************/
    
  public static $image_sizes = [
    'image_lg',
    'image_md',
    'image_sm',
    'image_xs'
  ];

  public static $image_size_codes = [
    'lg',
    'md',
    'sm',
    'xs'
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
    'created' => TouchscreenImageObserver::class,
    'saved'   => TouchscreenImageObserver::class,
    'deleted' => TouchscreenImageObserver::class
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

  public function setNameAttribute ( $value )
  {
    $this->attributes['name'] = TouchscreenImage::NormalizeObjectName( $value );
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
