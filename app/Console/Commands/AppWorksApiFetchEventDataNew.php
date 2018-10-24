<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\EventInstance;
use App\Fetchers\AppWorksApiFetchEventData;

class AppWorksApiFetchEventDataNew extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-appworks:fetch-event-data';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fetch event data from AppWorks API.';

  /****************************************************************************/

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct ()
  {
    parent::__construct ();
  }

  /****************************************************************************/

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle ()
  {
    
    $fetcher    = new AppWorksApiFetchEventData( true );
    $otag_token = null;

    if( EventInstance::whereNotNull('id')->count() <= 0 )
    {
      echo( "No event instances currently loaded.\n" );
    }
    else
    {
      $otag_token = $fetcher->Login();
    }

    if( isset( $otag_token ) )
    {
      echo( "Logged in OK: " . $otag_token . "\n" );
      $fetcher->FetchEvents( $otag_token );
    }
    else
    {
      echo( "Login failed.\n" );
    }

  }

  /****************************************************************************/

}
