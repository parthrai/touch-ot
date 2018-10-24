<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;

class SocialCardLookup extends Model
{

  /****************************************************************************/

  //use SoftDeletes;

  use Sortable;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_instance_id',
    'social_card_id',
    'social_card_type',
    'approved',
    'featured'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'approved' => 'boolean',
    'featured' => 'boolean'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /****************************************************************************/

  public $sortable = [
    'social_card_id',
    'social_card_type',
    'approved',
    'featured'
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

  /** ---------------------------------------------------------------------- **/

  public function social_card ()
  {
    return( $this->morphTo() );
  }

  /** ---------------------------------------------------------------------- **/

  public function hashtags ()
  {
    return(
      $this->hasManyThrough(
        'App\SocialCardHashtag',
        'App\SocialCardHashtagLookup',
        'hashtag_id',
        'id'
      )
    );
  }

  /** MUTATORS ****************************************************************/

  // NONE

  /****************************************************************************/

  public function AddHashtags ( $tags )
  {

    foreach( $tags as $tag )
    {

      $hashtag = SocialCardHashtag::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'hashtag_text', '=', $tag ]
        ]
      )->first();

      if( ! isset( $hashtag ) )
      {
        $hashtag                    = new SocialCardHashtag();
        $hashtag->event_instance_id = $this->event_instance_id;
        $hashtag->hashtag_text      = $tag;
        $hashtag->save();
      }

      $card_hashtag = SocialCardHashtagLookup::where(
        [
          [ 'event_instance_id', '=', $this->event_instance_id ],
          [ 'card_id', '=', $this->id ],
          [ 'hashtag_id', '=', $hashtag->id ]
        ]
      )
      ->first();

      if( ! isset( $card_hashtag ) )
      {
        $card_hashtag                    = new SocialCardHashtagLookup();
        $card_hashtag->event_instance_id = $this->event_instance_id;
        $card_hashtag->card_id           = $this->id;
        $card_hashtag->hashtag_id        = $hashtag->id;
        $card_hashtag->save();
      }

    }

  }

  /****************************************************************************/

}
