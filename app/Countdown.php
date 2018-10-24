<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

use App\Traits\TraitEventInstanceModel;

class Countdown extends Model
{

  /****************************************************************************/

  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'enabled',
    'target_date',
    'target_time',
    'title'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'enabled' => 'boolean'
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

  /**
  * Return the first countdown.
  *
  * @return Countdown
  */
  public static function GetDefaultCountdown ( $event_instance_name )
  {

    $event_instance = Countdown::GetEventInstanceByName( $event_instance_name );
    $countdown      = Countdown::where( 'event_instance_id', '=', $event_instance->id )->first();

    if( ! isset( $countdown ) )
    {

      $datetime = Carbon::now(1);
      $datetime->addDays( 31 );

      $countdown                    = new Countdown();
      $countdown->event_instance_id = $event_instance->id;
      $countdown->target_date       = $datetime->toDateString();
      $countdown->target_time       = $datetime->format('h:i:s');
      $countdown->title             = 'The Final Countdown';

      $countdown->save();

    }

    return( $countdown );

  }

  /****************************************************************************/

}
