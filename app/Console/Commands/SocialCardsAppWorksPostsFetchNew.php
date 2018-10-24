<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\EventInstance;
use App\SocialCardPost;
use App\Fetchers\SocialCardsAppWorksPostsFetch;

class SocialCardsAppWorksPostsFetchNew extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-socialcards:fetch-new-posts';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fetch new social cards from AppWorks.';

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

    $fetcher = new SocialCardsAppWorksPostsFetch( true );

    if( EventInstance::whereNotNull('id')->count() <= 0 )
    {
      echo( "No event instances currently loaded.\n" );
    }
    else
    {
      $fetcher->FetchPosts();
    }

  }

  /****************************************************************************/

}
