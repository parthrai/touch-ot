@extends('layouts.admin-base')

@section('admin_menu')

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Events
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route('home') }}">View Active Events</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Dashboard
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route( 'dashboard', [ 'event_instance_name' => $event_instance_name ] ) }}">Go to Dashboard</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'code-fingerprint.poke', [ 'event_instance_name' => $event_instance_name, 'screen_type' => 'social-wall' ] ) }}">Reload Social Wall Screens</a></li>
      <li><a href="{{ route( 'code-fingerprint.poke', [ 'event_instance_name' => $event_instance_name, 'screen_type' => 'touch-screen' ] ) }}">Reload Touch Screens</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'social-wall', [ 'event_instance_name' => $event_instance_name ] ) }}" target="_blank">Open Social Wall</a></li>
      <li><a href="{{ route( 'tablet', [ 'event_instance_name' => $event_instance_name ] ) }}" target="_blank">Open Touch Screen</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Games
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route( 'configure-teams', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Teams</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'points', [ 'event_instance_name' => $event_instance_name ] ) }}">Points Dashboard</a></li>
      <li><a href="{{ route( 'points.award', [ 'event_instance_name' => $event_instance_name ] ) }}">Award Points</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Social Media
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route( 'social-cards-configs', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Social Cards</a></li>
      <li><a href="{{ route( 'twitter-hashtags', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Twitter Hashtags</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'appworks-posts.dashboard', [  'event_instance_name' => $event_instance_name ] ) }}">Posts Dashboard</a></li>
      <li><a href="{{ route( 'tweets.dashboard', [  'event_instance_name' => $event_instance_name ] ) }}">Tweets Dashboard</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
    Social Wall
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route( 'screens', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Screens</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'announcements', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Announcements</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'countdown', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Countdown</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) }}">Configure Leaderboards</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
    Touch Screens
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">

      <li><a href="{{ route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) }}">Manage Touch Screen Images</a></li>

      <li role="separator" class="divider"></li>

      <li><a href="{{ route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) }}">Agenda Screens</a></li>
      <li><a href="{{ route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance_name ] ) }}">Agenda Announcements</a></li>
      <li><a href="{{ route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance_name ] ) }}">Agenda Schedule Events</a></li>
      <li><a href="{{ route( 'ts-agenda-breakout-sessions', [ 'event_instance_name' => $event_instance_name ] ) }}">Agenda Breakout Sessions</a></li>
    
      <li role="separator" class="divider"></li>
      
      <li><a href="{{ route( 'ts-map-screens', [ 'event_instance_name' => $event_instance_name ] ) }}">Maps</a></li>
    
      <li role="separator" class="divider"></li>
      
      <li><a href="{{ route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance_name ] ) }}">Expo Maps</a></li>
      <li><a href="{{ route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance_name ] ) }}">Expo Stands</a></li>

      <li role="separator" class="divider"></li>
      
      <li><a href="{{ route( 'ts-event-screens', [ 'event_instance_name' => $event_instance_name ] ) }}">Events</a></li>
    
      <li role="separator" class="divider"></li>
      
      <li><a href="{{ route( 'ts-sponsor-screens', [ 'event_instance_name' => $event_instance_name ] ) }}">Sponsors</a></li>
    
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Admin
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li class="dropdown-header">Users</li>
      <li><a href="{{ route( 'users') }}">Users Dashboard</a></li>
      <li><a href="{{ route( 'newuser' ) }}">New User</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'code-fingerprint', [ 'event_instance_name' => $event_instance_name ] ) }}">Code Fingerprint</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="{{ route( 'reports.index', [ 'event_instance_name' => $event_instance_name ] ) }}">Reports</a></li>
    </ul>
  </li>

@endsection
