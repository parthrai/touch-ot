
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require( 'jquery' );
//window.$ = window.jQuery = require('jquery');

window.Vue = require( 'vue' );

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if( token )
{
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
else
{
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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

/** BEGIN: QR Code Generator ----------------------------------------------- **/

import VueQrcode from '@xkeshi/vue-qrcode';
Vue.component( VueQrcode.name, VueQrcode );

Vue.component(
  'GenerateQrCode',
  require( './components/qr-codes/GenerateQrCode.vue' )
);

/** END: QR Code Generator ------------------------------------------------- **/

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

/** BEGIN: Social Wall ----------------------------------------------------- **/

Vue.component(
  'LeaderboardScreen',
  require( './components/social-wall/LeaderboardScreen.vue' )
);

/** END: Social Wall ------------------------------------------------------- **/

/** BEGIN: Tablet Touch Screen --------------------------------------------- **/

Vue.component(
  'TabletHomeButton',
  require( './components/tablet-touch-screen/TabletHomeButton.vue' )
);

Vue.component(
  'YouAreHereDot',
  require( './components/tablet-touch-screen/YouAreHereDot.vue' )
);

Vue.component(
  'ExpoMapDisplay',
  require( './components/tablet-touch-screen/ExpoMapDisplay.vue' )
);

/** END: Tablet Touch Screen ----------------------------------------------- **/

/** BEGIN: Bind Vue to Application ----------------------------------------- **/

window.app = new Vue(
  {
    el: '#app',
    ref: "master"
  }
);

/** END: Bind Vue to Application ------------------------------------------- **/
