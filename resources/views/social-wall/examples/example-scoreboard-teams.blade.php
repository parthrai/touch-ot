@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <scoreboard-teams
    :schedule-frequency-ms="1000"
  ></scoreboard-teams>

@endsection

@section('script')
@endsection
