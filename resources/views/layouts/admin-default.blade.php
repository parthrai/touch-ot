@extends('layouts.admin-base')

@section('admin_menu')

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Events
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route( 'home' ) }}">View Active Events</a></li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      Admin
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li class="dropdown-header">Users</li>
      <li><a href="{{ route( 'users' ) }}">Users Dashboard</a></li>
      <li><a href="{{ route( 'newuser' ) }}">New User</a></li>
    </ul>
  </li>

@endsection
