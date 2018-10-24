<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\EventInstance;
use App\SocialCardPost;

class SocialCardsPurgeAllAppWorksPosts extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-socialcards:purge-all-appworks-posts {event_instance_id}';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Delete all AppWorks posts from the database.';

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

    $event_instance_id = $this->argument( 'event_instance_id' );
    $count             = 0;
    $cards             = SocialCardPost::
    where( 'event_instance_id', '=', $event_instance_id )
    ->get();

    foreach( $cards as $card )
    {
      $card->delete();
      $count++;
    }

    echo( "Purged: " . $count . " Tweets\n" );

  }

  /****************************************************************************/

}
