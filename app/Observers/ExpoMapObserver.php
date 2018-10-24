<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\ExpoMap;

class ExpoMapObserver
{

  /****************************************************************************/

  /**
   * Listen to the ExpoMap created event.
   *
   * @param  \App\ExpoMap $expo_map
   * @return void
   */
  public function created ( ExpoMap $expo_map )
  {
    Cache::tags( [ 'TsExpo', $expo_map->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ExpoMap saved event.
   *
   * @param  \App\ExpoMap $expo_map
   * @return void
   */
  public function saved ( ExpoMap $expo_map )
  {
    Cache::tags( [ 'TsExpo', $expo_map->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ExpoMap deleted event.
   *
   * @param  \App\ExpoMap $expo_map
   * @return void
   */
  public function deleted ( ExpoMap $expo_map )
  {
    Cache::tags( [ 'TsExpo', $expo_map->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
