<?php

namespace App\Http\Controllers\SocialWall;

use Auth;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;
use App\Announcement;

class AnnouncementsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
  * Get the most recent active announcement.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetAnnouncement ( Request $request, $event_instance_name )
  {

    $event_instance = AnnouncementsController::GetEventInstanceByName( $event_instance_name );
    $announcement   = Announcement::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'active', '=', true ]
      ]
    )
    ->latest()
    ->first();

    return(
      response()
      ->json( $announcement )
    );

  }

  /****************************************************************************/

}
