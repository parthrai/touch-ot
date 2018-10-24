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
    <!--<script src="/js/fondleslab.js" defer></script>-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" type="text/css" href="/css/fondleslab.css">

  </head>
  <body>

    <div id="app">

      <wallpaper-rorschach
        :debug="false"
        :transition-frequency-ms="8333"
      ></wallpaper-rorschach>

      <h1>Routing</h1>
      <p>
        <router-link to="/">Go home</router-link>
        <router-link to="/Agenda">Go to Agenda</router-link>
        <router-link to="/Expo">Go to Expo</router-link>
      </p>

      <router-view></router-view>

    </div>

  </body>
</html>
