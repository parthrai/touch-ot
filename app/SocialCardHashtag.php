<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\SocialCardHashtagLookup;
use App\SocialCardLookup;

class SocialCardHashtag extends Model
{

  /****************************************************************************/

  //use SoftDeletes;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'hashtag_text'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

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

  /** ---------------------------------------------------------------------- **/

  public function hashtag_lookup ()
  {
    return( $this->belongsTo( 'App\SocialCardHashtagLookup' ) );
  }

  /** MUTATORS ****************************************************************/

  public function setHashtagTextAttribute ( $value )
  {
    $this->attributes['hashtag_text'] = strtolower( $value );
  }

  /****************************************************************************/

}
