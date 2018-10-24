<!DOCTYPE html>
<html class="wonder-wall">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">

    <style type="text/css">
      /* PREVENT INITIAL FLASH OF UN-STYLED CONTENT */
      body
      {
        display:none;
      }
    </style>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    <title>OpenText Enterprise World - Social Wall</title>

  </head>
  <body class="wonder-wall">

    <div id="app">
  
      <div class="container-fluid">

        <header-strip-enterprise-world label="The EW Games"></header-strip-enterprise-world>

        @yield('content')

      </div>
  
      <code-fingerprint-monitor
        :debug=" false "
        event-instance-name="{{ $event_instance_name }}"
        screen-type="social-wall"
        :current-fingerprint="{{ \App\CodeFingerprint::GetCurrentFingerprint( $event_instance, 'social-wall' )->id }}"
        :schedule-frequency-ms=" 3000 "
      ></code-fingerprint-monitor>

    </div>

    <script type="text/javascript" src="{{ mix( 'js/app.js' ) }}"></script>
    @yield('js-static')
    @yield('script')

  </body>
</html>
