<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\AgendaBreakoutSession;

class AgendaBreakoutSessionObserver
{

  /****************************************************************************/

  /**
   * Listen to the AgendaBreakoutSession created event.
   *
   * @param  \App\AgendaBreakoutSession $event
   * @return void
   */
  public function created ( AgendaBreakoutSession $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaBreakoutSession saved event.
   *
   * @param  \App\AgendaBreakoutSession $event
   * @return void
   */
  public function saved ( AgendaBreakoutSession $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaBreakoutSession deleted event.
   *
   * @param  \App\AgendaBreakoutSession $event
   * @return void
   */
  public function deleted ( AgendaBreakoutSession $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
