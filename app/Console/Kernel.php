<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

  /****************************************************************************/

  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [

    Commands\ScoreboardFetchNewPoints::class,

    Commands\SocialCardsAppWorksPostsFetchNew::class,
    Commands\SocialCardsTweetsFetchNew::class,
   
    Commands\AppWorksApiFetchEventsNew::class,
    Commands\AppWorksApiFetchEventDataNew::class,

    Commands\SocialCardsPurgeAllAppWorksPosts::class,
    Commands\SocialCardsPurgeAllTweets::class
    
  ];

  /****************************************************************************/

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule ( Schedule $schedule )
  {

    /** BEGIN: FETCH APPWORKS API DATA ****************************************/

    $schedule->command( 'ot-appworks:fetch-events' )
    ->hourlyAt(0)
    ->withoutOverlapping();

    $schedule->command( 'ot-appworks:fetch-event-data' )
    ->hourlyAt(5)
    ->withoutOverlapping();

    $schedule->command( 'ot-scoreboard:fetch-new-points' )
    ->everyFiveMinutes()
    ->withoutOverlapping();

    $schedule->command( 'ot-socialcards:fetch-new-posts' )
    ->everyFiveMinutes()
    ->withoutOverlapping();

    /** END: FETCH APPWORKS API DATA ******************************************/

    /** BEGIN: FETCH TWITTER API DATA *****************************************/

    $schedule->command( 'ot-socialcards:fetch-new-tweets' )
    ->everyMinute()
    ->withoutOverlapping();

    /** END: FETCH TWITTER API DATA *******************************************/

  }

  /****************************************************************************/

  /**
   * Register the Closure based commands for the application.
   *
   * @return void
   */
  protected function commands ()
  {
    require( base_path( 'routes/console.php' ) );
  }

  /****************************************************************************/

}
