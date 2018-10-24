<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config( 'app.name', 'OpenText Enterprise World' ) }}</title>

    <style type="text/css">
      /* PREVENT INITIAL FLASH OF UN-STYLED CONTENT */
      body
      {
        display:none;
      }
    </style>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    @yield( 'head' )

  </head>
  <body>
    <div id="app">

      <nav class="navbar navbar-default navbar-static-top">

        <div class="container">

          <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button
              type="button"
              class="navbar-toggle collapsed"
              data-toggle="collapse"
              data-target="#app-navbar-collapse"
            >
              <span class="sr-only">Toggle Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('home') }}">
              {{ config('app.name', 'OpenText Enterprise World') }}
            </a>

          </div>
          <div
            class="collapse navbar-collapse"
            id="app-navbar-collapse"
          >

            <ul class="nav navbar-nav">
              @if( Auth::guest() )
                &nbsp;
              @else
                @if( Auth::user()->is_admin )
                  @yield('admin_menu')
                @endif
              @endif
            </ul>

            @include( 'includes.user-menu' )

          </div>

        </div>
      </nav>

      @yield('content')

    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/app-admin.js') }}"></script>

    @yield('script')

  </body>
</html>
