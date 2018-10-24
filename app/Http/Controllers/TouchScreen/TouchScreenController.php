<?php

namespace App\Http\Controllers\TouchScreen;

use Exception;
use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;

class TouchScreenController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchScreenController::GetEventInstanceByName( $event_instance_name );

    return(
      view( "touch-screen.index" )
      ->with(
        [
          'event_instance' => $event_instance,
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function feedbackData(Request $request){

      print_r(
          $request->email
      );
      $name = $request->name;
      $email = $request->email;
      $cmnt  = $request->comment;




  }

}
