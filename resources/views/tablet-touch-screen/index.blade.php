<html>
  <head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Enterprise World 2018</title>

    <!--Scripts-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

    <!--
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/velocity.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.easing.1.3.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.scrollVert.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.idle-timer.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.swipe.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery-ui.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/taphold.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.ui.touch-punch.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/GALocalStorage.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.storageapi.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/taphold.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.mCustomScrollbar.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.color.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/mainFunctions.js' ) }}"></script>
    -->

    <!--Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{ mix( 'tablet-touch-screen/css/main.css' ) }}">

  </head>
  <body class="section-home">

    <div id="app">

      <img id="backgroundImage" class="blurBg" src="{{ asset( 'tablet-touch-screen/images/ew-background.png' ) }}" alt="" />

      <!-- Modal window -->
      <div id="modal">
        <div id="dialog">
          <h5>Are you still there?</h5>
          <span class="reset">This kiosk will reset in <span id="number">15</span> seconds</span>
          <a id="okbutton" href="#">Touch anywhere to resume</a>
        </div>
      </div>


      <!--Fixed Position Header-->
      <header>

        <img src="{{ asset( 'tablet-touch-screen/images/opentext-ew-logo.png' ) }}" class="logoHome" id="logo" />

        <div id="sectionIndicator" class="sectionNames cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-fx="scrollVert" data-cycle-speed="500" data-cycle-paused="true">

          <div>&nbsp;</div>
          <div>Agenda</div>
          <div>Maps</div>
          <div>Expo</div>
          <div>Events</div>
          <div>Social</div>
          <div>The EW Games</div>
          <div>Sponsors</div>

        </div>

      </header>

      <!--Slide Out menu-->
      <div id="slideMenu" class="closed">
        <ul class="mainmenu">
          <li class="menuItem-agenda" data-id="section-agenda" data-index="1"><span>Agenda</span></li>
          <li class="menuItem-maps" data-id="section-maps" data-index="2"><span>Maps</span></li>
          <li class="menuItem-expo" data-id="section-expo" data-index="3"><span>Expo</span></li>
          <li class="menuItem-events" data-id="section-events" data-index="4"><span>Events</span></li>
          <li class="menuItem-social" data-id="section-social" data-index="5"><span>Social</span></li>
          <li class="menuItem-ewgames" data-id="section-ewgames" data-index="6"><span>The EW Games</span></li>
          <li class="menuItem-sponsors" data-id="section-sponsors" data-index="7"><span>Sponsors</span></li>
        </ul>
      </div>

      <div id="mainCarousel" class="sections" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-fx="fade" data-cycle-speed="500" >

        <!-- BEGIN: TABLET ICONS SCREEN ************************************ -->
        <div id="section-home" class="outer currentSection">
          <div class="inner">
            <!-- Main Menu -->
            <ul class="mainmenu">
              <li class="menuItem-agenda" data-id="section-agenda" data-index="1"><span>Agenda</span></li>
              <li class="menuItem-maps" data-id="section-maps" data-index="2"><span>Maps</span></li>
              <li class="menuItem-expo" data-id="section-expo" data-index="3"><span>Expo</span></li>
              <li class="menuItem-events" data-id="section-events" data-index="4"><span>Events</span></li>
              <li class="menuItem-social" data-id="section-social" data-index="5"><span>Social</span></li>
              <li class="menuItem-ewgames" data-id="section-ewgames" data-index="6"><span>The EW Games</span></li>
              <li class="menuItem-sponsors" data-id="section-sponsors" data-index="7"><span>Sponsors</span></li>
            </ul>
          </div>
        </div>
        <!-- END: TABLET ICONS SCREEN ************************************** -->




        <!-- BEGIN: AGENDA TAB SCREEN ************************************** -->
        <div id="section-agenda" class="outer">

          <div class="inner">

            <!-- Agenda Material design tabs -->
            <ul class="materialTabs">
              @foreach( $agenda as $day )
                <li
                  data-id="{{ $day['day_index'] }}"
                  class="{{ $day['day_index'] == 0 ? 'active' : '' }}"
                >{{ $day['tab_label'] }}</li>
              @endforeach
              <li class="slider"></li>
            </ul>

            <hr class="rule">

            <!-- BEGIN: AGENDA CAROUSEL ************************************ -->
            <div
              id="agendaCarousel"
              class="cycle-slideshow"
              data-cycle-slides="> div"
              data-cycle-timeout="0"
              data-cycle-fx="scrollHorz"
              data-cycle-speed="500"
            >

              @foreach( $agenda as $day )

                {{-- BEGIN: IMAGE TAB SCREEN ------------------------------ --}}
                @if( $day['type'] == 'image' )
                  <div class="noScroll">
                    <img src="{{ $day['image']['image_lg'] }}" alt="" />
                  </div>
                @endif
                {{-- END: IMAGE TAB SCREEN -------------------------------- --}}

                {{-- BEGIN: ANNOUNCEMENT TAB SCREEN ----------------------- --}}
                @if( $day['type'] == 'announcement' )
                  <div class="noScroll">
                    <p class="agenda-announcement">{{ $day['announcement'] }}</p>
                  </div>
                @endif
                {{-- END: ANNOUNCEMENT TAB SCREEN ------------------------- --}}

                {{-- BEGIN: SCHEDULE TAB SCREEN --------------------------- --}}
                @if( $day['type'] == 'schedule' )
                  <div class="">
                    @if( array_key_exists( 'schedule', $day ) )
                      @if( count( $day['schedule']['events'] ) > 0 )
                        <h3>{{ $day['schedule']['title'] }}</h3>
                        <table class="agendaTable">
                          <tr>
                            <th colspan="3">{{ $day['date_display'] }}</th>
                          </tr>
                          @foreach( $day['schedule']['events'] as $event )
                            <tr class="agendaRow ">
                              <td class="agendaCol agendaTime">{{ $event['time_range'] }}</td>
                              <td class="agendaCol agendaDescription">{{ $event['title'] }}</td>
                              <td class="agendaCol agendaLocation">{{ $event['location'] }}</td>
                            </tr>
                          @endforeach
                        </table>
                      @endif
                    @endif
                    @if( array_key_exists( 'breakout', $day ) )
                      @if( count( $day['breakout']['session_blocks'] ) > 0 )
                        <h3>{{ $day['breakout']['title'] }}</h3>
                        @foreach( $day['breakout']['session_blocks'] as $session_block )
                          <table class="breakoutTable">
                            <thead>
                              <th colspan="3">{{ $session_block['time_range'] }}</th>
                            </thead>
                            <tbody>
                              @foreach( $session_block['events'] as $event )
                                <tr class="agendaRow">
                                  <td class="agendaCol cloudCol">
                                    <img
                                      src="{{ asset( 'tablet-touch-screen/images/logo-otcloud.png' ) }}"
                                      alt=""
                                      style="visibility:hidden;"
                                  /></td>
                                  <td class="agendaCol cloudDescription">
                                    {{ $event['title'] }}
                                  </td>
                                  <td class="agendaCol agendaLocation">
                                    {{ $event['location'] }}
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @endforeach
                      @endif
                    @endif
                  </div>
                @endif
                {{-- END: SCHEDULE TAB SCREEN ----------------------------- --}}

              @endforeach

            </div>
            <!-- END: AGENDA CAROUSEL ************************************** -->

          </div><!-- end inner -->

        </div><!-- end outer agenda -->
        <!-- END: AGENDA TAB SCREEN **************************************** -->




        <!-- BEGIN: MAPS TAB SCREEN **************************************** -->
        <div id="section-maps" class="outer">

          <div class="inner">

            {{-- BEGIN: YOU ARE HERE MARKER ------------------------------- --}}
            <you-are-here-dot
              :debug=" false "
              event-instance-name="{{ $event_instance->name }}"
              container-id="youAreHere"
              label="You are here"
            ></you-are-here-dot>
            {{-- ORIGINAL:
            <div id="youAreHere">
              <span class="message">You are here</span>
              <svg height="60" width="60">
                <g>
                  <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
                    <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" repeatCount="indefinite" />
                    <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" repeatCount="indefinite" />
                  </circle>
                  <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
                    <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" begin="0.5s" repeatCount="indefinite" />
                    <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" begin="0.5s" repeatCount="indefinite" />
                  </circle>
                  <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
                    <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" begin="1s" repeatCount="indefinite" />
                    <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" begin="1s" repeatCount="indefinite" />
                  </circle>
                  <circle cx="28" cy="28" r="5" fill="#D92A32" stroke="#D92A32">
                  </circle>
                </g>
              </svg>
            </div>
            --}}
            {{-- END: YOU ARE HERE MARKER --------------------------------- --}}

            <!-- Maps Material design tabs -->
            <ul class="materialTabs">
              @foreach( $map_screens as $map )
                <li
                  data-id="{{ $map['map_index'] }}"
                >{{ $map['tab_label'] }}</li>
              @endforeach
              <li class="slider"></li>
            </ul>

            <hr class="rule">

            <!-- Event Carousel -->
            <div
              id="mapsCarousel"
              class="cycle-slideshow overlay"
              data-cycle-slides="> div"
              data-cycle-timeout="0"
              data-cycle-fx="scrollHorz"
              data-cycle-speed="500"
            >
              @foreach( $map_screens as $map )
                <div id="level{{ $map['map_index'] }}">
                  <h2>{{ $map['caption'] }}</h2>
                  <img src="{{ $map['image_lg'] }}" alt="" />
                </div>
              @endforeach
            </div>

          </div>

        </div>
        <!-- END: MAPS TAB SCREEN ****************************************** -->




        <!-- BEGIN: EXPO MAP SCREEN **************************************** -->
        <!-- Slide 4 Container -->
        <div id="section-expo" class="outer">

          <!-- Slide 1 -->
          <div class="inner">

          <!-- Expo booth pane -->
            <div id="boothFinder">

              <!-- Expo Material design tabs -->
                <ul class="materialTabs">
                <li data-id="0" class="opentextTab">&nbsp;&nbsp;OpenText&nbsp;&nbsp;</li>
                <li data-id="1" class="partnerTab">&nbsp;&nbsp;Partners&nbsp;&nbsp;</li>
                <li class="slider"></li>
              </ul>

              <hr class="rule">

              <!-- Lists of booths and pods in a carousel with two slides -->
              <div
                id="listCarousel"
                class="cycle-slideshow"
                data-cycle-slides="> div"
                data-cycle-timeout="0"
                data-cycle-fx="scrollHorz"
                data-cycle-speed="500"
              >

                <div id="otPods">
                  <table class="expoList">
                    <tbody>
                      @foreach( $expo_stands as $expo_stand )
                        @if( strtolower( $expo_stand['type'] ) == "opentext" )
                          <tr class="expoRow" data-number="{{ $expo_stand['stand'] }}">
                            <td class="rowName">{{ $expo_stand['exhibitor'] }}</td>
                            <td class="rowNumber">{{ $expo_stand['stand'] }}</td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <div id="partnerPods">
                  <table class="expoList">
                    <tbody>
                      @foreach( $expo_stands as $expo_stand )
                        @if( strtolower( $expo_stand['type'] ) == "partner" )
                          <tr class="expoRow" data-number="{{ $expo_stand['stand'] }}">
                            <td class="rowName">{{ $expo_stand['exhibitor'] }}</td>
                            <td class="rowNumber">{{ $expo_stand['stand'] }}</td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>

              </div><!--   End list carousel -->

            </div><!-- End booth pane -->

            <!-- BEGIN: EXPO MAP CONTAINER ********************************* -->
            <!-- DOESN'T WORK
            <expo-map-display
              :debug=" false "
              event-instance-name="{{ $event_instance->name }}"
              container-id="expoMap"
              map-image-id="expoMapImage"
              map-image="{{ asset( 'tablet-touch-screen/images/expomap.png' ) }}"
              marker-id="marker"
            ></expo-map-display>
            -->


            <!-- Expo Map Container -->
            <div id="expoMap">
              <!-- MARKER -->
              <div id="marker">
                <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  viewBox="0 0 32.8 55" style="enable-background:new 0 0 32.8 55;" xml:space="preserve">
                <circle class="st2" cx="16.4" cy="16.6" r="13" />
                <circle class="st0" cx="16.4" cy="16.6" r="9.3">
                  <animate attributeType="xml" attributeNAMe="r" from="0" to="9.3" dur="0.5s" repeatCount="indefinite" />
                    <animate attributeType="xml" attributeNAMe="fill-opacity" from="1.0" to="0" dur="0.5s" repeatCount="indefinite" />
                </circle>
                </svg>
              </div>
             </div><!-- End Expo Map Container -->



            {{-- ORIGINAL:
            <!-- Expo Map Container -->
            <div id="expoMap">
              <!-- MARKER -->
              <div id="marker">
                <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  viewBox="0 0 32.8 55" style="enable-background:new 0 0 32.8 55;" xml:space="preserve">
                <style type="text/css">
                  .st0{fill:#D92A32;}
                  .st2{fill:none;stroke:#D92A32;;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                </style>
                <circle class="st2" cx="16.4" cy="16.6" r="13" />
                <circle class="st0" cx="16.4" cy="16.6" r="9.3">
                  <animate attributeType="xml" attributeNAMe="r" from="0" to="9.3" dur="0.5s" repeatCount="indefinite" />
                    <animate attributeType="xml" attributeNAMe="fill-opacity" from="1.0" to="0" dur="0.5s" repeatCount="indefinite" />
                </circle>
                </svg>
              </div>
             </div><!-- End Expo Map Container -->
             --}}
            <!-- END: EXPO MAP CONTAINER *********************************** -->

          </div>

        </div>
        <!-- END: EXPO MAP SCREEN ****************************************** -->




        <!-- BEGIN: EVENTS TAB SCREEN ************************************** -->
        <div id="section-events" class="outer">

          <div class="inner">

            <ul class="materialTabs">
              @foreach( $event_screens as $event )
                <li
                  data-id="{{ $event['event_index'] }}"
                  class="{{ $event['event_index'] == 0 ? 'active' : '' }}"
                >{{ $event['tab_label'] }}</li>
              @endforeach
              <li class="slider"></li>
            </ul>

            <hr class="rule">

            <div id="eventsCarousel" class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-fx="scrollHorz" data-cycle-speed="500" data-cycle-swipe=true>
              @foreach( $event_screens as $event )
                <div>
                  <img src="{{ $event['image_lg'] }}" alt="" />
                </div>
              @endforeach
            </div>

          </div>

        </div>
        <!-- BEGIN: EVENTS TAB SCREEN ************************************** -->




        <!-- BEGIN: SOCIAL TAB SCREEN ************************************** -->
        <div id="section-social" class="outer">
          <div class="inner overlay">
            <img src="{{ asset( 'tablet-touch-screen/images/social.png' ) }}" alt="" />
          </div>
        </div>
        <!-- END: SOCIAL TAB SCREEN **************************************** -->




        <!-- BEGIN: EW GAMES TAB SCREEN ************************************ -->
        <div id="section-ewgames" class="outer">

          <div class="inner">

            <!-- EW Games Material design tabs -->
              <ul class="materialTabs">
              <li data-id="0" class="leaderboardButton">Leaderboard</li>
              <li data-id="1">Teams</li>
              <li data-id="2">How to score</li>
              <li data-id="3">Prizes</li>
              <li data-id="4">Surveys</li>
              <li data-id="5">Rules</li>
              <li class="slider"></li>
            </ul>

            <hr class="rule">

            <div id="ewGamesCarousel" class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-fx="scrollHorz" data-cycle-speed="500" >

              <div>
                <div
                  id="leaderboardCarousel"
                  class="cycle-slideshow"
                  data-cycle-allow-wrap="true"
                  data-cycle-slides="> div"
                  data-cycle-timeout="3000"
                  data-cycle-fx="scrollHorz"
                  data-cycle-speed="500" 
                >
                  @foreach( \App\Leaderboard::GetLeaderboardOrders( $event_instance->name ) as $order )
                    <div>
                      <leaderboard-screen
                        :debug=" false "
                        event-instance-name="{{ $event_instance->name }}"
                        :screen-order="{{ $order }}"
                        :schedule-frequency-ms="10000"
                      ></leaderboard-screen>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="overlay">
                <!-- ORIGINAL:
                <img src="{{ asset( 'tablet-touch-screen/images/ewgames-teams.png' ) }}" alt="" />
                -->
                <which-team-am-i
                  :debug=" false "
                  event-instance-name="{{ $event_instance->name }}"
                  :schedule-frequency-ms="5000"
                ></which-team-am-i>
              </div>
              
              <div class="overlay">
                <img src="{{ asset( 'tablet-touch-screen/images/ewgames-score.png' ) }}" alt="" />
              </div>
              
              <div class="overlay">
                <img src="{{ asset( 'tablet-touch-screen/images/ewgames-prizes.png' ) }}" alt="" />
              </div>
              
              <div class="overlay">
                <img src="{{ asset( 'tablet-touch-screen/images/survey-prizes.png' ) }}" alt="" />
              </div>

              <div class="overlay">
                <img src="{{ asset( 'tablet-touch-screen/images/ewgames-rules.png' ) }}" alt="" />
              </div>
              
            </div>

          </div>

        </div>
        <!-- END: EW GAMES TAB SCREEN ************************************** -->




        <!-- BEGIN: SPONSORS TAB SCREEN ************************************ -->
        <div id="section-sponsors" class="outer">

          <div class="inner">

            <ul class="materialTabs">
              @foreach( $sponsor_screens as $sponsor )
                <li
                  data-id="{{ $sponsor['sponsor_index'] }}"
                  class="{{ $sponsor['sponsor_index'] == 0 ? 'active' : '' }}"
                >{{ $sponsor['tab_label'] }}</li>
              @endforeach
              <li class="slider"></li>
            </ul>

            <hr class="rule">

            <div id="sponsorCarousel" class="cycle-slideshow" data-cycle-timeout="0" data-cycle-fx="scrollHorz" data-cycle-speed="500">
              @foreach( $sponsor_screens as $sponsor )
                <img src="{{ $sponsor['image_lg'] }}" alt="" />
              @endforeach
            </div>

          </div>

        </div>
        <!-- END: SPONSORS TAB SCREEN ************************************** -->

      </div><!-- END: id="app" -->




      <!-- BEGIN: FOOTER WITH MENU ***************************************** -->
      <footer>

        <!-- Menu Button -->
        <div id="menuButton">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <!-- BEGIN: Tablet Home Button ************************************* -->
        <tablet-home-button
          :debug=" false "
          event-instance-name="{{ $event_instance->name }}"
          container-id="homeButton"
        ></tablet-home-button>
        {{-- ORIGINAL:
        <!-- Home Button -->
        <div id="homeButton">
          <svg
            version="1.1"
            id="Layer_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 52 52"
            style="enable-background:new 0 0 52 52;"
            xml:space="preserve"
          >
            <style type="text/css">
              .st1{fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
              /* .st1{fill:#000000;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} */
            </style>
            <polygon
              class="st1"
              points="29.2,39.1 29.2,32.7 22.8,32.7 22.8,39.1 16.9,39.1 16.9,26.7 12.2,26.7 26,12.9 39.8,26.7 35.1,26.7 35.1,39.1 "
            />
          </svg>
        </div>
        --}}
        <!-- END: Tablet Home Button *************************************** -->


      </footer><
      <!-- END: FOOTER WITH MENU ******************************************* -->

      <code-fingerprint-monitor
        :debug=" false "
        event-instance-name="{{ $event_instance->name }}"
        screen-type="touch-screen"
        :current-fingerprint="{{ \App\CodeFingerprint::GetCurrentFingerprint( $event_instance, 'touch-screen' )->id }}"
        :schedule-frequency-ms=" 5000 "
      ></code-fingerprint-monitor>

    </div>

    <!-- BEGIN: VUE SCRIPTS ************************************************ -->
    <script type="text/javascript" src="{{ mix( 'js/app-tablet-touch-screen.js' ) }}"></script>
    <!-- END: VUE SCRIPTS ************************************************** -->

    <!-- BEGIN: JQUERY PLUGINS ********************************************* -->
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/velocity.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.easing.1.3.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.scrollVert.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.idle-timer.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.cycle2.swipe.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery-ui.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/taphold.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.ui.touch-punch.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/GALocalStorage.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.storageapi.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/taphold.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.mCustomScrollbar.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/jquery.color.js' ) }}"></script>
    <!-- END: JQUERY PLUGINS *********************************************** -->

    <!-- BEGIN: APPLICATION SCRIPTS **************************************** -->
    <script type="application/json" id="expo_stands_struct">
      {!! json_encode( $expo_stands ) !!}
    </script>
    <script type="text/javascript" src="{{ asset( 'tablet-touch-screen/js/mainFunctions.js' ) }}"></script>
    <!-- END: APPLICATION SCRIPTS ****************************************** -->


    <!-- BEGIN: PUSHER SCRIPTS ********************************************* -->
    <!--
    <script type="text/javascript" src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script type="text/javascript">

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = false;

      var pusher = new Pusher(
        'cd07fe7bf8a634a4d4e2',
        {
          wsHost: 'ws.pusherapp.com',
          httpHost: 'sockjs.pusher.com',
          encrypted: true
        }
      );

      var channel = pusher.subscribe('otew-channel');
      channel.bind(
        'mt-refresh',
        function( data )
        {
          location.reload();
        }
      );
    </script>
    -->
    <!-- END: PUSHER SCRIPTS *********************************************** -->

  </body>
</html>
