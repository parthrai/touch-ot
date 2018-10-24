<?php

namespace App\Http\Controllers\SocialWall;

use Exception;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;

use App\Leaderboard;
use App\SocialWallScreenSetting;

class LeaderboardController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function GetLeaderboards ( Request $request, $event_instance_name )
  {

    $event_instance = LeaderboardController::GetEventInstanceByName( $event_instance_name );
    $leaderboards   = Leaderboard::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'display_order', 'asc' )
    ->get(); 

    if( isset( $leaderboards ) )
    {
      foreach( $leaderboards as $leaderboard )
      {
        foreach( Leaderboard::$image_sizes as $image_size )
        {
          $leaderboard->{$image_size} = asset( Storage::url( $leaderboard->{$image_size} ) );
        }
      }
    }
    else
    {
      $leaderboards = [];
    }

    return(
      response()
      ->json( $leaderboards )
      ->header( 'Access-Control-Allow-Origin:', '*' )
    );

  }

  /****************************************************************************/

}
