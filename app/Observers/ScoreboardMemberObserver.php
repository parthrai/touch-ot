<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\ScoreboardMember;
use App\Events\ScoreboardRefresh;

class ScoreboardMemberObserver
{

  /****************************************************************************/

  /**
   * Listen to the ScoreboardMember created event and fire events.
   *
   * @param  \App\ScoreboardMember $member
   * @return void
   */
  public function created ( ScoreboardMember $member )
  {
    ScoreboardRefresh::dispatch();
    Cache::tags( [ 'Scoreboard', $member->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardMember saved event.
   *
   * @param  \App\ScoreboardMember $member
   * @return void
   */
  public function saved ( ScoreboardMember $member )
  {
    Cache::tags( [ 'Scoreboard', $member->event_instance->name ] )->flush();
  }

  /****************************************************************************/

  /**
   * Listen to the ScoreboardMember deleted event.
   *
   * @param  \App\ScoreboardMember $member
   * @return void
   */
  public function deleted ( ScoreboardMember $member )
  {
    Cache::tags( [ 'Scoreboard', $member->event_instance->name ] )->flush();
  }

  /****************************************************************************/

}
