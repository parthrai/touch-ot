<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\TouchscreenImage;

class TouchscreenImageObserver
{

  /****************************************************************************/

  /**
   * Listen to the TouchscreenImage created event.
   *
   * @param  \App\TouchscreenImage $image
   * @return void
   */
  public function created ( TouchscreenImage $image )
  {
    Cache::tags( [ 'TsAgenda', $image->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the TouchscreenImage saved event.
   *
   * @param  \App\TouchscreenImage $image
   * @return void
   */
  public function saved ( TouchscreenImage $image )
  {
    Cache::tags( [ 'TsAgenda', $image->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the TouchscreenImage deleted event.
   *
   * @param  \App\TouchscreenImage $image
   * @return void
   */
  public function deleted ( TouchscreenImage $image )
  {
    Cache::tags( [ 'TsAgenda', $image->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
