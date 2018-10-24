<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*******************************************************************************

Look in:

  app\Providers\RouteServiceProvider::boot()
  
...for route parameter constraints.

*******************************************************************************/

Route::redirect( '/', '/login', 302 );

Auth::routes();

/** BEGIN: EVENT INSTANCES SCREEN ROUTES **************************************/

Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'home'
  ],
  function ()
  {
    Route::get( '/', 'HomeController@index' )->name( 'home' );
  }
);

/** END: EVENT INSTANCES SCREEN ROUTES ****************************************/

/** BEGIN: ADMIN DASHBOARD ROUTES *********************************************/

Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'dashboard'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'DashboardController@index' )->name( 'dashboard' );
  }
);

/** END: ADMIN DASHBOARD ROUTES ***********************************************/

/** BEGIN: USER ADMIN ROUTES **************************************************/

Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'user'
  ],
  function ()
  {
    Route::get( '/', 'UserController@index' )->name( 'users' );
    Route::get( '/create', 'UserController@create' )->name( 'newuser' );
    Route::post( '/create', 'UserController@create' )->name( 'newuser' );
    Route::get( '/token/create', 'UserController@createUserToken' )->name( 'usertoken' );
    Route::get( '/{id}/admin', 'UserController@giveUserAdminPermissions' )->name( 'admin.create' );
    Route::get( '/{id}/admin/destroy', 'UserController@removeUserAdminPermissions' )->name( 'admin.remove' );
    Route::delete( '/{id}', 'UserController@delete' )->name( 'user.delete' );
  }
);

/** END: USER ADMIN ROUTES ****************************************************/

/** BEGIN: REPORT ROUTES ******************************************************/

Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'reports'
  ],
  function ()
  {
    Route::get( '/', 'Reports@index' )->name( 'reports.index' );
  }
);

/** END: REPORT ROUTES ********************************************************/

/** BEGIN: CODE FINGERPRINT ROUTES ********************************************/

Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'code-fingerprint'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'CodeFingerprintController@index' )->name( 'code-fingerprint' );
    Route::get( '/poke/{event_instance_name}/{screen_type}', 'CodeFingerprintController@Poke' )->name( 'code-fingerprint.poke' );
  }
);

Route::group(
  [
    'middleware' => [],
    'prefix'     => 'code-fingerprint'
  ],
  function ()
  {
    Route::get( '/current/{event_instance_name}/{screen_type}', 'CodeFingerprintController@Current' )->name( 'code-fingerprint.current' );
  }
);

/** END: CODE FINGERPRINT ROUTES **********************************************/

/** BEGIN: SCREEN SETTINGS ADMIN ROUTES ***************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'screen-setting'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'SocialWallScreenSettingController@index' )->name( 'screens' );
    Route::get( '/enable/{event_instance_name}/{id}', 'SocialWallScreenSettingController@Enable' )->name( 'screens.enable' );
    Route::get( '/enable-all/{event_instance_name}', 'SocialWallScreenSettingController@EnableAll' )->name( 'screens.enable-all' );
    Route::get( '/disable/{event_instance_name}/{id}', 'SocialWallScreenSettingController@Disable' )->name( 'screens.disable' );
    Route::get( '/disable-all/{event_instance_name}', 'SocialWallScreenSettingController@DisableAll' )->name( 'screens.disable-all' );
    Route::post( '/set-duration/{event_instance_name}/{id}', 'SocialWallScreenSettingController@SetDuration' )->name( 'screens.set-duration' );
    Route::get( '/reset-to-defaults/{event_instance_name}', 'SocialWallScreenSettingController@ResetToDefaults' )->name( 'screens.reset-to-defaults' );
  }
);
/** END: SCREEN SETTINGS ADMIN ROUTES *****************************************/

/** BEGIN: ANNOUNCEMENTS ADMIN ROUTES *****************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'announcements'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'AnnouncementsController@index' )->name( 'announcements' );
    Route::get( '/create/{event_instance_name}', 'AnnouncementsController@create_form' )->name( 'announcements.create' );
    Route::post( '/create/{event_instance_name}', 'AnnouncementsController@create' )->name( 'announcements.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'AnnouncementsController@edit' )->name( 'announcements.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'AnnouncementsController@update' )->name( 'announcements.update' );
    Route::get( '/activate/{event_instance_name}/{id}', 'AnnouncementsController@activate' )->name( 'announcements.activate' );
    Route::get( '/deactivate/{event_instance_name}/{id}', 'AnnouncementsController@deactivate' )->name( 'announcements.deactivate' );
    Route::get( '/delete/{event_instance_name}/{id}', 'AnnouncementsController@delete' )->name( 'announcements.delete' );
  }
);
/** END: ANNOUNCEMENTS ADMIN ROUTES *******************************************/

/** BEGIN: FINAL COUNTDOWN ADMIN ROUTES ***************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'final-countdown'
  ],
  function ()
  {
    // TODO: Add AJAX capability to this:
    Route::get( '/{event_instance_name}', 'CountdownController@index' )->name( 'countdown' );
    Route::get( '/enable/{event_instance_name}/{id}', 'CountdownController@Enable' )->name( 'countdown.enable' );
    Route::get( '/disable/{event_instance_name}/{id}', 'CountdownController@Disable' )->name( 'countdown.disable' );
    Route::post( '/set-target-date/{event_instance_name}/{id}', 'CountdownController@SetCountdown' )->name( 'countdown.set-countdown' );
  }
);
/** END: FINAL COUNTDOWN ADMIN ROUTES *****************************************/

/** BEGIN: SCOREBOARD TEAM CONFIGS ADMIN ROUTES *******************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'configure-teams'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'ScoreboardTeamConfigController@index' )->name( 'configure-teams' );
    Route::get( '/create/{event_instance_name}', 'ScoreboardTeamConfigController@create_form' )->name( 'configure-teams.create' );
    Route::post( '/create/{event_instance_name}', 'ScoreboardTeamConfigController@create' )->name( 'configure-teams.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'ScoreboardTeamConfigController@edit' )->name( 'configure-teams.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'ScoreboardTeamConfigController@update' )->name( 'configure-teams.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'ScoreboardTeamConfigController@delete' )->name( 'configure-teams.delete' );
    Route::get( '/reset-teams/{event_instance_name}', 'ScoreboardTeamConfigController@reset_teams' )->name( 'configure-teams.reset-teams' );
  }
);
/** END: SCOREBOARD TEAM CONFIGS ADMIN ROUTES *********************************/

/** BEGIN: POINTS ADMIN ROUTES ************************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'points'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'PointsController@index' )->name( 'points' );
    Route::get( '/delete/{event_instance_name}/{id}', 'PointsController@delete' )->name( 'points.delete' );
    Route::get( '/restore/{event_instance_name}/{id}', 'PointsController@restore' )->name( 'points.restore' );
    Route::get( '/award/{event_instance_name}', 'PointsController@AwardPointsForm' )->name( 'points.award' );
  }
);
/** END: POINTS ADMIN ROUTES **************************************************/

/** BEGIN: TWITTER HASHTAG ADMIN ROUTES ***************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'twitter-hashtags'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TwitterHashtagConfigController@index' )->name( 'twitter-hashtags' );
    Route::post( '/add/{event_instance_name}', 'TwitterHashtagConfigController@create' )->name( 'twitter-hashtags.add' );
    Route::get( '/enable/{event_instance_name}/{id}', 'TwitterHashtagConfigController@enable' )->name( 'twitter-hashtags.enable' );
    Route::get( '/disable/{event_instance_name}/{id}', 'TwitterHashtagConfigController@disable' )->name( 'twitter-hashtags.disable' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TwitterHashtagConfigController@delete' )->name( 'twitter-hashtags.delete' );
  }
);
/** END: TWITTER HASHTAG ADMIN ROUTES *****************************************/

/** BEGIN: APPWORKS POSTS ADMIN ROUTES ****************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'appworks-posts'
  ],
  function ()
  {
    Route::get( '/dashboard/{event_instance_name}', 'SocialCardPostsController@index' )->name( 'appworks-posts.dashboard' );
    Route::get( '/approve/{event_instance_name}/{id}', 'SocialCardPostsController@approve' )->name( 'appworks-posts.approve' );
    Route::get( '/reject/{event_instance_name}/{id}', 'SocialCardPostsController@reject' )->name( 'appworks-posts.reject' );
    Route::get( '/feature/{event_instance_name}/{id}', 'SocialCardPostsController@feature' )->name( 'appworks-posts.feature' );
    Route::get( '/unfeature/{event_instance_name}/{id}', 'SocialCardPostsController@unfeature' )->name( 'appworks-posts.unfeature' );
    Route::delete( '/delete/{event_instance_name}/{id}', 'SocialCardPostsController@delete' )->name( 'appworks-posts.delete' );
  }
);
/** END: APPWORKS POSTS ADMIN ROUTES ******************************************/

/** BEGIN: TWEETS ADMIN ROUTES ************************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'tweets'
  ],
  function ()
  {
    Route::get( '/dashboard/{event_instance_name}', 'SocialCardTweetsController@index' )->name( 'tweets.dashboard' );
    Route::get( '/approve/{event_instance_name}/{id}', 'SocialCardTweetsController@approve' )->name( 'tweets.approve' );
    Route::get( '/reject/{event_instance_name}/{id}', 'SocialCardTweetsController@reject' )->name( 'tweets.reject' );
    Route::get( '/feature/{event_instance_name}/{id}', 'SocialCardTweetsController@feature' )->name( 'tweets.feature' );
    Route::get( '/unfeature/{event_instance_name}/{id}', 'SocialCardTweetsController@unfeature' )->name( 'tweets.unfeature' );
    Route::delete( '/delete/{event_instance_name}/{id}', 'SocialCardTweetsController@delete' )->name( 'tweets.delete' );
  }
);
/** END: TWEETS ADMIN ROUTES **************************************************/

/** BEGIN: LEADERBOARD ADMIN ROUTES *******************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'leaderboard'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'LeaderboardController@index' )->name( 'leaderboard' );
    Route::get( '/create/{event_instance_name}', 'LeaderboardController@create_form' )->name( 'leaderboard.create' );
    Route::post( '/create/{event_instance_name}', 'LeaderboardController@create' )->name( 'leaderboard.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'LeaderboardController@edit' )->name( 'leaderboard.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'LeaderboardController@update' )->name( 'leaderboard.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'LeaderboardController@delete' )->name( 'leaderboard.delete' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'LeaderboardController@bumpOrderDown' )->name( 'leaderboard.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'LeaderboardController@bumpOrderUp' )->name( 'leaderboard.bump-order-up' );
  }
);
/** END: LEADERBOARD ADMIN ROUTES *********************************************/

/** BEGIN: SOCIAL CARDS ADMIN ROUTES ******************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'social-cards-configs'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'SocialCardsConfigController@index' )->name( 'social-cards-configs' );
    Route::post( '/set-configs/{event_instance_name}', 'SocialCardsConfigController@SetConfigs' )->name( 'social-cards-configs.set-configs' );
    Route::get( '/reset-to-default/{event_instance_name}', 'SocialCardsConfigController@ResetToDefault' )->name( 'social-cards-configs.reset-to-default' );
  }
);
/** END: SOCIAL CARDS ADMIN ROUTES ********************************************/

/** BEGIN: SOCIAL WALL ROUTES *************************************************/
Route::group(
  [
    'namespace'  => 'SocialWall',
    'middleware' => [],
    'prefix'     => 'social-wall'
  ],
  function ()
  {

    /** BEGIN: SOCIAL WALL ------------------------------------------------- **/
    Route::get( '/{event_instance_name}', 'SocialWallController@index' )->name( 'social-wall' );
    /** END: SOCIAL WALL --------------------------------------------------- **/

    /** BEGIN: EXAMPLE VUE COMPONENT USAGE --------------------------------- **/
    Route::get( '/example-announcement/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-announcement' ) );
    });
    Route::get( '/example-final-countdown/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-final-countdown' ) );
    });
    Route::get( '/example-transitions/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-transitions' ) );
    });
    Route::get( '/example-logo-screen/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-logo-screen' ) );
    });
    Route::get( '/example-scoreboard-teams/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-scoreboard-teams' ) );
    });
    Route::get( '/example-scoreboard-team-members/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-scoreboard-team-members' ) );
    });
    Route::get( '/example-social-cards/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-social-cards' ) );
    });
    Route::get( '/example-leaderboard-screens/{event_instance_name}', function ( Request $request ) {
      return( view( 'social-wall.examples.example-leaderboard-screens' ) );
    });
    /** END: EXAMPLE VUE COMPONENT USAGE ----------------------------------- **/

  }
);
/** END: SOCIAL WALL ROUTES ***************************************************/


/** BEGIN: TOUCH SCREEN VUE COMPONENT EXAMPLES ********************************/
Route::group(
  [
    'middleware' => [],
    'prefix'     => 'ts-examples'
  ],
  function ()
  {

    Route::get( '/example-which-team-am-i/{event_instance_name}', function ( Request $request ) {
      return( view( 'touch-screen.examples.example-which-team-am-i' ) );
    });

    Route::get( '/example-exhibitor-map/{event_instance_name}', function ( Request $request ) {
      return( view( 'touch-screen.examples.example-exhibitor-map' ) );
    });

  }
);
/** END: TOUCH SCREEN VUE COMPONENT EXAMPLES **********************************/


/** BEGIN: TOUCH SCREEN ADMIN ROUTES ******************************************/

/** BEGIN: TOUCH SCREEN IMAGES ADMIN ROUTES -------------------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-images'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenImagesController@index' )->name( 'ts-images' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenImagesController@create_form' )->name( 'ts-images.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenImagesController@create' )->name( 'ts-images.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenImagesController@edit' )->name( 'ts-images.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenImagesController@update' )->name( 'ts-images.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenImagesController@delete' )->name( 'ts-images.delete' );
  }
);
/** END: TOUCH SCREEN IMAGES ADMIN ROUTES ---------------------------------- **/

/** BEGIN: TOUCH SCREEN AGENDA SCREENS ADMIN ROUTES ------------------------ **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-agenda-screens'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenAgendaScreensController@index' )->name( 'ts-agenda-screens' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenAgendaScreensController@create_form' )->name( 'ts-agenda-screens.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenAgendaScreensController@create' )->name( 'ts-agenda-screens.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@edit' )->name( 'ts-agenda-screens.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@update' )->name( 'ts-agenda-screens.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@bumpOrderDown' )->name( 'ts-agenda-screens.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@bumpOrderUp' )->name( 'ts-agenda-screens.bump-order-up' );
    Route::get( '/activate/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@activate' )->name( 'ts-agenda-screens.activate' );
    Route::get( '/deactivate/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@deactivate' )->name( 'ts-agenda-screens.deactivate' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenAgendaScreensController@delete' )->name( 'ts-agenda-screens.delete' );

    Route::get( '/export-to-excel/{event_instance_name}', 'TouchscreenAgendaScreensController@ExportToExcel' )->name( 'ts-agenda-screens.export-to-excel' );
    Route::get( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaScreensController@ImportFromExcelForm' )->name( 'ts-agenda-screens.import-from-excel-form' );
    Route::post( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaScreensController@ImportFromExcel' )->name( 'ts-agenda-screens.import-from-excel' );

  }
);
/** END: TOUCH SCREEN AGENDA SCREENS ADMIN ROUTES -------------------------- **/

/** BEGIN: TOUCH SCREEN AGENDA ANNOUNCEMENT ADMIN ROUTES ------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-agenda-announcements'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenAgendaAnnouncementsController@index' )->name( 'ts-agenda-announcements' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenAgendaAnnouncementsController@create_form' )->name( 'ts-agenda-announcements.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenAgendaAnnouncementsController@create' )->name( 'ts-agenda-announcements.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaAnnouncementsController@edit' )->name( 'ts-agenda-announcements.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaAnnouncementsController@update' )->name( 'ts-agenda-announcements.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenAgendaAnnouncementsController@delete' )->name( 'ts-agenda-announcements.delete' );
  }
);
/** END: TOUCH SCREEN AGENDA ANNOUNCEMENT ADMIN ROUTES --------------------- **/

/** BEGIN: TOUCH SCREEN AGENDA SCHEDULES ADMIN ROUTES ---------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-agenda-schedule-events'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@index' )->name( 'ts-agenda-schedule-events' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@create_form' )->name( 'ts-agenda-schedule-events.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@create' )->name( 'ts-agenda-schedule-events.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@edit' )->name( 'ts-agenda-schedule-events.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@update' )->name( 'ts-agenda-schedule-events.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@bumpOrderDown' )->name( 'ts-agenda-schedule-events.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@bumpOrderUp' )->name( 'ts-agenda-schedule-events.bump-order-up' );
    Route::get( '/hide/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@hide' )->name( 'ts-agenda-schedule-events.hide' );
    Route::get( '/unhide/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@unhide' )->name( 'ts-agenda-schedule-events.unhide' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenAgendaScheduleEventsController@delete' )->name( 'ts-agenda-schedule-events.delete' );

    Route::get( '/download-excel-template/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@DownloadExcelTemplate' )->name( 'ts-agenda-schedule-events.download-excel-template' );
    Route::get( '/export-to-excel/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@ExportToExcel' )->name( 'ts-agenda-schedule-events.export-to-excel' );
    Route::get( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@ImportFromExcelForm' )->name( 'ts-agenda-schedule-events.import-from-excel-form' );
    Route::post( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaScheduleEventsController@ImportFromExcel' )->name( 'ts-agenda-schedule-events.import-from-excel' );
  }
);
/** END: TOUCH SCREEN AGENDA SCHEDULES ADMIN ROUTES ------------------------ **/

/** BEGIN: TOUCH SCREEN AGENDA BREAKOUT SESSIONS ADMIN ROUTES -------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-agenda-breakout-sessions'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@index' )->name( 'ts-agenda-breakout-sessions' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@create_form' )->name( 'ts-agenda-breakout-sessions.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@create' )->name( 'ts-agenda-breakout-sessions.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@edit' )->name( 'ts-agenda-breakout-sessions.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@update' )->name( 'ts-agenda-breakout-sessions.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@bumpOrderDown' )->name( 'ts-agenda-breakout-sessions.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@bumpOrderUp' )->name( 'ts-agenda-breakout-sessions.bump-order-up' );
    Route::get( '/hide/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@hide' )->name( 'ts-agenda-breakout-sessions.hide' );
    Route::get( '/unhide/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@unhide' )->name( 'ts-agenda-breakout-sessions.unhide' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenAgendaBreakoutSessionsController@delete' )->name( 'ts-agenda-breakout-sessions.delete' );

    Route::get( '/download-excel-template/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@DownloadExcelTemplate' )->name( 'ts-agenda-breakout-sessions.download-excel-template' );
    Route::get( '/export-to-excel/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@ExportToExcel' )->name( 'ts-agenda-breakout-sessions.export-to-excel' );
    Route::get( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@ImportFromExcelForm' )->name( 'ts-agenda-breakout-sessions.import-from-excel-form' );
    Route::post( '/import-from-excel/{event_instance_name}', 'TouchscreenAgendaBreakoutSessionsController@ImportFromExcel' )->name( 'ts-agenda-breakout-sessions.import-from-excel' );
  }
);
/** END: TOUCH SCREEN AGENDA BREAKOUT SESSIONS ADMIN ROUTES ---------------- **/

/** BEGIN: TOUCH SCREEN EXPO MAPS ADMIN ROUTES ----------------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-expo-maps'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenExpoMapsController@index' )->name( 'ts-expo-maps' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenExpoMapsController@create_form' )->name( 'ts-expo-maps.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenExpoMapsController@create' )->name( 'ts-expo-maps.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenExpoMapsController@edit' )->name( 'ts-expo-maps.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenExpoMapsController@update' )->name( 'ts-expo-maps.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenExpoMapsController@delete' )->name( 'ts-expo-maps.delete' );
  }
);
/** END: TOUCH SCREEN EXPO MAPS ADMIN ROUTES ------------------------------- **/

/** BEGIN: TOUCH SCREEN EXPO STANDS ADMIN ROUTES --------------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-expo-stands'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenExpoStandsController@index' )->name( 'ts-expo-stands' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenExpoStandsController@create_form' )->name( 'ts-expo-stands.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenExpoStandsController@create' )->name( 'ts-expo-stands.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenExpoStandsController@edit' )->name( 'ts-expo-stands.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenExpoStandsController@update' )->name( 'ts-expo-stands.update' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenExpoStandsController@delete' )->name( 'ts-expo-stands.delete' );

    Route::get( '/download-excel-template/{event_instance_name}', 'TouchscreenExpoStandsController@DownloadExcelTemplate' )->name( 'ts-expo-stands.download-excel-template' );
    Route::get( '/export-to-excel/{event_instance_name}', 'TouchscreenExpoStandsController@ExportToExcel' )->name( 'ts-expo-stands.export-to-excel' );
    Route::get( '/import-from-excel/{event_instance_name}', 'TouchscreenExpoStandsController@ImportFromExcelForm' )->name( 'ts-expo-stands.import-from-excel-form' );
    Route::post( '/import-from-excel/{event_instance_name}', 'TouchscreenExpoStandsController@ImportFromExcel' )->name( 'ts-expo-stands.import-from-excel' );

  }
);
/** END: TOUCH SCREEN EXPO STANDS ADMIN ROUTES ----------------------------- **/

/** BEGIN: TOUCH SCREEN MAP SCREENS ADMIN ROUTES --------------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-map-screens'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenMapScreensController@index' )->name( 'ts-map-screens' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenMapScreensController@create_form' )->name( 'ts-map-screens.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenMapScreensController@create' )->name( 'ts-map-screens.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenMapScreensController@edit' )->name( 'ts-map-screens.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenMapScreensController@update' )->name( 'ts-map-screens.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenMapScreensController@bumpOrderDown' )->name( 'ts-map-screens.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenMapScreensController@bumpOrderUp' )->name( 'ts-map-screens.bump-order-up' );
    Route::get( '/activate/{event_instance_name}/{id}', 'TouchscreenMapScreensController@activate' )->name( 'ts-map-screens.activate' );
    Route::get( '/deactivate/{event_instance_name}/{id}', 'TouchscreenMapScreensController@deactivate' )->name( 'ts-map-screens.deactivate' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenMapScreensController@delete' )->name( 'ts-map-screens.delete' );
  }
);
/** END: TOUCH SCREEN MAP SCREENS ADMIN ROUTES ----------------------------- **/

/** BEGIN: TOUCH SCREEN EVENT SCREENS ADMIN ROUTES ------------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-event-screens'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenEventScreensController@index' )->name( 'ts-event-screens' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenEventScreensController@create_form' )->name( 'ts-event-screens.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenEventScreensController@create' )->name( 'ts-event-screens.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenEventScreensController@edit' )->name( 'ts-event-screens.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenEventScreensController@update' )->name( 'ts-event-screens.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenEventScreensController@bumpOrderDown' )->name( 'ts-event-screens.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenEventScreensController@bumpOrderUp' )->name( 'ts-event-screens.bump-order-up' );
    Route::get( '/activate/{event_instance_name}/{id}', 'TouchscreenEventScreensController@activate' )->name( 'ts-event-screens.activate' );
    Route::get( '/deactivate/{event_instance_name}/{id}', 'TouchscreenEventScreensController@deactivate' )->name( 'ts-event-screens.deactivate' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenEventScreensController@delete' )->name( 'ts-event-screens.delete' );
  }
);
/** END: TOUCH SCREEN EVENT SCREENS ADMIN ROUTES --------------------------- **/

/** BEGIN: TOUCH SCREEN SPONSOR SCREENS ADMIN ROUTES ----------------------- **/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'ts-sponsor-screens'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchscreenSponsorScreensController@index' )->name( 'ts-sponsor-screens' );
    Route::get( '/create/{event_instance_name}', 'TouchscreenSponsorScreensController@create_form' )->name( 'ts-sponsor-screens.create' );
    Route::post( '/create/{event_instance_name}', 'TouchscreenSponsorScreensController@create' )->name( 'ts-sponsor-screens.create' );
    Route::get( '/edit/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@edit' )->name( 'ts-sponsor-screens.edit' );
    Route::post( '/edit/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@update' )->name( 'ts-sponsor-screens.update' );
    Route::get( '/bump-order-down/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@bumpOrderDown' )->name( 'ts-sponsor-screens.bump-order-down' );
    Route::get( '/bump-order-up/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@bumpOrderUp' )->name( 'ts-sponsor-screens.bump-order-up' );
    Route::get( '/activate/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@activate' )->name( 'ts-sponsor-screens.activate' );
    Route::get( '/deactivate/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@deactivate' )->name( 'ts-sponsor-screens.deactivate' );
    Route::get( '/delete/{event_instance_name}/{id}', 'TouchscreenSponsorScreensController@delete' )->name( 'ts-sponsor-screens.delete' );
  }
);
/** END: TOUCH SCREEN SPONSOR SCREENS ADMIN ROUTES ------------------------- **/

/** END: TOUCH SCREEN ADMIN ROUTES ********************************************/







/** BEGIN: FONDLESLAB ROUTES **************************************************/
Route::group(
  [
    'namespace'  => 'FondleSlab',
    'middleware' => [],
    'prefix'     => 'fondleslab'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', function ( Request $request ) { return( view( 'fondleslab.index' ) ); } );
    Route::get( '/experiment/{event_instance_name}', function ( Request $request ) { return( view( 'fondleslab.index-experiment' ) ); } );
    //Route::get( '/', 'TouchScreenController@index' )->name( 'touch-screen' );
  }
);
/** END: FONDLESLAB ROUTES ****************************************************/

Route::post('SubmitFeedback','TouchScreen\TouchScreenController@feedbackData');

Route::get('/feedback-example', function () {
    return view('touch-screen.examples.example-feedback');
});



/** BEGIN: TABLET TOUCH SCREEN ROUTES *****************************************/
Route::group(
  [
    'namespace'  => 'TabletTouchScreen',
    'middleware' => [],
    'prefix'     => 'tablet'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TabletTouchScreenController@index' )->name( 'tablet' );
  }
);
/** END: TABLET TOUCH SCREEN ROUTES *******************************************/






/** BEGIN: TOUCH SCREEN ROUTES ************************************************/
/* DEPRECATED:
Route::group(
  [
    'namespace'  => 'TouchScreen',
    'middleware' => [],
    'prefix'     => 'touchscreen'
  ],
  function ()
  {
    Route::get( '/{event_instance_name}', 'TouchScreenController@index' )->name( 'touch-screen' );
  }
);
*/
/** END: TOUCH SCREEN ROUTES **************************************************/
