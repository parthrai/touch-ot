<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

use App\SocialCardConfig;

class SocialCardsConfigController extends Controller
{

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $config = SocialCardConfig::GetConfiguration( $event_instance_name );

    return(
      view( 'social-cards-configs.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'config'              => $config
        ]
      )
    );

  }

  /****************************************************************************/

  public function SetConfigs ( Request $request, $event_instance_name )
  {

    $config                      = SocialCardConfig::GetConfiguration( $event_instance_name );
    $num_fetch_batchsize_tweets  = $request->input( 'num_fetch_batchsize_tweets' );
    $num_display_max_items       = $request->input( 'num_display_max_items' );
    $ratios                      = json_decode( $request->input( 'ratios' ) );
    $num_featured_appworks_posts = $request->input( 'num_featured_appworks_posts' );
    $num_featured_tweets         = $request->input( 'num_featured_tweets' );

    $config->fetch_batchsize_tweets = $num_fetch_batchsize_tweets;
    $config->display_max_items      = $num_display_max_items;

    $appworks_posts_ratio = $ratios->appworks_posts;
    $tweets_ratio         = $ratios->tweets;

    if( ( $appworks_posts_ratio + $tweets_ratio ) == 100 )
    {
      $config->appworks_posts_ratio = $appworks_posts_ratio;
      $config->tweets_ratio         = $tweets_ratio;
    }
    else
    {
      $config->appworks_posts_ratio = 60;
      $config->tweets_ratio         = 40;
    }

    $config->appworks_posts_featured = $num_featured_appworks_posts;
    $config->tweets_featured         = $num_featured_tweets;
    $config->save();

    Cache::tags( [ 'SocialCards', $event_instance_name ] )->flush();

    return(
      back()
      ->with(
        [
          'flash_success' => 'Configuration updated.',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function ResetToDefault ( Request $request, $event_instance_name )
  {

    $config = SocialCardConfig::ResetToDefault( $event_instance_name );

    return(
      back()
      ->with(
        [
          'flash_success' => 'Configuration reset to default settings.',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

}
