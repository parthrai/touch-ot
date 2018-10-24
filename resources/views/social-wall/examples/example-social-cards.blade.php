@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <social-cards-columns
    :debug="true"
    :max-cards="30"
    :max-featured-cards="2"
    :schedule-frequency-ms="1000"
  ></social-cards-columns>

  {{--
  <div class="outer-columns">
    <div class="special-block">
      SPECIAL BLOCK
    </div>
    <div class="inner-columns">
      @for( $i = 1 ; $i <= 100 ; $i++ )
        <div class="a-block">
          BLOCK: {{ $i }}
        </div>
      @endfor
    </div>
  </div>
  --}}

@endsection

@section('script')
{{--
  <style type="text/css">

    .outer-columns
    {
      column-count:4;
      background-color:red;
    }

    .inner-columns
    {
      column-count:2;
      background-color:yellow;
    }

    .special-block
    {
      background-color:#00AA00;
      color:#FFFFFF;
      column-span:none;
    }

    .a-block
    {
      margin:5px;
      border-style:solid;
      border-width:2px;
      border-color:black;
    }

  </style>
--}}
@endsection
