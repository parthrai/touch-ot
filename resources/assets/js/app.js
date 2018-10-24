
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require( './bootstrap' );
require( 'jquery' );

window.Vue = require( 'vue' );

/** BEGIN: Vue Router *********************************************************/

import VueRouter from 'vue-router';
import routes from './routes';

Vue.use( VueRouter );

const router = new VueRouter(
  {
    routes
  }
);

/** BEGIN: EXPERIMENTAL Bespoke Touch Screen and Vue Router ---------------- **/
//import routes from './fondle-slab-routes';
//const router = new VueRouter( { routes: routes } );
/** END: EXPERIMENTAL Bespoke Touch Screen and Vue Router ------------------ **/

/** END: Vue Router ***********************************************************/

/** BEGIN: Vuetify and Vue Router ------------------------------------------ **/

import Vuetify from 'vuetify';
import IdleVue from 'idle-vue';

Vue.use( Vuetify );

const eventsHub = new Vue();

Vue.use(
  IdleVue,
  {
    eventEmitter: eventsHub,
    idleTime: 10000 // The amount of time (ms) before user is considered idle
  }
);

/** END: Vuetify and Vue Router -------------------------------------------- **/

/** BEGIN: Useful Functions ------------------------------------------------ **/

window.NumberWithCommas = function ( num )
{
  return( num.toString().replace( /\B(?=(\d{3})+(?!\d))/g, "," ) );
}

/** END: Useful Functions -------------------------------------------------- **/

/** BEGIN: Code Fingerprint Components ------------------------------------- **/

Vue.component(
  'CodeFingerprintMonitor',
  require( './components/code-fingerprint/CodeFingerprintMonitor.vue' )
);

/** END: Code Fingerprint Components --------------------------------------- **/

/** BEGIN: Test Card Components -------------------------------------------- **/

Vue.component(
  'TestCard',
  require( './components/test-card/TestCard.vue' )
);

/** END: Test Card Components -------------------------------------------- **/

/** BEGIN: QR Code Generator ----------------------------------------------- **/

import VueQrcode from '@xkeshi/vue-qrcode';
Vue.component( VueQrcode.name, VueQrcode );

Vue.component(
  'GenerateQrCode',
  require( './components/qr-codes/GenerateQrCode.vue' )
);

/** END: QR Code Generator ------------------------------------------------- **/

/** BEGIN: Header Strips --------------------------------------------------- **/

Vue.component(
  'WallpaperRorschach',
  require( './components/wallpapers/WallpaperRorschach.vue' )
);

Vue.component(
  'WallpaperRorschachDark',
  require( './components/wallpapers/WallpaperRorschachDark.vue' )
);

/** END: Header Strips ----------------------------------------------------- **/

/** BEGIN: Header Strips --------------------------------------------------- **/

Vue.component(
  'HeaderStripEnterpriseWorld',
  require( './components/header-strips/HeaderStripEnterpriseWorld.vue' )
);

/** END: Header Strips ----------------------------------------------------- **/

/** BEGIN: Transitioner ---------------------------------------------------- **/

Vue.component(
  'Transitioner',
  require( './components/transitioner/Transitioner.vue' )
);

/** END: Transitioner ------------------------------------------------------ **/

/** BEGIN: Teams ----------------------------------------------------------- **/

Vue.component(
  'TeamBadge',
  require( './components/teams/TeamBadge.vue' )
);

Vue.component(
  'WhichTeamAmI',
  require( './components/teams/WhichTeamAmI.vue' )
);

/** END: Teams ------------------------------------------------------------- **/

/** BEGIN: Exhibitors ------------------------------------------------------ **/

Vue.component(
  'ExhibitorMap',
  require( './components/exhibitors/ExhibitorMap.vue' )
);

/** END: Exhibitors -------------------------------------------------------- **/

/** BEGIN: Social Wall ----------------------------------------------------- **/

Vue.component(
  'FinalCountdown',
  require( './components/social-wall/final-countdown/FinalCountdown.vue' )
);

Vue.component(
  'SevenSegmentDisplay',
  require( './components/social-wall/final-countdown/SevenSegmentDisplay.vue' )
);

Vue.component(
  'SevenSegmentDisplayDots',
  require( './components/social-wall/final-countdown/SevenSegmentDisplayDots.vue' )
);

Vue.component(
  'LogoScreen',
  require( './components/social-wall/LogoScreen.vue' )
);

Vue.component(
  'AnnouncementScreen',
  require( './components/social-wall/AnnouncementScreen.vue' )
);

Vue.component(
  'LeaderboardScreen',
  require( './components/social-wall/LeaderboardScreen.vue' )
);

Vue.component(
  'ScoreboardTeams',
  require( './components/social-wall/scoreboard-teams/ScoreboardTeams.vue' )
);

Vue.component(
  'ScoreboardTeamMembers',
  require( './components/social-wall/scoreboard-teams/ScoreboardTeamMembers.vue' )
);

Vue.component(
  'SocialCardsColumns',
  require( './components/social-wall/social-cards/SocialCardsColumns.vue' )
);

Vue.component(
  'SocialCardAppworksPost',
  require( './components/social-wall/social-cards/SocialCardAppworksPost.vue' )
);

Vue.component(
  'SocialCardTweet',
  require( './components/social-wall/social-cards/SocialCardTweet.vue' )
);

/** END: Social Wall ------------------------------------------------------- **/

/** BEGIN: Points Administration ------------------------------------------- **/

Vue.component(
  'AwardPoints',
  require( './components/points/AwardPoints.vue' )
);

/** END: Points Administration --------------------------------------------- **/

/** BEGIN: Modal Dialogues ------------------------------------------------- **/

Vue.component(
  'ModalConfirmHrefAction',
  require( './components/dialogue-boxes/ModalConfirmHrefAction.vue' )
);

/** END: Modal Dialogues --------------------------------------------------- **/

/** BEGIN: Touch Screen Application ---------------------------------------- **/

Vue.component( 'NavTiles', require( './components/public-tablet/nav/Tiles.vue' ) );
Vue.component( 'NavDrawer', require( './components/public-tablet/nav/Drawer.vue' ) );
Vue.component( 'TouchScreen', require( './components/public-tablet/TouchScreen.vue' ) );
Vue.component( 'feed-back', require( './components/public-tablet/Feedback/Feedback.vue' ) );

// There are other components for Touch Screen in the routes.js file.

/** END: Touch Screen Application ------------------------------------------ **/

/** BEGIN: Bind Vue to Application ----------------------------------------- **/

window.app = new Vue(
  {
    el: '#app',
    ref: "master",
    router: router
  }
);
/** END: Bind Vue to Application ------------------------------------------- **/
