<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\AgendaScheduleEvent;

class AgendaScheduleEventObserver
{

  /****************************************************************************/

  /**
   * Listen to the AgendaScheduleEvent created event.
   *
   * @param  \App\AgendaScheduleEvent $event
   * @return void
   */
  public function created ( AgendaScheduleEvent $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaScheduleEvent saved event.
   *
   * @param  \App\AgendaScheduleEvent $event
   * @return void
   */
  public function saved ( AgendaScheduleEvent $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaScheduleEvent deleted event.
   *
   * @param  \App\AgendaScheduleEvent $event
   * @return void
   */
  public function deleted ( AgendaScheduleEvent $event )
  {
    Cache::tags( [ 'TsAgenda', $event->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
