<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\ScoreboardTeam;

class ScoreboardTeamObserver
{

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeam created event.
   *
   * @param  \App\ScoreboardTeam $team
   * @return void
   */
  public function created ( ScoreboardTeam $team )
  {
    Cache::tags( [ 'Scoreboard', $team->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeam saved event.
   *
   * @param  \App\ScoreboardTeam $team
   * @return void
   */
  public function saved ( ScoreboardTeam $team )
  {
    Cache::tags( [ 'Scoreboard', $team->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardTeam deleted event.
   *
   * @param  \App\ScoreboardTeam $team
   * @return void
   */
  public function deleted ( ScoreboardTeam $team )
  {
    Cache::tags( [ 'Scoreboard', $team->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
