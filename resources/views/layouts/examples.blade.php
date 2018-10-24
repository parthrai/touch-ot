<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    <title>OpenText Enterprise World - Social Wall</title>

  </head>
  <body class="wonder-wall">

    <div id="app">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('js-static')
    @yield('script')

  </body>
</html>
