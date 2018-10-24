<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use App\EventInstance;
use App\iSocialCard;
use App\SocialCardBase;

class SocialCardTweet extends SocialCardBase implements iSocialCard
{

  /****************************************************************************/

  use Sortable;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'card_created_at',
    'tweet_id',
    'tweet_text',
    'lang',
    'user_name',
    'user_screen_name',
    'user_location',
    'user_url',
    'user_image',
    'image'
  ];

  /****************************************************************************/

  public $sortable = [
    'event_instance_id',
    'card_created_at',
    'tweet_id',
    'tweet_text',
    'lang',
    'user_name',
    'user_screen_name',
    'user_location',
    'user_url',
    'user_image',
    'image'
  ];

  /** VIRTUAL ATTRIBUTES ******************************************************/

  public $card_type = "tweet";

  /** RELATIONSHIPS ***********************************************************/

  public function event_instance ()
  {
    return(
      $this->belongsTo(
        'App\EventInstance',
        'event_instance_id'
      )
    );
  }

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  public function getCardVueIdAttribute ()
  {
    $this->card_vue_id = $this->card_type . '_' . $this->tweet_id;
    return( $this->card_vue_id );
  }

  /****************************************************************************/

}
