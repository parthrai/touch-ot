<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\iSocialCard;

class SocialCardsNewCard implements ShouldBroadcast
{

  /****************************************************************************/

  use Dispatchable;
  use InteractsWithSockets;
  use SerializesModels;

  /****************************************************************************/

  public $card = null;

  /****************************************************************************/

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct ( iSocialCard $card )
  {
    $this->card = $card;
  }

  /****************************************************************************/

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn ()
  {

    //dd( $this->card );



    return( new Channel( 'socialcards' ) );
    //return new PrivateChannel( 'socialcards' );
  }

  /****************************************************************************/

}
