@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <announcement-screen
    :debug=" false "
    :schedule-frequency-ms="3000"
  ></announcement-screen>

@endsection

@section('script')
@endsection
