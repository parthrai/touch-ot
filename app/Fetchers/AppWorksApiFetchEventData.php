<?php

namespace App\Fetchers;

use Exception;
use DateTime;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

use App\EventInstance;

use App\Fetchers\AppWorksApiBase;

use App\EventRulesSessionTypeVisibility;
use App\EventRulesSurveySessionType;

use App\AgendaScheduleEvent;
use App\AgendaBreakoutSession;
use App\ExpoMap;
use App\ExpoLevel;
use App\ExpoStand;

class AppWorksApiFetchEventData extends AppWorksApiBase
{

  /****************************************************************************/

  protected $cache_duration = 15; // Minutes
  protected $cache_key_tag  = "AppWorksApiEventData";

  /****************************************************************************/

  /**
   * Download the events feed from the AppWorks API.
   *
   * @return void
   */
  public function FetchEvents ( String $otag_token )
  {

    $event_instances = EventInstance::where( 'name', '!=', 'default' )->get();

    foreach( $event_instances as $event_instance )
    {

      $package = $this->FetchPackage( $otag_token, $event_instance );

      if( isset( $package ) )
      {

        if( $this->ProcessEventRules( $package, $event_instance ) )
        {

          if( $this->show_output ) echo( "ProcessEventRules OK\n" );

          if( $this->ProcessAgenda( $package, $event_instance ) )
          {
            if( $this->show_output ) echo( "ProcessAgenda OK\n" );
          }
          else
          {
            if( $this->show_output ) echo( "ProcessAgenda failed.\n" );
          }

        }
        else
        {
          if( $this->show_output ) echo( "ProcessEventRules failed\n" );
        }

        if( $this->ProcessExhibitorLevels( $package, $event_instance ) )
        {

          if( $this->show_output ) echo( "ProcessExhibitorCategories OK\n" );

          if( $this->ProcessExhibitors( $package, $event_instance ) )
          {
            if( $this->show_output ) echo( "ProcessExhibitors OK\n" );
          }
          else
          {
            if( $this->show_output ) echo( "ProcessExhibitors failed.\n" );
          }

        }
        else
        {
          if( $this->show_output ) echo( "ProcessExhibitorCategories failed.\n" );
        }

      }
      else
      {
        if( $this->show_output ) echo( "FetchPackage failed.\n" );
      }

    }

  }

  /****************************************************************************/

  /**
   * Download the feed package.
   *
   * @return JSON
   */
  public function FetchPackage ( String $otag_token, $event_instance )
  {

    $http      = new Client();
    $package   = null;
    $cache_key = 'PACKAGE';
    $json      = null;

    if( Cache::tags( [ $this->cache_key_tag, $event_instance ] )->has( $cache_key ) )
    {
      $json = Cache::tags( [ $this->cache_key_tag, $event_instance ] )->get( $cache_key, null );
    }

    if( ! isset( $json ) )
    {

      if( $this->show_output ) echo( "Fetching Package\n" );

      try
      {

        $response = $http->request(
          'GET',
          'https://appworks.opentext.com/appworks-conference-service/api/v2/conference',
          [
            'verify'      => false,
            'http_errors' => false,
            'headers'     => [
              'Content-Type'       => 'application/json',
              'Accept'             => 'application/json',
              'otagToken'          =>  $otag_token,
              'AW_EVENTS_EVENT_ID' => $event_instance->event_uuid
            ],
          ]
        );

        $json = (string) $response->getBody();

        if( isset( $json ) )
        {
          Cache::tags( [ $this->cache_key_tag, $event_instance ] )->put( $cache_key, $json, $this->cache_duration );
        }
  
      }
      catch( Exception $ex )
      {
        $package = null;
      }

    }
    else
    {
      if( $this->show_output ) echo( "Using Cached Package\n" );
    }

    $package = json_decode( $json, false );

    return( $package );

  }

  /****************************************************************************/

  /**
   * Process Events Rules.
   *
   * @return Bool
   */
  public function ProcessEventRules ( &$package, $event_instance )
  {
    if( isset( $package ) )
    {
      try
      {
        $this->ProcessEventRulesSessionTypeVisibility( $package, $event_instance );
        $this->ProcessEventRulesSurveySessionType( $package, $event_instance );
      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }
    }
    return( true );
  }

  /****************************************************************************/

  /**
   * Process Events Rules for Session Type Visibility.
   *
   * @return Bool
   */
  private function ProcessEventRulesSessionTypeVisibility ( &$package, $event_instance )
  {

    $success          = false;
    $hard_coded_types = [
      'conference'
    ];

    $callback = function( $event_rule_uuid, $event_rule, $hard_coded, $fetch_batch ) use ( $event_instance )
    {

      $rule = EventRulesSessionTypeVisibility::firstOrNew( [ 'event_rule_uuid' => $event_rule_uuid ] );
      $rule->SetEventInstance( $event_instance );
      $rule->event_rule_uuid = $event_rule_uuid;
      $rule->name            = $event_rule->name;
      $rule->enabled         = $event_rule->enabled;
      $rule->external        = $event_rule->external;
      $rule->hard_coded      = $hard_coded;
      $rule->fetch_batch     = $fetch_batch;
      $rule->save();

    };

    $success = $this->ProcessEventRulesSessionTypeVisibilitySet( $package, $callback, $hard_coded_types );

    return( $success );

  }

  /****************************************************************************/

  /**
   * Process Session Type Visibility set.
   *
   * @return Bool
   */
  private function ProcessEventRulesSessionTypeVisibilitySet ( &$package, $callback, &$hard_coded_types )
  {

    $success     = false;
    $fetch_batch = EventRulesSessionTypeVisibility::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    if( $this->show_output ) echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    try
    {

      /** BEGIN: Automatically Configured Event Rules ---------------------- **/
      foreach( $package->eventRules->sessionTypeVisibility as $event_rule_uuid => $event_rule_list )
      {
        if( $this->show_output ) echo( "\t" . "EVENT_RULE_UUID: " . $event_rule_uuid . "\n" );
        foreach( $package->dynamicCategories as $dynamic_category )
        {
          if( strtolower( $dynamic_category->categoryNameTranslations->EN ) == strtolower( "Session Type" ) )
          {
            if( $this->show_output ) echo( "\t\t" . "DYNAMIC_CATEGORY: " . $dynamic_category->uuid . "\n" );
            foreach( $dynamic_category->categoryEntries as $event_rule )
            {
              if( $event_rule->uuid == $event_rule_uuid )
              {
                if( $this->show_output ) echo( "\t\t\t" . "EVENT RULE: " . $event_rule->name . "\n" );
                $callback( $event_rule_uuid, $event_rule, false, $fetch_batch );
              }
            }
          }
        }
      }
      /** END: Automatically Configured Event Rules ------------------------ **/

      /** BEGIN: Hard-Coded Event Rules ------------------------------------ **/
      foreach( $hard_coded_types as $event_rule_name )
      {
        if( $this->show_output ) echo( "\t" . "HC :: EVENT_RULE_NAME: " . $event_rule_name . "\n" );
        foreach( $package->dynamicCategories as $dynamic_category )
        {
          if( strtolower( $dynamic_category->categoryNameTranslations->EN ) == strtolower( "Session Type" ) )
          {
            if( $this->show_output ) echo( "\t\t" . "HC :: DYNAMIC_CATEGORY: " . $dynamic_category->uuid . "\n" );
            foreach( $dynamic_category->categoryEntries as $event_rule )
            {
              if( strtolower( $event_rule->name ) == strtolower( $event_rule_name ) )
              {
                if( $this->show_output ) echo( "\t\t\t" . "HC :: EVENT RULE: " . $event_rule->name . "\n" );
                $callback( $event_rule->uuid, $event_rule, true, $fetch_batch );
              }
            }
          }
        }
      }
      /** END: Hard-Coded Event Rules -------------------------------------- **/

      EventRulesSessionTypeVisibility::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();

      $success = true;

    }
    catch( Exception $ex )
    {
      echo( "ERROR: ProcessEventRulesSessionTypeVisibilitySet\n" );
      echo( $ex->getMessage() . "\n" );
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Process Events Rules for Survey Session Type.
   *
   * @return Bool
   */
  private function ProcessEventRulesSurveySessionType ( &$package, $event_instance )
  {

    $success = false;

    $callback = function( $event_rule_uuid, $event_rule, $fetch_batch ) use ( $event_instance )
    {

      $rule = EventRulesSurveySessionType::firstOrNew( [ 'event_rule_uuid' => $event_rule_uuid ] );
      $rule->SetEventInstance( $event_instance );
      $rule->event_rule_uuid = $event_rule_uuid;
      $rule->name            = $event_rule->name;
      $rule->enabled         = $event_rule->enabled;
      $rule->external        = $event_rule->external;
      $rule->hard_coded      = false;
      $rule->fetch_batch     = $fetch_batch;
      $rule->save();

    };

    $success = $this->ProcessEventRulesSurveySessionTypeSet( $package, $callback );

    return( $success );

  }

  /****************************************************************************/

  /**
   * Process Survey Session Type set.
   *
   * @return Bool
   */
  private function ProcessEventRulesSurveySessionTypeSet ( &$package, $callback )
  {

    $success     = false;
    $fetch_batch = EventRulesSurveySessionType::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    if( $this->show_output ) echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    try
    {

      foreach( $package->eventRules->surveySessionTypes as $event_rule_uuid )
      {
        if( $this->show_output ) echo( "\t" . "EVENT_RULE_UUID: " . $event_rule_uuid . "\n" );
        foreach( $package->dynamicCategories as $dynamic_category )
        {
          if( strtolower( $dynamic_category->categoryNameTranslations->EN ) == strtolower( "Session Type" ) )
          {
            if( $this->show_output ) echo( "\t\t" . "DYNAMIC_CATEGORY: " . $dynamic_category->uuid . "\n" );
            foreach( $dynamic_category->categoryEntries as $event_rule )
            {
              if( $event_rule->uuid == $event_rule_uuid )
              {
                if( $event_rule->external == false )
                {
                  if( $this->show_output ) echo( "\t\t\t" . "EVENT RULE: " . $event_rule->name . "\n" );
                  $callback( $event_rule_uuid, $event_rule, $fetch_batch );
                }
              }
            }
          }
        }

      }

      EventRulesSurveySessionType::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();

      $success = true;

    }
    catch( Exception $ex )
    {
      echo( "ERROR: ProcessEventRulesSurveySessionTypeSet\n" );
      echo( $ex->getMessage() . "\n" );
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Download and process the Agenda feed.
   *
   * @return Bool
   */
  public function ProcessAgenda ( &$package, $event_instance )
  {
    if( isset( $package ) )
    {
      try
      {
        $this->ProcessScheduleEvents( $package, $event_instance );
        $this->ProcessBreakoutSessions( $package, $event_instance );
      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }
    }
    return( true );
  }

  /****************************************************************************/

  /**
   * Process Schedule Events.
   *
   * @return Bool
   */
  private function ProcessScheduleEvents ( &$package, $event_instance )
  {

    $success            = false;
    $fetch_batch        = AgendaScheduleEvent::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );
    $session_type_uuids = [];
    $session_types      = EventRulesSessionTypeVisibility::
    where( 'event_instance_id', '=', $event_instance->id )
    ->where( 'enabled', '=', true )
    ->get();

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    foreach( $session_types as $session_type )
    {
      $session_type_uuids[$session_type->event_rule_uuid] = $session_type->enabled;
    }

    $callback = function( $day_date, $session, $display_order ) use ( $event_instance, $fetch_batch )
    {

      $event = AgendaScheduleEvent::firstOrNew( [ 'session_id' => $session->id->dataId ] );
      $event->SetEventInstance( $event_instance );
      $event->session_id     = $session->id->dataId;
      $event->date           = $day_date;
      $event->time_start     = gmdate( "Y-m-d H:i:s", ( $session->startTime / 1000 ) );
      $event->time_end       = gmdate( "Y-m-d H:i:s", ( $session->endTime / 1000 ) );
      $event->display_order  = $display_order;
      $event->title          = $session->title;
      $event->description    = $session->description;
      $event->location       = $session->location;
      $event->fetch_batch    = $fetch_batch;
      $event->save();

    };

    $success = $this->ProcessSessionSet( $package, $session_type_uuids, $callback );

    if( $success )
    {
      AgendaScheduleEvent::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Process Breakout Sessions.
   *
   * @return Bool
   */
  private function ProcessBreakoutSessions ( &$package, $event_instance )
  {

    $success            = false;
    $fetch_batch        = AgendaBreakoutSession::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );
    $session_type_uuids = [];
    $session_types      = EventRulesSurveySessionType::
    where( 'event_instance_id', '=', $event_instance->id )
    ->where( 'enabled', '=', true )
    ->get();

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    foreach( $session_types as $session_type )
    {
      $session_type_uuids[$session_type->event_rule_uuid] = $session_type->enabled;
    }

    $callback = function( $day_date, $session, $display_order ) use ( $event_instance, $fetch_batch )
    {
      
      $event = AgendaBreakoutSession::firstOrNew( [ 'session_id' => $session->id->dataId ] );
      $event->SetEventInstance( $event_instance );
      $event->session_id    = $session->id->dataId;
      $event->date          = $day_date;
      $event->time_start    = gmdate( "Y-m-d H:i:s", ( $session->startTime / 1000 ) );
      $event->time_end      = gmdate( "Y-m-d H:i:s", ( $session->endTime / 1000 ) );
      $event->display_order = $display_order;
      $event->icon          = null;
      $event->title         = $session->title;
      $event->description   = $session->description;
      $event->location      = $session->location;
      $event->fetch_batch   = $fetch_batch;
      $event->save();

    };

    $success = $this->ProcessSessionSet( $package, $session_type_uuids, $callback );

    if( $success )
    {
      AgendaBreakoutSession::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Process Session Set.
   *
   * @return Bool
   */
  private function ProcessSessionSet ( &$package, &$session_type_uuids, $callback )
  {

    $success = false;

    try
    {

      foreach( $package->conferenceDays as $day )
      {

        $day_date = gmdate( "Y-m-d H:i:s", ( $day->date / 1000 ) );

        echo( $day->day . ': ' . $day_date . "\n" );
        $display_order = 1;

        foreach( $day->sessions as $session )
        {

          $proceed = false;

          foreach( $session->sessionTypeUuids as $session_type_uuid )
          {
            if( array_key_exists( $session_type_uuid, $session_type_uuids ) )
            {
              echo( "\t" . $session_type_uuid . ":\t" . $session->title . "\n" );
              $proceed = true;
              break;
            }
          }

          if( $proceed == true )
          {
            $callback( $day_date, $session, $display_order );
            $display_order++;
          }

        }
    
      }

      $success = true;

    }
    catch( Exception $ex )
    {
      echo( "ERROR: ProcessSessionSet\n" );
      echo( $ex->getMessage() . "\n" );
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Download and process the Exhibitor Levels.
   *
   * @return Bool
   */
  public function ProcessExhibitorLevels ( &$package, $event_instance )
  {

    $success = false;

    if( isset( $package ) )
    {
      try
      {

        $callback = function( $category_entry, $fetch_batch ) use ( $event_instance )
        {
          
          $expo_level = ExpoLevel::firstOrNew( [ 'expo_level_id' => $category_entry->uuid ] );
          $expo_level->SetEventInstance( $event_instance );
          $expo_level->expo_level_id = $category_entry->uuid;
          $expo_level->name          = $category_entry->name;
          $expo_level->fetch_batch   = $fetch_batch;
          $expo_level->save();

        };
    
        $success = $this->ProcessExhibitorLevelSet( $package, $callback );

      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }
    }
    return( $success );
  }

  /****************************************************************************/

  /**
   * Process Exhibitor Level 
   * Set.
   *
   * @return Bool
   */
  private function ProcessExhibitorLevelSet ( &$package, $callback )
  {

    $success     = false;
    $fetch_batch = ExpoLevel::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    try
    {

      foreach( $package->dynamicCategories as $dynamic_category )
      {

        $dynamic_category_type = $dynamic_category->categoryNameTranslations->EN;

        if( strtolower( $dynamic_category_type ) == strtolower( "Exhibitor Level" ) )
        {
          foreach( $dynamic_category->categoryEntries as $category_entry )
          {
            echo( $category_entry->name . "\n" );
            $callback( $category_entry, $fetch_batch );
          }
        }

      }

      ExpoLevel::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();

      $success = true;

    }
    catch( Exception $ex )
    {
      echo( "ERROR: ProcessExhibitorLevelSet\n" );
      echo( $ex->getMessage() . "\n" );
    }

    return( $success );

  }

  /****************************************************************************/

  /**
   * Download and process the Agenda feed.
   *
   * @return Bool
   */
  public function ProcessExhibitors ( &$package, $event_instance )
  {

    $success        = false;
    $default_map_id = ExpoMap::where( 'default', '=', true )->value('id');

    if( isset( $package ) )
    {

      try
      {

        $callback = function( $exhibitor, $fetch_batch ) use( $event_instance, $default_map_id )
        {

          $expo_level_id = ExpoLevel::where( 'expo_level_id', '=', $exhibitor->exhibitorLevelUuid )->value('id');
          $expo_stand    = ExpoStand::firstOrNew( [ 'stand_id' => $exhibitor->dataId ] );

          $expo_stand->SetEventInstance( $event_instance );

          if( ! isset( $expo_stand->hidden ) )
          {
            $expo_stand->hidden = false;
          }

          $expo_stand->exhibitor = $exhibitor->boothName;
          $expo_stand->stand     = $exhibitor->boothNumber;

          if( ! isset( $expo_stand->expo_map_id ) )
          {
            $expo_stand->expo_map_id = $default_map_id;
          }

          $expo_stand->expo_level_id = $expo_level_id;
          $expo_stand->fetch_batch   = $fetch_batch;

          $expo_stand->save();

        };
    
        $success = $this->ProcessExhibitorSet( $package, $callback );

      }
      catch( Exception $ex )
      {
        if( $this->show_output ) echo( $ex->getMessage() . "\n" );
      }

    }
    return( $success );
  }

  /****************************************************************************/

  /**
   * Process Exhibitor Set.
   *
   * @return Bool
   */
  private function ProcessExhibitorSet ( &$package, $callback )
  {

    $success     = false;
    $fetch_batch = ExpoStand::whereNotNull( 'fetch_batch' )->max( 'fetch_batch' );

    if( ! isset( $fetch_batch ) )
    {
      $fetch_batch = 1;
    }
    else
    {
      $fetch_batch++;
    }

    echo( "FETCH BATCH: " . $fetch_batch . "\n" );

    try
    {

      foreach( $package->exhibitors as $exhibitor )
      {
        $callback( $exhibitor, $fetch_batch );
      }

      ExpoStand::
      whereNotNull( 'fetch_batch' )
      ->where( 'fetch_batch', '<', $fetch_batch )
      ->delete();

      $success = true;

    }
    catch( Exception $ex )
    {
      echo( "ERROR: ProcessExhibitorSet\n" );
      echo( $ex->getMessage() . "\n" );
    }

    return( $success );

  }

  /****************************************************************************/

}
