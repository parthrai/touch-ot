<?php

namespace App\Traits;

use App\EventInstance;

trait TraitEventInstanceModel
{

  /****************************************************************************/
  
  /**
  * Set the event_instance_id on this object.
  *
  * @param  EventInstance $event_instance
  * @return integer $event_instance_id
  */
  public function SetEventInstance ( EventInstance $event_instance )
  {
    $this->event_instance_id = $event_instance->id;
    return( $this->event_instance_id );
  }

  /****************************************************************************/
  
  /**
  * Get the event instance by its name.
  *
  * @param  string $name
  * @return EventInstance $event_instance
  */
  public static function GetEventInstanceByName ( $name )
  {

    $event_instance = EventInstance::where( 'name', '=', $name )->first();

    return( $event_instance );

  }

  /****************************************************************************/

}
