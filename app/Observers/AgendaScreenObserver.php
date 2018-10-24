<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\AgendaScreen;

class AgendaScreenObserver
{

  /****************************************************************************/

  /**
   * Listen to the AgendaScreen created event.
   *
   * @param  \App\AgendaScreen $screen
   * @return void
   */
  public function created ( AgendaScreen $screen )
  {
    Cache::tags( [ 'TsAgenda', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaScreen saved event.
   *
   * @param  \App\AgendaScreen $screen
   * @return void
   */
  public function saved ( AgendaScreen $screen )
  {
    Cache::tags( [ 'TsAgenda', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaScreen deleted event.
   *
   * @param  \App\AgendaScreen $screen
   * @return void
   */
  public function deleted ( AgendaScreen $screen )
  {
    Cache::tags( [ 'TsAgenda', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
