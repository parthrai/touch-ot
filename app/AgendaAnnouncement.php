<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

use App\Observers\AgendaAnnouncementObserver;

class AgendaAnnouncement extends Model
{

  /****************************************************************************/

  use Sortable;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'announcement'
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
    'announcement',
    'created_at',
    'updated_at'
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
    'created' => AgendaAnnouncementObserver::class,
    'saved'   => AgendaAnnouncementObserver::class,
    'deleted' => AgendaAnnouncementObserver::class
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

  // NONE

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
