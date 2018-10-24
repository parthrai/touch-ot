<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\EventInstance;
use App\SocialCardTweet;

class SocialCardsPurgeAllTweets extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-socialcards:purge-all-tweets {event_instance_id}';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Delete all tweets from the database.';

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
    $cards             = SocialCardTweet::
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
