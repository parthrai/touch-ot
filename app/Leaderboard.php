<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceModel;

class Leaderboard extends Model
{

  /****************************************************************************/

  use TraitEventInstanceModel;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'name',
    'image_xs',
    'image_sm',
    'image_md',
    'image_lg',
    'display_order'
  ];

  /** CUSTOM ATTRIBUTES *******************************************************/

  public static $image_sizes = [
    'image_lg',
    'image_md',
    'image_sm',
    'image_xs'
  ];

  public static $image_size_codes = [
    'lg',
    'md',
    'sm',
    'xs'
  ];

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

  /****************************************************************************/

  /*
  *   Get list of images orders to use in the competition screens view.
  *
  */
  public static function GetLeaderboardOrders ( $event_instance_name )
  {

    $event_instance = Leaderboard::GetEventInstanceByName( $event_instance_name );
    $image_list     = [];
    $leaderboards   = Leaderboard::where(
      'event_instance_id', '=', $event_instance->id
    )
    ->orderBy( 'display_order', 'ASC' )
    ->get(); 

    foreach( $leaderboards as $leaderboard )
    {
      array_push( $image_list, $leaderboard->display_order );
    }

    return( $image_list );

  }

  /****************************************************************************/

}
