<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config( 'app.name', 'OpenText' ) }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/public-tablet.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/animate.css">

  </head>
  <body>

    <div id="app" class="public-tablet">

      <div class="container-fluid">
        <v-app>
          <touch-screen></touch-screen>
        </v-app>
      </div>

      <code-fingerprint-monitor
        :debug=" false "
        event-instance-name="{{ $event_instance_name }}"
        screen-type="touch-screen"
        :current-fingerprint="{{ \App\CodeFingerprint::GetCurrentFingerprint( $event_instance, 'touch-screen' )->id }}"
        :schedule-frequency-ms=" 3000 "
      ></code-fingerprint-monitor>

    </div>

  </body>
</html>
