<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Fetchers\AppWorksApiFetchEvents;

class AppWorksApiFetchEventsNew extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-appworks:fetch-events';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fetch events from AppWorks API.';

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
    
    $fetcher    = new AppWorksApiFetchEvents( true );
    $otag_token = $fetcher->Login();

    if( isset( $otag_token ) )
    {

      echo( "Logged in OK: " . $otag_token . "\n" );

      $package = $fetcher->FetchPackage( $otag_token );

      if( isset( $package ) )
      {

        if( $fetcher->ProcessEvents( $package ) )
        {
          echo( "ProcessEvents OK\n" );
        }
        else
        {
          echo( "ProcessEvents failed.\n" );
        }

      }
      else
      {
        echo( "FetchPackage failed.\n" );
      }

    }
    else
    {
      echo( "Login failed.\n" );
    }

  }

  /****************************************************************************/

}
