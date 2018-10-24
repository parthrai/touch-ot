<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\ScoreboardTeamConfig;
use App\Observers\ScoreboardTeamConfigObserver;

use App\ScoreboardTeam;
use App\Observers\ScoreboardTeamObserver;

use App\ScoreboardMember;
use App\Observers\ScoreboardMemberObserver;

use App\SocialCardBase;
use App\SocialCardTweet;
use App\SocialCardPost;
use App\Observers\SocialCardObserver;

/** BEGIN: Touch Screen ---------------------------------------------------- **/

use App\TouchscreenImage;
use App\Observers\TouchscreenImageObserver;

use App\AgendaScreen;
use App\Observers\AgendaScreenObserver;

use App\AgendaAnnouncement;
use App\Observers\AgendaAnnouncementObserver;

use App\AgendaScheduleEvent;
use App\Observers\AgendaScheduleEventObserver;

use App\AgendaBreakoutSession;
use App\Observers\AgendaBreakoutSessionObserver;

use App\MapScreen;
use App\Observers\MapScreenObserver;

use App\ExpoMap;
use App\Observers\ExpoMapObserver;
use App\ExpoStand;
use App\Observers\ExpoStandObserver;

use App\EventScreen;
use App\Observers\EventScreenObserver;

use App\SponsorScreen;
use App\Observers\SponsorScreenObserver;

/** END: Touch Screen ------------------------------------------------------ **/

class AppServiceProvider extends ServiceProvider
{

  /****************************************************************************/

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot ()
  {

    /** BEGIN: Scoreboard Member Observers --------------------------------- **/
    ScoreboardTeamConfig::observe( ScoreboardTeamConfigObserver::class );
    ScoreboardTeam::observe( ScoreboardTeamObserver::class );
    ScoreboardMember::observe( ScoreboardMemberObserver::class );
    /** END: Scoreboard Member Observers ----------------------------------- **/

    /** BEGIN: Social Card Observers --------------------------------------- **/
    SocialCardBase::observe( SocialCardObserver::class );
    SocialCardTweet::observe( SocialCardObserver::class );
    SocialCardPost::observe( SocialCardObserver::class );
    /** END: Social Card Observers ----------------------------------------- **/

    /** BEGIN: Touch Screen Images Observers ------------------------------- **/
    TouchscreenImage::observe( TouchscreenImageObserver::class );
    /** END: Touch Screen Images Observers --------------------------------- **/

    /** BEGIN: Touch Screen Agenda Screen Observers ------------------------ **/
    AgendaScreen::observe( AgendaScreenObserver::class );
    AgendaAnnouncement::observe( AgendaAnnouncementObserver::class );
    AgendaScheduleEvent::observe( AgendaScheduleEventObserver::class );
    AgendaBreakoutSession::observe( AgendaBreakoutSessionObserver::class );
    /** END: Touch Screen Agenda Screen Observers -------------------------- **/

    /** BEGIN: Touch Screen Map Screens Observers -------------------------- **/
    MapScreen::observe( MapScreenObserver::class );
    /** END: Touch Screen Map Screens Observers ---------------------------- **/

    /** BEGIN: Touch Screen Expo Screen Observers -------------------------- **/
    ExpoMap::observe( ExpoMapObserver::class );
    ExpoStand::observe( ExpoStandObserver::class );
    /** END: Touch Screen Expo Screen Observers ---------------------------- **/

    /** BEGIN: Touch Screen Event Screens Observers ------------------------ **/
    EventScreen::observe( EventScreenObserver::class );
    /** END: Touch Screen Event Screens Observers -------------------------- **/

    /** BEGIN: Touch Screen Sponsor Screens Observers ---------------------- **/
    SponsorScreen::observe( SponsorScreenObserver::class );
    /** END: Touch Screen Sponsor Screens Observers ------------------------ **/

  }

  /****************************************************************************/

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register ()
  {
  
    $this->app->alias( 'bugsnag.logger', \Illuminate\Contracts\Logging\Log::class );
    $this->app->alias( 'bugsnag.logger', \Psr\Log\LoggerInterface::class );
  
  }

  /****************************************************************************/

}
