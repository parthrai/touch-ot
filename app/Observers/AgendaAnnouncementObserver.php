<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\AgendaAnnouncement;

class AgendaAnnouncementObserver
{

  /****************************************************************************/

  /**
   * Listen to the AgendaAnnouncement created event.
   *
   * @param  \App\AgendaAnnouncement $announcement
   * @return void
   */
  public function created ( AgendaAnnouncement $announcement )
  {
    Cache::tags( [ 'TsAgenda', $announcement->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaAnnouncement saved event.
   *
   * @param  \App\AgendaAnnouncement $announcement
   * @return void
   */
  public function saved ( AgendaAnnouncement $announcement )
  {
    Cache::tags( [ 'TsAgenda', $announcement->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the AgendaAnnouncement deleted event.
   *
   * @param  \App\AgendaAnnouncement $announcement
   * @return void
   */
  public function deleted ( AgendaAnnouncement $announcement )
  {
    Cache::tags( [ 'TsAgenda', $announcement->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
