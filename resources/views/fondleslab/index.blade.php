<!DOCTYPE html>
<html
  lang="{{ str_replace( '_', '-', app()->getLocale()) }}"
  class="fondleslab"
>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config( 'app.name', 'OpenText' ) }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/fondleslab.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" type="text/css" href="/css/fondleslab.css">

  </head>
  <body>

    <div id="app">

      <wallpaper-rorschach-dark
        :debug="false"
        :transition-frequency-ms="8333"
      ></wallpaper-rorschach-dark>

      <div class="fondleslab-root">

        <div
          class="
            fondleslab-pads
            fondleslab-pads-enter-active
            fondleslab-pads-enter-to
          "
        >

          <div
            id="fp_pad_agenda"
            data-fondleslab-screen="fp_screen_agenda"
            class="fondleslab-pad fondleslab-pad-vhalf"
          >
            <div class="fondleslab-pad-label">Agenda</div>
          </div>

          <div
            id="fp_pad_map"
            data-fondleslab-screen="fp_screen_map"
            class="fondleslab-pad fondleslab-pad-vquarter"
          >
            <div class="fondleslab-pad-label">Map</div>
          </div>

          <div
            id="fp_pad_expo"
            data-fondleslab-screen="fp_screen_expo"
            class="fondleslab-pad fondleslab-pad-vquarter"
          >
            <div class="fondleslab-pad-label">Expo</div>
          </div>

          <div
            id="fp_pad_events"
            data-fondleslab-screen="fp_screen_events"
            class="fondleslab-pad fondleslab-pad-vhalf"
          >
            <div class="fondleslab-pad-label">Events</div>
          </div>
          
          <div
            id="fp_pad_games"
            data-fondleslab-screen="fp_screen_games"
            class="fondleslab-pad fondleslab-pad-vhalf"
          >
            <div class="fondleslab-pad-label">EW Games</div>
          </div>

          <div
            id="fp_pad_social"
            data-fondleslab-screen="fp_screen_social"
            class="fondleslab-pad fondleslab-pad-vhalf"
          >
            <div class="fondleslab-pad-label">Social</div>
          </div>
          
          <div
            id="fp_pad_sponsors"
            data-fondleslab-screen="fp_screen_sponsors"
            class="fondleslab-pad fondleslab-pad-vhalf"
          >
            <div class="fondleslab-pad-label">Sponsors</div>
          </div>

        </div>

        <div class="fondleslab-content">

          <div
            id="fp_screen_agenda"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_agenda"
            >X</span>
            AGENDA SCREEN
          </div>

          <div
            id="fp_screen_map"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_map"
            >X</span>
            MAP SCREEN
          </div>

          <div
            id="fp_screen_events"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_events"
            >X</span>
            EVENTS SCREEN
          </div>

          <div
            id="fp_screen_expo"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_expo"
            >X</span>
            EXPO SCREEN
          </div>

          <div
            id="fp_screen_games"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_games"
            >X</span>
            EW GAMES SCREEN
            <which-team-am-i
              :debug=" false "
              event-instance-name="{{ $event_instance_name }}"
              :schedule-frequency-ms="3000"
            ></which-team-am-i>
          </div>

          <div
            id="fp_screen_social"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_social"
            >X</span>
            SOCIAL SCREEN
          </div>

          <div
            id="fp_screen_sponsors"
            class="
              fondleslab-screen
              fondleslab-screen-leave-active
              fondleslab-screen-leave-to
            "
          >
            <span
              class="fondleslab-screen-close"
              data-fondleslab-screen="fp_screen_sponsors"
            >X</span>
            SPONSORS SCREEN
          </div>

        </div>

      </div>

      <code-fingerprint-monitor
        :debug=" false "
        screen-type="touch-screen"
        :current-fingerprint="{{ \App\CodeFingerprint::GetCurrentFingerprint( $event_instance_name, 'touch-screen' )->id }}"
        :schedule-frequency-ms=" 3000 "
      ></code-fingerprint-monitor>

    </div>

  </body>
</html>
