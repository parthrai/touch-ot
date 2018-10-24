<?php

namespace App;

use Exception;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitNormalizeStrings;
use App\Observers\AgendaScreenObserver;

class AgendaScreen extends Model
{

  /****************************************************************************/

  use TraitNormalizeStrings;

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
    'type',
    'date',
    'tab_label',
    'display_order',
    'agenda_announcement_id',
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
    'created' => AgendaScreenObserver::class,
    'saved'   => AgendaScreenObserver::class,
    'deleted' => AgendaScreenObserver::class
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

  public function agenda_announcement ()
  {
    return(
      $this->hasOne(
        'App\AgendaAnnouncement',
        'id',
        'agenda_announcement_id'
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
    $this->attributes['name'] = AgendaScreen::NormalizeObjectName( $value );
  }

  /** ---------------------------------------------------------------------- **/

  public function setTypeAttribute ( $value )
  {

    $types = [
      'announcement' => true,
      'image'        => true,
      'schedule'     => true
    ];

    if( array_key_exists( $value, $types ) )
    {
      $this->attributes['type'] = $value;
    }
    else
    {
      throw new Exception( "Invalid type" );
    }

  }

  /** ---------------------------------------------------------------------- **/

  public function setTabLabelAttribute ( $value )
  {
    $this->attributes['tab_label'] = AgendaScreen::NormalizeLabel( $value );
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
