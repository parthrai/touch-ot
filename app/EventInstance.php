<?php

namespace App;

use Exception;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitNormalizeStrings;

class EventInstance extends Model
{

  /****************************************************************************/

  use SoftDeletes;
  use Sortable;

  use TraitNormalizeStrings;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'event_uuid',
    'active',
    'name',
    'display_name',
    'timezone',
    'date_start',
    'date_end',
    'game_enabled'
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
    'active'       => 'boolean',
    'game_enabled' => 'boolean'
  ];

  /****************************************************************************/

  public $sortable = [
    'id',
    'event_uuid',
    'active',
    'name',
    'display_name',
    'timezone',
    'date_start',
    'date_end',
    'game_enabled'
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
  ];

  /** RELATIONSHIPS ***********************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  public function setEventUuidAttribute ( $value )
  {
    $this->attributes['event_uuid'] = strtolower( $value );
  }

  /** ---------------------------------------------------------------------- **/

  public function setNameAttribute ( $value )
  {
    $this->attributes['name'] = EventInstance::NormalizeEventInstanceName( $value );
  }

  /** ---------------------------------------------------------------------- **/

  public function setDisplayAttribute ( $value )
  {
    $this->attributes['display_name'] = EventInstance::NormalizeLabel( $value );
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

  /**
  * Return default EventInstance.
  *
  * @return EventInstance
  */
  public static function GetDefaultInstance ()
  {

    $instance               = EventInstance::firstOrNew( [ 'name' => 'default' ] );
    $instance->event_uuid   = uniqid( 'DEFAULT-', true );
    $instance->active       = true;
    $instance->name         = 'default';
    $instance->display_name = 'Default Event Instance';
    $instance->timezone     = 'UTC';
    $instance->date_start   = '1970-01-01';
    $instance->date_end     = '2100-12-31';
    $instance->save();

    return( $instance );

  }

  /****************************************************************************/

  /**
  * Return EventInstance ID by event_uuid.
  *
  * @return EventInstance
  */
  public static function findEventInstanceId ( $event_uuid )
  {
    $id = null;
    try
    {
      $id = EventInstance::
      where( 'event_uuid', '=', $event_uuid )
      ->pluck('id')->first();
    }
    catch( Exception $ex )
    {
      // NO-OP
    }
    return( $id );
  }

  /****************************************************************************/

  /**
  * Return EventInstance by event_uuid.
  *
  * @return EventInstance
  */
  public static function findEventInstance ( $event_uuid )
  {
    $event = null;
    try
    {
      $event = EventInstance::
      where( 'event_uuid', '=', $event_uuid )
      ->first();
    }
    catch( Exception $ex )
    {
      // NO-OP
    }
    return( $event );
  }

  /****************************************************************************/

}
