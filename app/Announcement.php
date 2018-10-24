<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;

class Announcement extends Model
{

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'active',
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
