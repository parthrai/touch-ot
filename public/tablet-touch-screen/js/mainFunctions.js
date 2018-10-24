/******************************************************************************/

window.TabletExpoMapCoordPositionBlackspot = function (
  expo_map_element,
  expo_marker_element,
  percent_x,
  percent_y
)
{
  let el               = document.getElementById( expo_map_element );
  let el_width         = el.offsetWidth;
  let el_height        = el.offsetHeight;
  let el_marker        = document.getElementById( expo_marker_element );
  let el_marker_width  = el_marker.offsetWidth;
  let el_marker_height = el_marker.offsetHeight;
  let blackspot_x      = ( ( el_width / 100 ) * percent_x ) - ( el_marker_width / 2 ).toFixed( 4 );
  let blackspot_y      = ( ( el_height / 100 ) * percent_y ) - ( el_marker_height / 2 ).toFixed( 4 );
  let position         = { x: blackspot_x, y: blackspot_y };
  console.log( "BLACKSPOT el_width:", el_width );
  console.log( "BLACKSPOT el_height:", el_height );
  console.log( "BLACKSPOT el_marker_width:", el_marker_width );
  console.log( "BLACKSPOT el_marker_height:", el_marker_height );
  console.log( "BLACKSPOT blackspot_x:", blackspot_x );
  console.log( "BLACKSPOT blackspot_y:", blackspot_y );
  console.log( "BLACKSPOT position:", position );
  return( position );
}

/******************************************************************************/

$(document).ready(
  function ()
  {

  //DISABLING FUNCTIONS FOR TOUCHSCREEN
  ////////////////////////////////////////////

    // Prevent right click context menu
    $("body").bind(
      "contextmenu",
      function ()
      {
        // TODO: Enable this for production:
        //return false;
      }
    );


  //Disable Touch Scroll
    $(document).bind('touchmove', function(e) {
    e.preventDefault();
  });

  //set current section (home) to be visible + margin
  $('.currentSection').css('display', 'block');
  $('.currentSection').css('margin-top', '-30px');


  //reset all tabs
  resetTabs();

  //INITIALIZING
  ////////////////////////////////////////////

  //hide home and menu buttons
  hideTopButtons();

  //initiate local storage
  storage = $.localStorage;

  // reveal main menu on home
  revealHome();

  //set map carousel to default level

  var currentLevel = storage.get('defLevel');
  $('#section-maps .cycle-slideshow').cycle('goto', currentLevel);




  /* DEPRECATED:
  //Notifications
  //AJAX CALL TO GRAB NUMBER OF UPDATES PUBLISHED WITHIN UPDATES DATABASE
  //THIS NUMBER IS DISPLAYED ON ALL UPDATE BADGES
  function getNotificationCount() {
    $.ajax({
      url: "notifications.php",
      dataType:"json",
      success: function (data) {
        var notificationCount = data.notificationCount;
        if (notificationCount != 0) {
          $('.notificationContainer').html('<span>'+notificationCount+'</span>');
          $('.notificationContainer').css({'visibility': 'visible'});
        } else {
          $('.notificationContainer').css({'visibility': 'hidden'});
        }
          }
      });
  }
  getNotificationCount();

  // repeats function at interval
  setInterval(function() {
    getNotificationCount();
  }, 60000);
  */










  //RESETS
  ////////////////////////////////////////////

  //Start the Idle Timer, when timer runs out the reset function is executes
    $.idleTimer(120000);
    $(document).bind("idle.idleTimer", function() {
      if($('body').hasClass('section-home') == false) {
      triggerModal();
    }
    });

    //goes home, and resets entire session (mainly used for session timeout)
    function resetUI() {
    goHome();
      closeModal();

      //tracking click home
      ga_storage._trackPageview('/home', 'Home');
    var homeTotal = storage.get('HomeClicks') + 1;
    storage.set('HomeClicks',homeTotal);
    }


    //reset all carousels, and tabs
    function masterReset() {

      //reset carousels
      resetAllCarousels();

      //reset all scroll panes
      $('#agendaCarousel div').not('.noScroll').mCustomScrollbar("scrollTo","top");
      $('#otPods, #partnerPods').mCustomScrollbar("scrollTo","top");

      //reset expo
      $("#marker").css({'visibility': 'hidden'});
      $('.expoRow').removeClass('rowSelected');

    }



    //resets all of the carousels and sets maps carousel to the default level
    function resetAllCarousels() {

      //sets all carousels to the first slide
      $('#agendaCarousel, #sponsorCarousel, #eventCarousel, #ewGamesCarousel').cycle('goto', 0);

    //sets the map carousel to the default level
      var currentLevel = storage.get('defLevel');
      var currentMapSlide = $('#mapsCarousel.cycle-slideshow').data("cycle.opts").currSlide;

       if(currentLevel != currentMapSlide) {
        $('#section-maps .cycle-slideshow').cycle('goto', currentLevel);
      }

    }











  //NAVIGATION
  ////////////////////////////////////////////

    //Home menu click functions
  $('.mainmenu li').click(function(){

     //get section from data-id for the button clicked
     var nextSection = $(this).data('id');

     //get section number from data-index for the button clicked
     var headerSwitch = $(this).data('index');

     changePages(nextSection, headerSwitch);

     resetTabs();

     });

  //Open the slide menu
  $('#menuButton').click(function(){
    $(this).toggleClass('open');
    slideMenu();
  });

    //goes back to the home pahe
    function goHome() {

     //navigate to home page
     changePages("section-home", 0);

     //track visit
     ga_storage._trackPageview('/Home', 'Home(reset)');
  }

  // change pages

  function changePages(pageTarget, sectionID) {

    window.nextSection = pageTarget;
    window.nextHeader = sectionID;

    $('.currentSection').stop().velocity({
      marginTop: "30px",
      opacity: 0,
      duration: 2000
    }, {
      display: "none",
      complete: function() {

        $('.sectionNames').cycle('goto', window.nextHeader);

        $('#' + window.nextSection).addClass('currentSection');

        //remove section indicator classes
          $('body').removeClass('section-home');
          $('body').removeClass('section-agenda');
          $('body').removeClass('section-maps');
          $('body').removeClass('section-expo');
          $('body').removeClass('section-events');
          $('body').removeClass('section-social');
          $('body').removeClass('section-ewgames');
          $('body').removeClass('section-sponsors');

          //add new class name
          $('body').addClass(window.nextSection);

          //if page is home, hide elements, if not, show nav
          if(window.nextSection == "section-home") {
           hideTopButtons();
          } else {
           showTopButtons();
          }

          //close SlideMenu
           setTimeout(function () {
           closeSlideMenu();
        }, 200);

        //reset all carousels and tabs
        masterReset();

           $('#' + window.nextSection).stop().velocity({
             marginTop: "0px",
          opacity: 1,
          duration: 2000
        }, {
          display: "block",
          complete: function() {

            if (window.nextSection == "section-maps") {
              setMapLevel();

            } else {
              resetTabs();
            }

          }
        });

      }
    });
  }




  //click home button or header to go home
  $('#logo, #homeButton').click(function(){
    goHome();
  });

    // hide the menu button
  function hideTopButtons() {
    $('#menuButton').stop().delay(100).velocity({
      properties: { opacity: 0 },
      options: { duration: 200 },
      easing: "ease-out"
    });
    $('#homeButton').stop().velocity({
      properties: { opacity: 0 },
      options: { duration: 200 },
      easing: "ease-out"
    });
    $('#backgroundImage').delay(300).removeClass('blurBg');
    $('#logo').addClass('logoHome');
  }

  // show the menu button
  function showTopButtons() {
    $('#menuButton').stop().delay(100).velocity({
      properties: { opacity: 1 },
      options: { duration: 200 },
      easing: "ease-out"
    });
    $('#homeButton').stop().velocity({
      properties: { opacity: 1 },
      options: { duration: 200 },
      easing: "ease-out"
    });
    $('#backgroundImage').delay(300).addClass('blurBg');
    $('#logo').removeClass('logoHome');
  }


  function slideMenu() {
    if($('#slideMenu').hasClass('closed')) {

      //add classes to menu div
      $('#slideMenu').removeClass('closed');
      $('#slideMenu').addClass('expanded');

      //turn off home button
      $('#homeButton').fadeOut("fast");

    } else {

      //add classes to menu div
      $('#slideMenu').removeClass('expanded');
      $('#slideMenu').addClass('closed');

      //turn on home button
      $('#homeButton').fadeIn("fast");
    }
  }

  function closeSlideMenu() {
    if($('#slideMenu').hasClass('expanded')) {
      $('#menuButton').toggleClass('open');
      $('#slideMenu').removeClass('expanded');
      $('#slideMenu').addClass('closed');
      $('#homeButton').delay(200).fadeIn("fast");
    }
  }













  //TABBED NAVIGATION
  ////////////////////////////////////////////

  //init tabs
  function resetTabs() {

    $(".materialTabs").each(function() {
      $(this).find('li.active').removeClass('active');
      $(this).find('li:first-child').addClass('active');
      var testButton = $(this).find('li:first-child').outerWidth();

      $(this).find('.slider').css({
          left: 0,
          width: testButton + "px"
        });

    });
  }

  $(".materialTabs li").click(function(e) {

    //control tabs
    var parentContainer = "#" + $(this).closest('.outer').attr('id');
    var prevButtonWidth = $(parentContainer + ' .materialTabs li.active').width();
    var buttonWidth = $(this).outerWidth();
    var howFar = $(this).position();

    $(parentContainer + ' .materialTabs li.slider').css({
      left: howFar.left + "px",
      width: buttonWidth + "px"
    });

    $(".ripple").remove();

    var posX = $(this).offset().left,
        posY = $(this).offset().top,
        buttonWidth = $(this).width(),
        buttonHeight = $(this).height();

    $(this).prepend("<span class='ripple'></span>");

    if (buttonWidth >= buttonHeight) {
      buttonHeight = buttonWidth;
    } else {
      buttonWidth = buttonHeight;
    }

    var x = e.pageX - posX - buttonWidth / 2;
    var y = e.pageY - posY - buttonHeight / 2;

    $(parentContainer + ' .materialTabs .ripple').css({
      width: buttonWidth,
      height: buttonHeight,
      top: y + 'px',
      left: x + 'px'
    }).addClass("rippleEffect");

    var slideIndex = $(this).data('id');

    //control carousel
    $(parentContainer + " .cycle-slideshow").cycle('goto',slideIndex);

  });












  //ANIMATION
  ////////////////////////////////////////////

  //Sequences for home screen icons
  function revealHome() {

    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-agenda').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 200);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-maps').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 300);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-expo').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 400);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-events').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 500);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-social').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 600);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-ewgames').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 700);
    setTimeout(function () {
      $('#section-home .inner .mainmenu li.menuItem-sponsors').stop().velocity({
        properties: { opacity: 1 },
        options: { duration: 200 },
        easing: "ease-out"
      });
    }, 800);
  }


  //Highlight buttons on home screen
    function highlightButtons() {
      $('#section-home .inner .mainmenu li.menuItem-agenda').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
       $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
           $('#section-home .inner .mainmenu li.menuItem-maps').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
             $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
               $('#section-home .inner .mainmenu li.menuItem-expo').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
                 $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
                   $('#section-home .inner .mainmenu li.menuItem-events').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
                     $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
                       $('#section-home .inner .mainmenu li.menuItem-social').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
                         $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
                           $('#section-home .inner .mainmenu li.menuItem-ewgames').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
                             $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 500, function(){
                               $('#section-home .inner .mainmenu li.menuItem-sponsors').animate({backgroundColor: "rgba(149,143,255,0.7)"}, 500, function(){
                                 $(this).animate({backgroundColor: "rgba(149,143,255,0.15)"}, 200, function(){
                                 });
                               });
                             });
                           });
                         });
                       });
                     });
                   });
                 });
               });
             });
           });
        });
      });
    }
    // loop button highlighting
     window.setInterval(function(){
       if($('body').hasClass('section-home')) {
      highlightButtons();
    }
     }, 12000);




















  // MODAL WINDOW

  function triggerModal() {
       $("#number").html(15);
       $('#modal').fadeIn("slow", function() {
      $('#dialog').fadeIn("slow", function() {

        var counter = 15;
        interval = setInterval(function() {
            counter--;
            $("#number").html(counter);
            if (counter == 0) {
              resetUI();
                clearInterval(interval);
            }
        }, 1000);

      });
       });
     }

     function closeModal() {
      $('#modal').fadeOut("slow");
    $('#modal').fadeOut("slow");
    clearInterval(interval);
  }

     $('#okbutton, #modal').click(function(){
       closeModal();
  });










  //VENUE MAP FUNCTIONS

  //place the marker based on coordinates storred in localstorage
  placeYouAreHereMarker();

  //check to see which level the marker is on
  function checkLevel() {

     $('#youAreHere').stop().velocity({opacity: 0.0}, 50);
       var currentLevel = storage.get('defLevel');
       var currentMapSlide = $('#mapsCarousel.cycle-slideshow').data("cycle.opts").currSlide;
       if(currentLevel ===  currentMapSlide) {
       //$('#youAreHere').css({'visibility' : 'visible'});
       $('#youAreHere').stop().velocity({opacity: 1.0}, 200);
       }
     }

     //function to set map level on initialize
  function setMapLevel() {
    var storeLevel = storage.get('defLevel');
    $("#section-maps .materialTabs li").removeClass('currentLevel');
    var tabTarget = $("#section-maps .materialTabs li[data-id='" + storeLevel + "']");
    $(tabTarget).addClass('currentLevel');

    var tabWidth = $(tabTarget).outerWidth();
    var tabDistance = $(tabTarget).position();

    $('#section-maps .materialTabs .slider').css({
        left: tabDistance.left + "px",
        width: tabWidth + "px"
     });

  }

  //store the default level for the touchscreen
  $('#section-maps .materialTabs li').on("taphold", {duration: 5000}, function(){
      var defaultLevel = $(this).data('id');
      $("#section-maps .materialTabs li").removeClass('currentLevel');
      $(this).addClass('currentLevel');
      storage.set('defLevel',defaultLevel);
      $(this).velocity({opacity: 0.25}, 200, function() {
        $(this).velocity({opacity: 1.0}, 200);
      });
  });

  //You Are Here marker drag functions
     $('#youAreHere').draggable({
       delay: 5000,
       stop: function(event, ui) {
         var Stoppos = $(this).position();
         var stopLeft = Stoppos.left;
         var stopTop = Stoppos.top;
         writeCoord(stopLeft, stopTop);
       }
     });

     $('#mapsCarousel.cycle-slideshow').on('cycle-after', function() {
      checkLevel();
  });

     //writes the coordinates to HTML5 localstorage
     function writeCoord(x,y) {
       storage.set('hereX',x);
       storage.set('hereY',y);
     }

     function placeYouAreHereMarker() {
       var storeLCoord = storage.get('hereX');
       var storeTCoord = storage.get('hereY');
    $('#youAreHere').css({top: storeTCoord, left: storeLCoord});
     }



    /**************************************************************************/
    /** BEGIN: EXPO MAP FUNCTIONS + COORDINATES                              **/
    /**************************************************************************/
    /*
    *
    * This section has been rewritten on 2018/10/19.
    *
    */

    // Initiate custom scrollbars for EXPO section
    $( '#otPods, #partnerPods' ).mCustomScrollbar(
      {
        contentTouchScroll: 50,
        mouseWheel: {
          enable: false
        }
      }
    );

    let expo_stands_list     = new Array();
    const expo_stands_struct = jQuery.parseJSON( $("#expo_stands_struct").text() );

    expo_stands_struct.forEach(
      expo_stand => {
        expo_stands_list[expo_stand.stand] = [ expo_stand.position_x, expo_stand.position_y ];
      }
    );
  
    $( '.expoRow' ).click(
      function ()
      {
        $( '.expoRow' ).removeClass( 'rowSelected' );
        $( this ).addClass( 'rowSelected' );
        $( "#marker" ).css( { 'visibility': 'hidden' } );
        let stand_number = $(this).data('number');
        if( stand_number !== null )
        {
          let percentage_coordinates = expo_stands_list[stand_number];
          let position = TabletExpoMapCoordPositionBlackspot(
            "expoMap",
            "marker",
            percentage_coordinates[0],
            percentage_coordinates[1]
          );
          dropMarker( position );
        }
      }
    );

    function dropMarker ( position )
    {
      let newX = position.x;
      let newY = position.y;
      $( '#marker' ).stop().velocity(
        {
          translateY: '0px',
          translateX: newX + 'px'
        },
        0,
        function ()
        {
          $( '#marker' ).css( { 'visibility': 'visible' } );
          $( '#marker' ).stop().velocity( { translateY: ( newY + 100 ) + 'px' }, 500 );
        }
      );
    }

    /**************************************************************************/
    /** END: EXPO MAP FUNCTIONS + COORDINATES                                **/
    /**************************************************************************/

  










     //AGENDA FUNCTIONS

    $(".agendaTable tr.agendaRow:odd, .breakoutTable tr.agendaRow:odd").css("background-color", "rgba(17, 27, 88, 0.05)");
    $(".agendaTable tr.agendaRow:even, .breakoutTable tr.agendaRow:even").css("background-color", "rgba(17, 27, 88, 0.02)");

  $('#agendaCarousel div').not('.noScroll').mCustomScrollbar({
       contentTouchScroll:    10,
       mouseWheel:{ enable: false }
  });

  $('.updateButton').click(function() {
    $('#updateFrame').attr('src', 'updates.php');
    console.log('update frame call');
  });










    /* DEPRECATED:
    //TEAM TWEET FUNCTIONS
    $('.menuItem-ewgames').click(function() {
    $('#leaderboardFrame').attr('src', 'http://otew.io/socialwall/mobile');
    console.log('leader board frame call');
    });
    */


    /**************************************************************************/
    /** BEGIN: GOOGLE ANALYTICS                                              **/
    /**************************************************************************/

    ga_storage._setAccount('UA-56000503-8'); //Replace with your own
    ga_storage._trackPageview('/home', 'Home');
    ga_storage._setDomain('none');

    // Home Screen and Slide Menu button tracking

    //Agenda Buttons
    $('.menuItem-agenda').on('click', function() {
    ga_storage._trackPageview('/agenda', 'Agenda');
    var agendaTotal = storage.get('AgendaClicks') + 1;
    storage.set('AgendaClicks',agendaTotal);
    });

    $('menuItem-maps').on('click', function() {
    ga_storage._trackPageview('/venueMap', 'Venue Map');
    var venueTotal = storage.get('VenueMapClicks') + 1;
    storage.set('VenueMapClicks',venueTotal);
    });

    $('.menuItem-expo').on('click', function() {
    ga_storage._trackPageview('/enterpriseExpo', 'Enterprise Expo');
    var enterpriseExpoTotal = storage.get('EnterpriseExpoClicks') + 1;
    storage.set('EnterpriseExpoClicks',enterpriseExpoTotal);
    });

    $('.menuItem-sponsors').on('click', function() {
    ga_storage._trackPageview('/sponsors', 'Sponsors');
    var sponsorsTotal = storage.get('SponsorsClicks') + 1;
    storage.set('SponsorsClicks',sponsorsTotal);
    });

    $('.menuItem-social').on('click', function() {
    ga_storage._trackPageview('/social', 'Social');
    var socialTotal = storage.get('SocialClicks') + 1;
    storage.set('SocialClicks',socialTotal);
    });

    $('.menuItem-events').on('click', function() {
    ga_storage._trackPageview('/networking', 'Networking');
    var networkingTotal = storage.get('NetworkingClicks') + 1;
    storage.set('NetworkingClicks',networkingTotal);
    });

    $('.menuItem-ewgames').on('click', function() {
    ga_storage._trackPageview('/EWGames', 'Team Tweet');
    var EWGamesTotal = storage.get('EWGamesClicks') + 1;
    storage.set('EWGamesClicks',EWGamesTotal);
    });

    /**************************************************************************/
    /** END: GOOGLE ANALYTICS                                                **/
    /**************************************************************************/

  }
);

/******************************************************************************/
