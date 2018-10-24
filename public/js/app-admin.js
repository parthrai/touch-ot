/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/admin/touch-screen/expo-stands-coordinates.js":
/***/ (function(module, exports) {

/******************************************************************************/

window.InitExpoMapCoordPicker = function (expo_stands_coordinates_picker, expo_stands_blackspot) {

  document.getElementById(expo_stands_coordinates_picker).addEventListener("click", function (ev) {

    document.getElementById(expo_stands_coordinates_picker).addEventListener("click", function (ev) {

      var el = ev.target;

      // Find relative width and height of map:
      var el_width = el.offsetWidth;
      var el_height = el.offsetHeight;

      // Find coordinates of click relative to map element:
      var click_x = ev.offsetX;
      var click_y = ev.offsetY;

      // Calculate position X and Y coordinates:
      var percent_x = (100 / el_width * click_x).toFixed(4);
      var percent_y = (100 / el_height * click_y).toFixed(4);

      if (percent_x < 0) percent_x = 0;
      if (percent_x > 100) percent_x = 100;
      if (percent_y < 0) percent_y = 0;
      if (percent_y > 100) percent_y = 100;

      var field_position_x = document.getElementById('position_x');
      var field_position_y = document.getElementById('position_y');
      field_position_x.value = percent_x;
      field_position_y.value = percent_y;

      window.ExpoMapCoordPickerPositionBlackspot(expo_stands_coordinates_picker, expo_stands_blackspot, percent_x, percent_y);
    });
  });
};

/******************************************************************************/

window.ExpoMapCoordPickerPositionBlackspot = function (expo_map_element, blackspot_element, percent_x, percent_y) {

  var el = document.getElementById(expo_map_element);
  var blackspot = document.getElementById(blackspot_element);
  var el_width = el.offsetWidth;
  var el_height = el.offsetHeight;
  var blackspot_x = (el_width / 100 * percent_x).toFixed(4);
  var blackspot_y = (el_height / 100 * percent_y).toFixed(4);

  blackspot.style.left = blackspot_x + 'px';
  blackspot.style.top = blackspot_y + 'px';
};

/******************************************************************************/

window.ExpoMapCoordSetupImage = function () {

  var map_image_el = document.getElementById('expo_stands_coordinates_picker');
  var blackspot_el = document.getElementById('expo_stands_blackspot');

  if (map_image_el !== null && map_image_el.getAttribute('src').length > 0) {
    map_image_el.style.display = "inline-block";
    blackspot_el.style.display = "inline-block";
  } else {
    map_image_el.style.display = "none";
    blackspot_el.style.display = "none";
  }
};

/******************************************************************************/

window.ExpoMapCoordMapSelect = function (expo_map_list) {

  var expo_map_id_el = document.getElementById('expo_map_id');

  expo_map_id_el.addEventListener("change", function (ev) {

    var map_index = ev.target.value;
    var map_uri = '/storage/' + expo_map_list[map_index];
    var map_image_el = document.getElementById('expo_stands_coordinates_picker');
    var blackspot_el = document.getElementById('expo_stands_blackspot');

    if (map_index !== null && map_index > 0) {
      map_image_el.src = map_uri;
      map_image_el.style.display = "inline-block";
      blackspot_el.style.display = "inline-block";
    } else {
      map_image_el.style.display = "none";
      blackspot_el.style.display = "none";
    }
  }, { passive: true });
};

/******************************************************************************/

/***/ }),

/***/ "./resources/assets/js/admin/users/user-toggle-admin.js":
/***/ (function(module, exports) {

/**
 *
 *  This is used by the users admin screen to toggle admin status of user.
 *
 */

window.otUserToggleAdmin = {
  reqListener: function reqListener() {
    console.log(this.responseText);
  },
  add_admin: function add_admin(id) {
    var oReq = new XMLHttpRequest();
    if (oReq.addEventListener) {
      oReq.addEventListener("load", otUserToggleAdmin.reqListener, false);
    } else if (oReq.attachEvent) {
      oReq.addEventListener("onload", otUserToggleAdmin.reqListener);
    }
    oReq.open("GET", "/user/" + id + "/admin");
    oReq.send();
  },
  rm_admin: function rm_admin(id) {
    var oReq = new XMLHttpRequest();
    oReq.addEventListener("load", otUserToggleAdmin.reqListener);
    oReq.open("GET", "/user/" + id + "/admin/destroy");
    oReq.send();
  }
};

/***/ }),

/***/ "./resources/assets/js/app-admin.js":
/***/ (function(module, exports, __webpack_require__) {


/**
 * This is supplemental JavaScript used by the admin screens.
**/

/** BEGIN: Users ----------------------------------------------------------- **/
__webpack_require__("./resources/assets/js/admin/users/user-toggle-admin.js");
/** END: User--------------------------------------------------------------- **/

/** BEGIN: Expo Stands ----------------------------------------------------- **/
__webpack_require__("./resources/assets/js/admin/touch-screen/expo-stands-coordinates.js");
/** END: Expo Stands ------------------------------------------------------- **/

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/app-admin.js");


/***/ })

/******/ });