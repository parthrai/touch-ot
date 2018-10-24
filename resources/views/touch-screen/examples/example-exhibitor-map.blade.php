@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <exhibitor-map
    :debug=" false "
    event-instance-name="{{ $event_instance_name }}"
    :schedule-frequency-ms="5000"
  ></exhibitor-map>

@endsection

@section('script')
@endsection
