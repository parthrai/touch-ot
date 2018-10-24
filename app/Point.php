<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{

  /****************************************************************************/

  use SoftDeletes;
  use Sortable;

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

  protected $dates = [ "deleted_at" ];
  
  public $sortable = [
    'id',
    'team',
    'points',
    'audit',
    'source',
    'created_at',
    'updated_at'
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

  public function audit_user ()
  {
    return(
      $this->belongsTo(
        'App\User',
        'audit'
      )
    );
  }

  /****************************************************************************/

  public function latest ()
  {
    return $this->orderBy( 'updated_at', 'desc' );
  }

  /****************************************************************************/

  public function GetAuditUserName ()
  {
    if( $this->audit_user )
    {
      return( $this->audit_user->name );
    }
    return( 'SYSTEM' );
  }

  /****************************************************************************/

  public function reports ()
  {

    $points_by_team = Point::all();

  }

  /****************************************************************************/

}
