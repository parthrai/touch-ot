<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\ScoreboardTeamConfig;

class ScoreboardTeamConfigObserver
{

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeamConfig created event.
   *
   * @param  \App\ScoreboardTeamConfig $config
   * @return void
   */
  public function created ( ScoreboardTeamConfig $config )
  {
    Cache::tags( [ 'Scoreboard', $config->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeamConfig saved event.
   *
   * @param  \App\ScoreboardTeamConfig $config
   * @return void
   */
  public function saved ( ScoreboardTeamConfig $config )
  {
    Cache::tags( [ 'Scoreboard', $config->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeamConfig deleted event.
   *
   * @param  \App\ScoreboardTeamConfig $config
   * @return void
   */
  public function deleted ( ScoreboardTeamConfig $config )
  {
    Cache::tags( [ 'Scoreboard', $config->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
