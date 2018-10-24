<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*******************************************************************************

Look in:

  app\Providers\RouteServiceProvider::boot()
  
...for route parameter constraints.

*******************************************************************************/

/** BEGIN: CODE FINGERPRINT ROUTES ********************************************/

// /api/code-fingerprint/poke
Route::group(
  [
    'middleware' => [],
    'prefix'     => 'code-fingerprint'
  ],
  function ()
  {
    Route::get( '/poke/{event_instance_name}/{screen_type}', 'CodeFingerprintController@ApiPoke' )->name( 'code-fingerprint.poke' );
  }
);

/** END: CODE FINGERPRINT ROUTES **********************************************/

/** BEGIN: USER ROUTES ********************************************************/

Route::group(
  [
    'middleware' => 'auth:api'
  ],
  function ()
  {
    Route::delete( '/users/{id}', 'UserController@delete' )->name( 'deleteuser' );
  }
);

Route::middleware( 'auth:api' )->get(
  '/user',
  function ( Request $request )
  {
    return $request->user();
  }
);

/** END: USER ROUTES **********************************************************/

/** BEGIN: AWARD POINTS ROUTES ************************************************/

// TODO: Inquire about updating arcade machines to use this properly:
/**
 * These routes are open, and are used by external services,
 * such as the Arcade games machines.
 */
Route::group(
  [
    'middleware' => [],
    'prefix'     => 'points'
  ],
  function ()
  {
    Route::post( '/postPoints/{event_instance_name}/', 'PointsController@AwardPoints' )->name( 'points.award' );
  }
);

/** END: AWARD POINTS ROUTES **************************************************/


/** BEGIN: SOCIAL WALL ROUTES *************************************************/
Route::group(
  [
    'namespace'  => 'SocialWall',
    'middleware' => [],
    'prefix'     => ''
  ],
  function ()
  {

    /** BEGIN: MONITOR SOCIAL WALL SETTINGS -------------------------------- **/
    Route::get( '/monitor/social-wall/settings/{event_instance_name}', 'SocialWallController@MonitorSettings' );
    /** END: MONITOR SOCIAL WALL SETTINGS ---------------------------------- **/

    /** BEGIN: ANNOUNCEMENTS ----------------------------------------------- **/
    Route::get( '/announcements/get-announcement/{event_instance_name}', 'AnnouncementsController@GetAnnouncement' );
    /** END: ANNOUNCEMENTS ------------------------------------------------- **/

    /** BEGIN: SCOREBOARD -------------------------------------------------- **/
    Route::get( '/scoreboard/get-team-scores/{event_instance_name}', 'ScoreboardController@GetTeamScores' );
    Route::get( '/scoreboard/get-team-member-scores/{event_instance_name}', 'ScoreboardController@GetAllTopTeamMembersScores' );
    Route::get( '/scoreboard/get-team-member-scores/{event_instance_name}/{team_name}', 'ScoreboardController@GetTopTeamMembersScores' );
    /** END: SCOREBOARD ---------------------------------------------------- **/

    /** BEGIN: SOCIAL CARDS ------------------------------------------------ **/
    Route::post( '/social-cards/get-cards/{event_instance_name}', 'SocialCardsController@GetCards' );
    /** END: SOCIAL CARDS -------------------------------------------------- **/

    /** BEGIN: LEADERBOARD ------------------------------------------------- **/
    Route::get( '/leaderboards/{event_instance_name}', 'LeaderboardController@GetLeaderboards' )->name( 'leaderboards' );
    /** END: LEADERBOARD --------------------------------------------------- **/

  }
);
/** END: SOCIAL WALL ROUTES ***************************************************/


/** BEGIN: TOUCH SCREEN ROUTES ************************************************/
Route::group(
  [
    'namespace'  => 'TouchScreen',
    'middleware' => [],
    'prefix'     => 'touch-screen'
  ],
  function ()
  {

    /** BEGIN: AGENDA ------------------------------------------------------ **/
    Route::get( '/get-agenda/{event_instance_name}', 'TabletTouchScreenController@GetAgendaJson' )
    ->name( 'touch-screen.get-agenda' );
    /** END: AGENDA -------------------------------------------------------- **/

    /** BEGIN: MAP SCREENS ------------------------------------------------- **/
    Route::get( '/get-map-screens/{event_instance_name}', 'TabletTouchScreenController@GetMapScreensJson' )
    ->name( 'touch-screen.get-map-screens' );
    /** END: MAP SCREENS --------------------------------------------------- **/

    /** BEGIN: EXPO STANDS ------------------------------------------------- **/
    Route::get( '/get-expo-stands/{event_instance_name}', 'TabletTouchScreenController@GetExpoStandsJson' )
    ->name( 'touch-screen.get-expo-stands' );
    /** END: EXPO STANDS --------------------------------------------------- **/

    /** BEGIN: EVENT SCREENS ----------------------------------------------- **/
    Route::get( '/get-event-screens/{event_instance_name}', 'TabletTouchScreenController@GetEventScreensJson' )
    ->name( 'touch-screen.get-event-screens' );
    /** END: EVENT SCREENS ------------------------------------------------- **/

    /** BEGIN: SPONSOR SCREENS --------------------------------------------- **/
    Route::get( '/get-sponsor-screens/{event_instance_name}', 'TabletTouchScreenController@GetSponsorScreensJson' )
    ->name( 'touch-screen.get-sponsor-screens' );
    /** END: SPONSOR SCREENS ----------------------------------------------- **/

  }
);
/** END: TOUCH SCREEN ROUTES **************************************************/
