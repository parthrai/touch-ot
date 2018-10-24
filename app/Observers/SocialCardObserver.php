<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\iSocialCard;
use App\SocialCardLookup;
use App\Events\SocialCardsNewCard;

use App\SocialCardHashtagLookup;
use App\SocialCardHashtag;

class SocialCardObserver
{

  /****************************************************************************/

  /**
   * Listen to the iSocialCard created event and fire events.
   *
   * @param  \App\iSocialCard $card
   * @return void
   */
  public function created ( iSocialCard $card )
  {

    $lookup = SocialCardLookup::where(
      [
        [ 'social_card_id', '=', $card->id ],
        [ 'social_card_type', '=', get_class( $card ) ]
      ]
    )
    ->first();

    if( isset( $lookup ) )
    {
      $lookup->event_instance_id = $card->event_instance_id;
      $lookup->created_at        = $card->card_created_at;
      $lookup->save();
    }

    SocialCardsNewCard::dispatch( $card );

  }

  /****************************************************************************/

  /**
   * Listen to the iSocialCard saved event.
   * Insert new record into SocialCardLookup table.
   *
   * @param  \App\iSocialCard $card
   * @return void
   */
  public function saved ( iSocialCard $card )
  {

    $lookup = SocialCardLookup::where(
      [
        [ 'social_card_id', '=', $card->id ],
        [ 'social_card_type', '=', get_class( $card ) ]
      ]
    )
    ->first();

    if( ! isset( $lookup ) )
    {
      $lookup = new SocialCardLookup();
    }

    $lookup->event_instance_id = $card->event_instance_id;
    $lookup->social_card_id    = $card->id;
    $lookup->created_at        = $card->card_created_at;
    $lookup->social_card_type  = get_class( $card );

    $lookup->save();

    Cache::tags( [ 'SocialCards', $card->event_instance->name ] )->flush();

  }

  /****************************************************************************/

  /**
   * Listen to the iSocialCard deleted event.
   *
   * @param  \App\iSocialCard $card
   * @return void
   */
  public function deleted ( iSocialCard $card )
  {

    $hashtag_lookups = $card->hashtag_lookups;
    $social_cards    = $card->social_cards;
    $hashtags        = SocialCardHashtag::where( 'event_instance_id', '=', $card->event_instance_id )->get();

    if( isset( $hashtag_lookups ) )
    {
      foreach( $hashtag_lookups as $lookup )
      {
        $lookup->delete();
      }
    }

    if( isset( $social_cards ) )
    {
      foreach( $social_cards as $lookup )
      {
        $lookup->delete();
      }
    }

    if( isset( $hashtags ) )
    {

      foreach( $hashtags as $hashtag )
      {

        $hashtag_lookups = SocialCardHashtagLookup::
        where( 'event_instance_id', '=', $card->event_instance_id )
        ->where( 'card_id', '=', $card->id )
        ->where( 'hashtag_id', '=', $hashtag->id )
        ->get();

        if( $hashtag_lookups->count() == 0 )
        {
          $hashtag->delete();
        }

      }

    }

    Cache::tags( [ 'SocialCards', $card->event_instance->name ] )->flush();

  }

  /****************************************************************************/

}
