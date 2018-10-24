<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Faker\Factory as Faker;

use App\Events\ScoreboardRefresh;

class ScoreboardTriggerRefresh extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-scoreboard:trigger-refresh';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Trigger scoreboard refresh.';

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
    ScoreboardRefresh::dispatch();
  }

  /****************************************************************************/

}
