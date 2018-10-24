<?php

namespace App\Http\Controllers\TabletTouchScreen;

use Exception;
use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;

use App\Traits\TraitEventInstanceController;

use App\TouchscreenImage;

use App\AgendaScreen;
use App\AgendaAnnouncement;
use App\AgendaScheduleEvent;
use App\AgendaBreakoutSession;

use App\MapScreen;

use App\ExpoMap;
use App\ExpoStand;

use App\EventScreen;

use App\SponsorScreen;

class TabletTouchScreenController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  protected $cache_duration = 1; // Minutes

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance  = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $agenda          = $this->GetAgenda( $request, $event_instance_name );
    $map_screens     = $this->GetMapScreens( $request, $event_instance_name );
    $expo_stands     = $this->GetExpoStands( $request, $event_instance_name );
    $event_screens   = $this->GetEventScreens( $request, $event_instance_name );
    $sponsor_screens = $this->GetSponsorScreens( $request, $event_instance_name );

    return(
      view( "tablet-touch-screen.index" )
      ->with(
        [
          'request'         => $request,
          'event_instance'  => $event_instance,
          'agenda'          => $agenda,
          'map_screens'     => $map_screens,
          'expo_stands'     => $expo_stands,
          'event_screens'   => $event_screens,
          'sponsor_screens' => $sponsor_screens
        ]
      )
    );

  }

  /****************************************************************************/

  public function GetAgendaJson ( Request $request, $event_instance_name )
  {

    $agenda = $this->GetAgenda( $request, $event_instance_name );

    return(
      response()
      ->json( $agenda )
    );

  }

  /****************************************************************************/

  private function GetAgenda ( Request $request, $event_instance_name )
  {

    $event_instance = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $agenda         = null;
    $cache_key      = 'Screens';

    if( Cache::tags( [ 'TsAgenda', $event_instance_name ] )->has( $cache_key ) )
    {
      $agenda = Cache::tags( [ 'TsAgenda', $event_instance_name ] )->get( $cache_key, null );
    }

    $agenda = null; // DEBUGGING

    if( ! isset( $agenda ) )
    {

      $agenda    = [];
      $day_index = 0;
      $screens   = AgendaScreen::with(
        [ 'agenda_announcement', 'touchscreen_image' ]
      )
      ->where(
        [
          [ 'event_instance_id', '=', $event_instance->id ],
          [ 'active', '=', true ]
        ]
      )
      ->orderBy( 'display_order', 'ASC' )
      ->get();

      foreach( $screens as $screen )
      {

        $carb   = new Carbon( $screen->date );
        $struct = [
          'day_index'          => $day_index,
          'vue_id'             => "screen_" . $screen->id,
          'name'               => $screen->name,
          'type'               => $screen->type,
          'date'               => $screen->date,
          'tab_label'          => $screen->tab_label,
          'original_tab_label' => $screen->tab_label,
          'display_order'      => $screen->display_order,
          'date_display'       => $carb->format( 'F j' ),
          'day_of_week'        => $carb->format( 'l' )
        ];

        switch( $screen->type )
        {
          case 'announcement':
            $this->AppendAnnouncement( $event_instance, $struct, $screen );
            break;
          case 'image':
            $this->AppendAppendImage( $event_instance, $struct, $screen );
            break;
          case 'schedule':
            $struct['tab_label'] = $struct['day_of_week'];
            $this->AppendScheduleEvents( $event_instance, $struct, $screen );
            $this->AppendBreakoutSessions( $event_instance, $struct, $screen );
            break;
          default:
            $struct = null;
            break;
        }

        if( isset( $struct ) )
        {
          $agenda[] = $struct;
        }

        $day_index++;

      }

      if( isset( $agenda ) )
      {
        Cache::tags( [ 'TsAgenda', $event_instance_name ] )->put( $cache_key, $agenda, $this->cache_duration );
      }

    }

    return( $agenda );

  }

  /****************************************************************************/

  private function AppendAnnouncement ( $event_instance, &$struct, &$screen )
  {

    if( $screen->agenda_announcement )
    {
      $struct['announcement'] = $screen->agenda_announcement->announcement;
    }
    else
    {
      $struct['announcement'] = null;
    }

  }

  /****************************************************************************/

  private function AppendAppendImage ( $event_instance, &$struct, &$screen )
  {

    $struct['image'] = [];

    foreach( TouchscreenImage::$image_sizes as $image_size )
    {
      if( $screen->touchscreen_image )
      {
        $struct['image'][$image_size] = asset( join( '/', [ 'storage', $screen->touchscreen_image->{$image_size} ] ) );
      }
      else
      {
        $struct['image'][$image_size] = null;
      }
    }

    if( isset( $screen->touchscreen_image ) && ( strlen( $screen->touchscreen_image ) > 0 ) )
    {
      if( $screen->touchscreen_image && $screen->touchscreen_image->link )
      {
        $struct['image']['link'] = $screen->touchscreen_image->link;
      }
      else
      {
        $struct['image']['link'] = null;
      }
    }
    else
    {
      $struct['image']['link'] = null;
    }

  }

  /****************************************************************************/

  private function AppendScheduleEvents ( $event_instance, &$struct, &$screen )
  {

    $struct['schedule'] = [
      'title'  => join( ' ', [ $struct['day_of_week'], 'at a glance' ] ),
      'events' => []
    ];

    $events = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'date', '=', $screen->date ],
        [ 'hidden', '=', false ]
      ]
    )
    ->orderBy( 'time_start', 'ASC' )
    ->orderBy( 'display_order', 'ASC' )
    ->get();

    foreach( $events as $event )
    {

      $carb_time_start = new Carbon( join( ' ', [ $screen->date, $event->time_start ] ) );
      $carb_time_end   = new Carbon( join( ' ', [ $screen->date, $event->time_end ] ) );

      $event_struct = [
        'vue_id'        => "event_" . $event->id,
        'date'          => $event->date,
        'time_start'    => $event->time_start,
        'time_end'      => $event->time_end,
        'time_range'    => join( ' - ', [ $carb_time_start->format('h:i A'), $carb_time_end->format('h:i A') ] ),
        'display_order' => $event->display_order,
        'title'         => $event->title_override,
        'location'      => $event->location_override
      ];

      $struct['schedule']['events'][] = $event_struct;

    }

  }

  /****************************************************************************/

  private function AppendBreakoutSessions ( $event_instance, &$struct, &$screen )
  {

    /** -------------------------------------------------------------------- **/

    $struct['breakout'] = [
      'title'          => join( ' ', [ $struct['day_of_week'], 'breakout sessions' ] ),
      'session_blocks' => []
    ];

    /** GET TIME BLOCKS ---------------------------------------------------- **/

    $breakout_session_blocks = AgendaBreakoutSession::
    select(
      'time_start',
      'time_end'
    )
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->where( 'hidden', '=', false )
    ->whereDate( 'date', $screen->date )
    ->groupBy( 'time_start', 'time_end' )
    ->orderBy( 'time_start', 'ASC' )
    ->get();

    /** -------------------------------------------------------------------- **/

    foreach( $breakout_session_blocks as $breakout_session_block )
    {

      $carb_session_block_start = new Carbon( join( ' ', [ $screen->date, $breakout_session_block->time_start ] ) );
      $carb_session_block_end   = new Carbon( join( ' ', [ $screen->date, $breakout_session_block->time_end ] ) );
      $events                   = [];
      $session_block_struct     = [
        'time_range' => join( ' - ', [ $carb_session_block_start->format('h:i A'), $carb_session_block_end->format('h:i A') ] ),
        'events'     => null
      ];

      $session_block_events = AgendaBreakoutSession::
      where( 'event_instance_id', '=', $event_instance->id )
      ->where( 'hidden', '=', false )
      ->whereDate( 'date', $screen->date )
      ->whereTime( 'time_start', '=', $breakout_session_block->time_start )
      ->whereTime( 'time_end', '=', $breakout_session_block->time_end )
      ->orderBy( 'time_start', 'ASC' )
      ->orderBy( 'display_order', 'ASC' )
      ->get();

      foreach( $session_block_events as $session_block_event )
      {

        array_push(
          $events,
          [
            'vue_id'        => "session_block_event_" . $session_block_event->id,
            'date'          => $screen->date,
            'time_start'    => $session_block_event->time_start,
            'time_end'      => $session_block_event->time_end,
            'display_order' => $session_block_event->display_order,
            'icon'          => $session_block_event->icon,
            'title'         => $session_block_event->title_override,
            'location'      => $session_block_event->location_override
          ]
        );
      }

      $session_block_struct['events'] = $events;

      array_push( $struct['breakout']['session_blocks'], $session_block_struct );

    }

    /** -------------------------------------------------------------------- **/

  }

  /****************************************************************************/

  public function GetMapScreensJson ( Request $request, $event_instance_name )
  {

    $map_screen = $this->GetMapScreens( $request, $event_instance_name );

    return(
      response()
      ->json( $map_screens )
    );

  }

  /****************************************************************************/
  private function GetMapScreens ( Request $request, $event_instance_name )
  {
  
    $event_instance = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $map_screens    = null;
    $cache_key      = 'Screens';

    if( Cache::tags( [ 'TsMap', $event_instance_name ] )->has( $cache_key ) )
    {
      $stands = Cache::tags( [ 'TsMap', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $map_screens ) )
    {

      $map_screens = [];
      $map_index   = 0;
      $screens     = MapScreen::
      with( 'touchscreen_image' )
      ->where(
        [
          [ 'event_instance_id', '=', $event_instance->id ],
          [ 'active', '=', true ]
        ]
      )
      ->orderBy( 'display_order', 'ASC' )
      ->get();

      foreach( $screens as $screen )
      {

        $struct = [
          'map_index'            => $map_index,
          'name'                 => $screen->name,
          'tab_label'            => $screen->tab_label,
          'display_order'        => $screen->display_order,
          'caption'              => $screen->caption,
          'touchscreen_image_id' => $screen->touchscreen_image_id,
          'image_name'           => $screen->touchscreen_image->name,
          'image_lg'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_lg ] ) ),
          'image_md'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_md ] ) ),
          'image_sm'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_sm ] ) ),
          'image_xs'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_xs ] ) )
        ];

        if( isset( $struct ) )
        {
          $map_screens[] = $struct;
        }

        $map_index++;

      }

      if( isset( $map_screens ) )
      {
        Cache::tags( [ 'TsMap', $event_instance_name ] )->put( $cache_key, $map_screens, $this->cache_duration );
      }


    }

    return( $map_screens );

  }

  /****************************************************************************/

  public function GetExpoStandsJson ( Request $request, $event_instance_name )
  {

    $stands = $this->GetExpoStands( $request, $event_instance_name );

    return(
      response()
      ->json( $stands )
    );

  }

  /****************************************************************************/

  private function GetExpoStands ( Request $request, $event_instance_name )
  {

    $event_instance = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $stands         = null;
    $cache_key      = 'Stands';

    if( Cache::tags( [ 'TsExpo', $event_instance_name ] )->has( $cache_key ) )
    {
      $stands = Cache::tags( [ 'TsExpo', $event_instance_name ] )->get( $cache_key, null );
    }

    $stands = null; // DEBUGGING

    if( ! isset( $stands ) )
    {

      $stands      = [];
      $expo_stands = ExpoStand::
      with( 'expo_map' )
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'exhibitor', 'ASC' )
      ->orderBy( 'stand', 'ASC' )
      ->get();

      foreach( $expo_stands as $expo_stand )
      {

        $map_name     = null;
        $map_image_lg = null;
        $map_image_md = null;
        $map_image_sm = null;
        $map_image_xs = null;

        try
        {
          $map_name     = $expo_stand->expo_map->touchscreen_image->name;
          $map_image_lg = asset( join( '/', [ 'storage', $expo_stand->expo_map->touchscreen_image->image_lg ] ) );
          $map_image_md = asset( join( '/', [ 'storage', $expo_stand->expo_map->touchscreen_image->image_md ] ) );
          $map_image_sm = asset( join( '/', [ 'storage', $expo_stand->expo_map->touchscreen_image->image_sm ] ) );
          $map_image_xs = asset( join( '/', [ 'storage', $expo_stand->expo_map->touchscreen_image->image_xs ] ) );
        }
        catch( Exception $ex )
        {
          // NO-OP
        }

        $struct = [
          'expo_level_id' => $expo_stand->expo_level_id,
          'type'          => $expo_stand->expo_level->name,
          'exhibitor'     => $expo_stand->exhibitor,
          'stand'         => $expo_stand->stand,
          'expo_map_id'   => $expo_stand->expo_map_id,
          'position_x'    => $expo_stand->position_x,
          'position_y'    => $expo_stand->position_y,
          'map_name'      => $map_name,
          'map_image_lg'  => $map_image_lg,
          'map_image_md'  => $map_image_md,
          'map_image_sm'  => $map_image_sm,
          'map_image_xs'  => $map_image_xs
        ];

        if( isset( $struct ) )
        {
          $stands[] = $struct;
        }

      }

      if( isset( $stands ) )
      {
        Cache::tags( [ 'TsExpo', $event_instance_name ] )->put( $cache_key, $stands, $this->cache_duration );
      }


    }

    return( $stands );

  }

  /****************************************************************************/

  public function GetEventScreensJson ( Request $request, $event_instance_name )
  {

    $event_screens = $this->GetEventScreens( $request, $event_instance_name );

    return(
      response()
      ->json( $event_screens )
    );

  }

  /****************************************************************************/

  private function GetEventScreens ( Request $request, $event_instance_name )
  {

    $event_instance = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $event_screens  = null;
    $cache_key      = 'Screens';

    if( Cache::tags( [ 'TsEvent', $event_instance_name ] )->has( $cache_key ) )
    {
      $stands = Cache::tags( [ 'TsEvent', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $event_screens ) )
    {

      $event_screens = [];
      $event_index   = 0;
      $screens       = EventScreen::
      with( 'touchscreen_image' )
      ->where(
        [
          [ 'event_instance_id', '=', $event_instance->id ] ,
          [ 'active', '=', true ]
        ]
      )
      ->orderBy( 'display_order', 'ASC' )
      ->get();

      foreach( $screens as $screen )
      {

        $struct = [
          'event_index'          => $event_index,
          'name'                 => $screen->name,
          'tab_label'            => $screen->tab_label,
          'display_order'        => $screen->display_order,
          'touchscreen_image_id' => $screen->touchscreen_image_id,
          'image_name'           => $screen->touchscreen_image->name,
          'image_lg'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_lg ] ) ),
          'image_md'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_md ] ) ),
          'image_sm'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_sm ] ) ),
          'image_xs'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_xs ] ) )
        ];

        if( isset( $struct ) )
        {
          $event_screens[] = $struct;
        }

        $event_index++;

      }

      if( isset( $event_screens ) )
      {
        Cache::tags( [ 'TsEvent', $event_instance_name ] )->put( $cache_key, $event_screens, $this->cache_duration );
      }


    }

    return( $event_screens );

  }

  /****************************************************************************/

  public function GetSponsorScreensJson ( Request $request, $event_instance_name )
  {

    $sponsor_screens = $this->GetSponsorScreens( $request, $event_instance_name );

    return(
      response()
      ->json( $sponsor_screens )
    );

  }

  /****************************************************************************/

  private function GetSponsorScreens ( Request $request, $event_instance_name )
  {

    $event_instance  = TabletTouchScreenController::GetEventInstanceByName( $event_instance_name );
    $sponsor_screens = null;
    $cache_key       = 'Screens';

    if( Cache::tags( [ 'TsSponsor', $event_instance_name ] )->has( $cache_key ) )
    {
      $stands = Cache::tags( [ 'TsSponsor', $event_instance_name ] )->get( $cache_key, null );
    }

    if( ! isset( $sponsor_screens ) )
    {

      $sponsor_screens = [];
      $sponsor_index   = 0;
      $screens         = SponsorScreen::
      with( 'touchscreen_image' )
      ->where(
        [
          [ 'event_instance_id', '=', $event_instance->id ],
          [ 'active', '=', true ]
        ]
      )
      ->orderBy( 'display_order', 'ASC' )
      ->get();

      foreach( $screens as $screen )
      {

        $struct = [
          'sponsor_index'        => $sponsor_index,
          'name'                 => $screen->name,
          'tab_label'            => $screen->tab_label,
          'display_order'        => $screen->display_order,
          'touchscreen_image_id' => $screen->touchscreen_image_id,
          'image_name'           => $screen->touchscreen_image->name,
          'image_lg'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_lg ] ) ),
          'image_md'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_md ] ) ),
          'image_sm'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_sm ] ) ),
          'image_xs'             => asset( join( '/', [ 'storage', $screen->touchscreen_image->image_xs ] ) )
        ];

        if( isset( $struct ) )
        {
          $sponsor_screens[] = $struct;
        }

        $sponsor_index++;

      }

      if( isset( $sponsor_screens ) )
      {
        Cache::tags( [ 'TsSponsor', $event_instance_name ] )->put( $cache_key, $sponsor_screens, $this->cache_duration );
      }

    }

    return( $sponsor_screens );

  }

  /****************************************************************************/

}
