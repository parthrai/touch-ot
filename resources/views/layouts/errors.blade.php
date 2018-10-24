<!DOCTYPE html>
<html>
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

    <title>Application Error</title>

  </head>
  <body>

    <div id="app">

      <div class="container">

        <div class="row">
          <div
            class="
              col-xs-12
              col-sm-12
              col-md-12
              col-lg-12
            "
          >
            <br>
            @yield('content')
          </div>
        </div>

      </div>

    </div>

    <script src="{{ mix('js/app.js') }}"></script>

  </body>
</html>
