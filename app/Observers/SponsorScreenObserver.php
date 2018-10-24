<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\SponsorScreen;

class SponsorScreenObserver
{

  /****************************************************************************/

  /**
   * Listen to the SponsorScreen created event.
   *
   * @param  \App\SponsorScreen $screen
   * @return void
   */
  public function created ( SponsorScreen $screen )
  {
    Cache::tags( [ 'TsSponsor', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the SponsorScreen saved event.
   *
   * @param  \App\SponsorScreen $screen
   * @return void
   */
  public function saved ( SponsorScreen $screen )
  {
    Cache::tags( [ 'TsSponsor', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the SponsorScreen deleted event.
   *
   * @param  \App\SponsorScreen $screen
   * @return void
   */
  public function deleted ( SponsorScreen $screen )
  {
    Cache::tags( [ 'TsSponsor', $screen->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
