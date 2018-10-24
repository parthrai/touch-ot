<?php

namespace App\Http\Controllers;

use RuntimeException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TraitEventInstanceController;

use App\SocialWallScreenSetting;

class DashboardController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct ()
  {
    $this->middleware( 'auth' );
  }

  /****************************************************************************/

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request, $event_instance_name )
  {
    
    $event_instance  = SocialWallScreenSettingController::GetEventInstanceByName( $event_instance_name );
    $screen_settings = SocialWallScreenSetting::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'id', 'ASC' )
    ->get();

    return(
      view( 'dashboard.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'settings'            => $screen_settings
        ]
      )
    );

  }

  /****************************************************************************/

}
