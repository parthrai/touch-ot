<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\EventInstance;

class CodeFingerprint extends Model
{

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'screen_type'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

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

  /****************************************************************************/

  public static function GetCurrentFingerprint ( $event_instance, $screen_type )
  {

    $fingerprint = CodeFingerprint::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'screen_type', '=', $screen_type ]
      ]
    )
    ->orderBy( 'id', 'desc' )
    ->first();

    if( ! isset( $fingerprint ) )
    {
      $fingerprint                    = new CodeFingerprint();
      $fingerprint->event_instance_id = $event_instance->id;
      $fingerprint->screen_type       = $screen_type;
      $fingerprint->save();
    }

    return( $fingerprint );
  }

  /****************************************************************************/

}
