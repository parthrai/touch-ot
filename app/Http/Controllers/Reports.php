<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\PointsController;

use App\Point;
use App\Tweets;
use App\TweetTags;
use App\User;


class Reports extends Controller
{

  /****************************************************************************/

  public function index ( Request $request )
  {

    $points = PointsController::report();

    //$tweets = Tweets::all();
    // $points = json_decode($points);
    //$overallScores  = $points->overallScores;

    return(
      view( 'reports.reports' )
      ->with(
        [ 'points' => $points ]
      )
    );

  }

  /****************************************************************************/

}
