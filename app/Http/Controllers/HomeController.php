<?php

namespace App\Http\Controllers;

use RuntimeException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\EventInstance;

class HomeController extends Controller
{

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
  public function index ( Request $request )
  {
    
    $query_string    = $request->input('q');
    $event_instances = null;

    if( isset( $query_string ) && ( strlen( $query_string ) > 0 ) )
    {

      $event_instances = EventInstance::
      sortable()
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->orWhere( 'event_uuid', 'RLIKE', $query_string )
          ->orWhere( 'name', 'RLIKE', $query_string )
          ->orWhere( 'display_name', 'RLIKE', $query_string )
          ->orWhere( 'timezone', 'RLIKE', $query_string );
        }
      )
      ->orderBy( 'date_start', 'DESC' )
      ->paginate( 10 );

      $event_instances->appends( [ 'q' => $query_string ] );

    }
    else
    {

      $event_instances = EventInstance::
      sortable()
      ->orderBy( 'date_start', 'DESC' )
      ->paginate( 10 );

    }

    return(
      view( 'home.index' )
      ->with(
        [
          'event_instances' => $event_instances,
          'request'         => $request
        ]
      )
    );

  }

  /****************************************************************************/

}
