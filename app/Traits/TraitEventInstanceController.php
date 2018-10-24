<?php

namespace App\Traits;

use App\EventInstance;

trait TraitEventInstanceController
{

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

    if( isset( $event_instance ) )
    {
      return( $event_instance );
    }

    abort( 404 );

  }

  /****************************************************************************/

}
