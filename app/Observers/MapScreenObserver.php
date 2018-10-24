<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\MapScreen;

class MapScreenObserver
{

  /****************************************************************************/

  /**
   * Listen to the MapScreen created event.
   *
   * @param  \App\MapScreen $screen
   * @return void
   */
  public function created ( MapScreen $screen )
  {
    Cache::tags( [ 'TsMap', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the MapScreen saved event.
   *
   * @param  \App\MapScreen $screen
   * @return void
   */
  public function saved ( MapScreen $screen )
  {
    Cache::tags( [ 'TsMap', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the MapScreen deleted event.
   *
   * @param  \App\MapScreen $screen
   * @return void
   */
  public function deleted ( MapScreen $screen )
  {
    Cache::tags( [ 'TsMap', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
