<?php

namespace Tests\Unit;

use Exception;

use Illuminate\Database\QueryException;

use App\EventInstance;
use App\SocialCardPost;

class SocialCardsPostsBase extends DatabaseTestCase
{

  /****************************************************************************/

  public function setUp ()
  {

    parent::setUp(); // This must be called first.

    $cards = SocialCardPost::get();

    foreach( $cards as $card )
    {
      $card->forceDelete();
    }

  }

  /****************************************************************************/

  public function tearDown ()
  {

    $cards = SocialCardPost::get();

    foreach( $cards as $card )
    {
      $card->forceDelete();
    }

    parent::tearDown(); // This must be called last.

  }

  /****************************************************************************/

}
