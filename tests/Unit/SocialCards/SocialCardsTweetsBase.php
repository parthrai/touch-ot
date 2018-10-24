<?php

namespace Tests\Unit;

use Exception;

use Illuminate\Database\QueryException;

use App\EventInstance;
use App\SocialCardTweet;

class SocialCardsTweetsBase extends DatabaseTestCase
{

  /****************************************************************************/

  public function setUp ()
  {

    parent::setUp(); // This must be called first.

    $cards = SocialCardTweet::get();

    foreach( $cards as $card )
    {
      $card->forceDelete();
    }

  }

  /****************************************************************************/

  public function tearDown ()
  {

    $cards = SocialCardTweet::get();

    foreach( $cards as $card )
    {
      $card->forceDelete();
    }

    parent::tearDown(); // This must be called last.

  }

  /****************************************************************************/

}
