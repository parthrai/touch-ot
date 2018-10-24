@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <scoreboard-team-members
    team-name="Teal"
    team-hashtag="TL"
    team-background-color="teal"
    team-text-color="white"
    :schedule-frequency-ms="1000"
  ></scoreboard-team-members>

@endsection

@section('script')
@endsection
