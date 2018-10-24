<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\ExpoStand;

class ExpoStandObserver
{

  /****************************************************************************/

  /**
   * Listen to the ExpoStand created event.
   *
   * @param  \App\ExpoStand $expo_stand
   * @return void
   */
  public function created ( ExpoStand $expo_stand )
  {
    Cache::tags( [ 'TsExpo', $expo_stand->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ExpoStand saved event.
   *
   * @param  \App\ExpoStand $expo_stand
   * @return void
   */
  public function saved ( ExpoStand $expo_stand )
  {
    Cache::tags( [ 'TsExpo', $expo_stand->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ExpoStand deleted event.
   *
   * @param  \App\ExpoStand $expo_stand
   * @return void
   */
  public function deleted ( ExpoStand $expo_stand )
  {
    Cache::tags( [ 'TsExpo', $expo_stand->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
