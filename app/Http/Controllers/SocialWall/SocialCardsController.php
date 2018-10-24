<?php

namespace App\Http\Controllers\SocialWall;

use Twitter;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

use App\Traits\TraitEventInstanceController;

use App\SocialCardConfig;
use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\SocialCardLookup;
use App\SocialCardTweet;
use App\SocialCardPost;

class SocialCardsController extends Controller
{

  /****************************************************************************/

  # https://github.com/thujohn/twitter
  # https://packagist.org/packages/thujohn/twitter

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  private $cache_duration = 1;

  /****************************************************************************/

  /**
  * Get some Social Card items.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetCards ( Request $request, $event_instance_name )
  {

    $event_instance = SocialCardsController::GetEventInstanceByName( $event_instance_name );

    $deck = [
      'delete_cards' => null,
      'remove_cards' => null,
      'add_cards'    => null
    ];

    $delete_cards  = [];
    $remove_cards  = [];
    $max_items     = intval( $request->input( 'max_items' ) );
    $current_cards = $request->input( 'current_cards' );
    $ignore_cache  = false;

    $this->CompileAppworksPostCardsToRemove( $event_instance, $current_cards, $delete_cards, $remove_cards );
    $this->CompileTweetCardsToRemove( $event_instance, $current_cards, $delete_cards, $remove_cards );

    if( count( $remove_cards ) > 0 )
    {
      $ignore_cache = true;
    }

    $deck['delete_cards'] = $delete_cards;
    $deck['remove_cards'] = $remove_cards;
    $deck['add_cards']    = $this->CompileCardsToAdd( $event_instance, $max_items, $ignore_cache );

    return(
      response()
      ->json( $deck )
    );

  }

  /****************************************************************************/

  /**
  * Compile list of Appworks Posts Social Cards to remove from UI.
  *
  * @return void
  */
  private function CompileAppworksPostCardsToRemove ( $event_instance, $current_cards = null, &$delete_cards, &$remove_cards )
  {

    $card_ids = [];

    /** BEGIN: REMOVE NORMAL CARDS ----------------------------------------- **/

    foreach( $current_cards['cards'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'appworks_post':
          array_push( $card_ids, $card['id'] );
          break;
        default:
          break;
      }
    }

    foreach( $current_cards['cards_featured'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'appworks_post':
          array_push( $card_ids, $card['id'] );
          break;
        default:
          break;
      }
    }

    $unapproved_cards = SocialCardLookup::
    whereIn( 'social_card_id', $card_ids )
    ->where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'social_card_type', '=', SocialCardPost::class ],
        [ 'approved', '=', 0 ]
      ]
    )
    ->get();

    foreach( $unapproved_cards as $unapproved_card )
    {
      array_push( $remove_cards, $unapproved_card->social_card );
    }

    /** END: REMOVE NORMAL CARDS ------------------------------------------- **/

    /** BEGIN: REMOVE FEATURED CARDS --------------------------------------- **/

    foreach( $current_cards['cards_featured'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'appworks_post':
          $unfeatured_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardPost::class ],
              [ 'featured', '=', 0 ]
            ]
          )
          ->first();
          if( isset( $unfeatured_card ) )
          {
            array_push( $remove_cards, $unfeatured_card->social_card );
          }
          break;
        default:
          break;
      }
    }

    /** END: REMOVE FEATURED CARDS ----------------------------------------- **/

    /** BEGIN: REMOVE NORMAL CARDS THAT ARE NOW FEATURED CARDS ------------- **/

    foreach( $current_cards['cards'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'appworks_post':
          $featured_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardPost::class ],
              [ 'featured', '=', 1 ]
            ]
          )
          ->first();
          if( isset( $featured_card ) )
          {
            array_push( $remove_cards, $featured_card->social_card );
          }
          break;
        default:
          break;
      }
    }

    /** END: REMOVE NORMAL CARDS THAT ARE NOW FEATURED CARDS --------------- **/

    /** BEGIN: REMOVE DELETED CARDS ---------------------------------------- **/
    $merged_cards = array_merge( $current_cards['cards'], $current_cards['cards_featured'] );
    foreach( $merged_cards as $card )
    {
      switch( $card['card_type'] )
      {
        case 'appworks_post':
          $deleted_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardPost::class ]
            ]
          )
          ->first();
          if( ! isset( $deleted_card ) )
          {
            array_push( $delete_cards, $card['card_vue_id'] );
          }
          break;
        default:
          break;
      }
    }
    /** END: REMOVE DELETED CARDS ------------------------------------------ **/

  }

  /****************************************************************************/

  /**
  * Compile list of Tweet Social Cards to remove from UI.
  *
  * @return void
  */
  private function CompileTweetCardsToRemove ( $event_instance, $current_cards = null, &$delete_cards, &$remove_cards )
  {

    $card_ids = [];

    /** BEGIN: REMOVE NORMAL CARDS ----------------------------------------- **/

    foreach( $current_cards['cards'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'tweet':
          array_push( $card_ids, $card['id'] );
          break;
        default:
          break;
      }
    }

    foreach( $current_cards['cards_featured'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'tweet':
          array_push( $card_ids, $card['id'] );
          break;
        default:
          break;
      }
    }

    $unapproved_cards = SocialCardLookup::
    whereIn( 'social_card_id', $card_ids )
    ->where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'social_card_type', '=', SocialCardTweet::class ],
        [ 'approved', '=', 0 ]
      ]
    )
    ->get();

    foreach( $unapproved_cards as $unapproved_card )
    {
      array_push( $remove_cards, $unapproved_card->social_card );
    }

    /** END: REMOVE NORMAL CARDS ------------------------------------------- **/

    /** BEGIN: REMOVE FEATURED CARDS --------------------------------------- **/

    foreach( $current_cards['cards_featured'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'tweet':
          $unfeatured_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardTweet::class ],
              [ 'featured', '=', 0 ]
            ]
          )
          ->first();
          if( isset( $unfeatured_card ) )
          {
            array_push( $remove_cards, $unfeatured_card->social_card );
          }
          break;
        default:
          break;
      }
    }

    /** END: REMOVE FEATURED CARDS ----------------------------------------- **/

    /** BEGIN: REMOVE NORMAL CARDS THAT ARE NOW FEATURED CARDS ------------- **/

    foreach( $current_cards['cards'] as $card )
    {
      switch( $card['card_type'] )
      {
        case 'tweet':
          $featured_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardTweet::class ],
              [ 'featured', '=', 1 ]
            ]
          )
          ->first();
          if( isset( $featured_card ) )
          {
            array_push( $remove_cards, $featured_card->social_card );
          }
          break;
        default:
          break;
      }
    }

    /** END: REMOVE NORMAL CARDS THAT ARE NOW FEATURED CARDS --------------- **/

    /** BEGIN: REMOVE DELETED CARDS ---------------------------------------- **/
    $merged_cards = array_merge( $current_cards['cards'], $current_cards['cards_featured'] );
    foreach( $merged_cards as $card )
    {
      switch( $card['card_type'] )
      {
        case 'tweet':
          $deleted_card = SocialCardLookup::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'social_card_id', '=', $card['id'] ],
              [ 'social_card_type', '=', SocialCardTweet::class ]
            ]
          )
          ->first();
          if( ! isset( $deleted_card ) )
          {
            array_push( $delete_cards, $card['card_vue_id'] );
          }
          break;
        default:
          break;
      }
    }
    /** END: REMOVE DELETED CARDS ------------------------------------------ **/

  }

  /****************************************************************************/

  /**
  * Compile list of Social Card to add.
  *
  * @return Array
  */
  private function CompileCardsToAdd ( $event_instance, $max_items = 25, $ignore_cache = false )
  {

    $cards              = null;
    $cache_key          = null;
    $social_card_config = SocialCardConfig::GetConfiguration( $event_instance->name );

    $ratios = [
      SocialCardPost::class  => $social_card_config->appworks_posts_ratio,
      SocialCardTweet::class => $social_card_config->tweets_ratio
    ];

    $featured_ratios = [
      SocialCardPost::class  => $social_card_config->appworks_posts_featured,
      SocialCardTweet::class => $social_card_config->tweets_featured,
    ];

    $featured_count = [
      SocialCardPost::class  => 0,
      SocialCardTweet::class => 0
    ];

    if( ! isset( $max_items ) )
    {
      $max_items = 25;
    }

    $cache_key = 'GetCards:' . $max_items;

    if( Cache::tags( [ 'SocialCards', $event_instance->name ] )->has( $cache_key ) )
    {
      $cards = Cache::tags( [ 'SocialCards', $event_instance->name ] )->get( $cache_key, null );
      if( isset( $cards ) )
      {
        if( count( $cards ) <= 0 )
        {
          $cards = null;
          Cache::tags( [ 'SocialCards', $event_instance->name ] )->forget( $cache_key );
        }
      }
    }

    if( $ignore_cache == true )
    {
      $cards = null;
    }

    if( ! isset( $cards ) )
    {

      $cards          = array();
      $cards_list     = [];
      $cards_featured = [];

      /** Collect Featured Cards ------------------------------------------- **/

      foreach( $featured_ratios as $card_type => $featured_limit )
      {

        $lookup_featured_cards = SocialCardLookup::
        with( 'hashtags', 'social_card' )
        ->where(
          [
            [ 'event_instance_id', '=', $event_instance->id ],
            [ 'approved', '=', true ],
            [ 'featured', '=', true ],
            [ 'social_card_type', '=', $card_type ]
          ]
        )
        ->orderBy( 'created_at', 'desc' )
        ->limit( $featured_limit )
        ->get();

        foreach ( $lookup_featured_cards as $lookup_card )
        {
          if( isset( $lookup_card->social_card ) )
          {
            array_push( $cards_featured, $lookup_card->social_card );
            $featured_count[ get_class( $lookup_card->social_card ) ]++;
          }
        }
      
      }

      /** Collect Posts and Tweet Cards ------------------------------------ **/

      foreach( $ratios as $card_type => $ratio )
      {
        
        $limit = intval( ( $max_items / 100 ) * $ratio ) - $featured_count[$card_type];

        if( $limit < 1 )
        {
          $limit = 1;
        }

        $lookup_cards = SocialCardLookup::
        with( 'hashtags', 'social_card' )
        ->where(
          [
            [ 'event_instance_id', '=', $event_instance->id ],
            [ 'approved', '=', true ],
            [ 'featured', '=', false ],
            [ 'social_card_type', '=', $card_type ]
          ]
        )
        ->orderBy( 'created_at', 'desc' )
        ->limit( $limit )
        ->get();

        foreach ( $lookup_cards as $lookup_card )
        {
          if( isset( $lookup_card->social_card ) )
          {
            array_push( $cards_list, $lookup_card->social_card );
          }
        }

      }

      /** Sort Cards ------------------------------------------------------- **/

      $cards_unsorted = collect( $cards_list );
      $cards_sorted   = $cards_unsorted->sortByDesc( 'card_created_at' );

      foreach( $cards_sorted as $card_key => $card_sorted )
      {
        array_push( $cards, $card_sorted );
      }

      /** Add Featured Cards ----------------------------------------------- **/

      foreach( $cards_featured as $card_key => $card_sorted )
      {
        array_unshift( $cards, $card_sorted );
      }

      /** Cache Cards ------------------------------------------------------ **/

      if( isset( $cards ) )
      {
        Cache::tags( [ 'SocialCards', $event_instance->name ] )->put( $cache_key, $cards, $this->cache_duration );
      }

    }

    return( $cards );

  }

  /****************************************************************************/

}
