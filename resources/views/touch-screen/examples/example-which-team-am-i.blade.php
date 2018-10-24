@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <which-team-am-i
    :debug=" false "
    event-instance-name="{{ $event_instance_name }}"
    :schedule-frequency-ms="3000"
  ></which-team-am-i>

@endsection

@section('script')
@endsection
