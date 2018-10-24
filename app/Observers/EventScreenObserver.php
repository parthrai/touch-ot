<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\EventScreen;

class EventScreenObserver
{

  /****************************************************************************/

  /**
   * Listen to the EventScreen created event.
   *
   * @param  \App\EventScreen $screen
   * @return void
   */
  public function created ( EventScreen $screen )
  {
    Cache::tags( [ 'TsEvent', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the EventScreen saved event.
   *
   * @param  \App\EventScreen $screen
   * @return void
   */
  public function saved ( EventScreen $screen )
  {
    Cache::tags( [ 'TsEvent', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the EventScreen deleted event.
   *
   * @param  \App\EventScreen $screen
   * @return void
   */
  public function deleted ( EventScreen $screen )
  {
    Cache::tags( [ 'TsEvent', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
