<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceModel;
use App\Observers\AgendaBreakoutSessionObserver;

class AgendaBreakoutSession extends Model
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
    'session_id',
    'date',
    'time_start',
    'time_end',
    'display_order',
    'icon',
    'title',
    'title_override',
    'description',
    'description_override',
    'location',
    'location_override',
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
    'session_id',
    'date',
    'time_start',
    'time_end',
    'display_order',
    'icon',
    'title',
    'title_override',
    'description',
    'description_override',
    'location',
    'location_override',
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
    'created' => AgendaBreakoutSessionObserver::class,
    'saved'   => AgendaBreakoutSessionObserver::class,
    'deleted' => AgendaBreakoutSessionObserver::class
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

  public function setTitleAttribute ( $value )
  {

    $this->attributes['title'] = $value;

    if( ! array_key_exists( 'title_override', $this->attributes ) )
    {
      $this->attributes['title_override'] = $value;
    }
    elseif( array_key_exists( 'title_override', $this->attributes ) && ( strlen( $this->attributes['title_override'] ) == 0 ) )
    {
      $this->attributes['title_override'] = $value;
    }

  }

  /** ---------------------------------------------------------------------- **/

  public function setDescriptionAttribute ( $value )
  {

    $this->attributes['description'] = $value;

    if( ! array_key_exists( 'description_override', $this->attributes ) )
    {
      $this->attributes['description_override'] = $value;
    }
    elseif( array_key_exists( 'description_override', $this->attributes ) && ( strlen( $this->attributes['description_override'] ) == 0 ) )
    {
      $this->attributes['description_override'] = $value;
    }

  }

  /** ---------------------------------------------------------------------- **/

  public function setLocationAttribute ( $value )
  {

    $this->attributes['location'] = $value;

    if( ! array_key_exists( 'location_override', $this->attributes ) )
    {
      $this->attributes['location_override'] = $value;
    }
    elseif( array_key_exists( 'location_override', $this->attributes ) && ( strlen( $this->attributes['location_override'] ) == 0 ) )
    {
      $this->attributes['location_override'] = $value;
    }

  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  // NONE

  /****************************************************************************/

}
