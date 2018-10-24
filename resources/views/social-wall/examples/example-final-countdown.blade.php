@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <div>
    <final-countdown
      :debug=" false "
      title="Final Countdown to Enterprise World 2019"
      target-date="2018-09-13T09:30:00"
      :recalc-frequency-ms="1000"
      :dots-frequency-ms="1000"
    ></final-countdown>
  </div>

  {{--

  <seven-segment-display
    :debug=" false "
    :digit=" null "
    :width=" 700 "
    :height=" 1200 "
  ></seven-segment-display>

  @for( $i = 0 ; $i <= 9 ; $i++ )
    <seven-segment-display
      :debug=" false "
      :digit="{{ $i }}"
      :width=" 700 "
      :height=" 1200 "
    ></seven-segment-display>
  @endfor

  --}}

@endsection

@section('script')
{{--
  <script type="text/javascript">

    let MS_PER_DAY         = 1000 * 60 * 60 * 24;
    let MS_PER_HOUR        = 1000 * 60 * 60;
    let MS_PER_MINUTE      = 1000 * 60;
    let MS_PER_SECOND      = 1000;
    let MS_PER_MILLISECOND = 1;
    let current_date       = new Date( Date.now() );
    let target_date        = new Date( '2018-09-13T09:30:00' );
    let current_date_value = current_date.valueOf();
    let target_date_value  = target_date.valueOf();

    var tempus = {
      days: [],
      hours: [],
      minutes: [],
      seconds: [],
      milliseconds: []
    };

    console.log( "current_date_value:", current_date_value );
    console.log( "target_date_value:", target_date_value );

    if( target_date_value > current_date_value )
    {

      let diff_days          = Math.floor( ( target_date_value - current_date_value ) / MS_PER_DAY );
      let diff_days_value    = diff_days * MS_PER_DAY;
      let diff_hours         = Math.floor( ( target_date_value - current_date_value - diff_days_value ) / MS_PER_HOUR );
      let diff_hours_value   = diff_hours * MS_PER_HOUR;
      let diff_minutes       = Math.floor( ( target_date_value - current_date_value - diff_days_value - diff_hours_value ) / MS_PER_MINUTE );
      let diff_minutes_value = diff_minutes * MS_PER_MINUTE;
      let diff_seconds       = Math.floor( ( target_date_value - current_date_value - diff_days_value - diff_hours_value - diff_minutes_value ) / MS_PER_SECOND );
      let diff_seconds_value = diff_seconds * MS_PER_SECOND;
      let diff_milliseconds  = Math.floor( ( target_date_value - current_date_value - diff_days_value - diff_hours_value - diff_minutes_value - diff_seconds_value ) / MS_PER_MILLISECOND );

      console.log( "diff_days:", diff_days );
      console.log( "diff_hours:", diff_hours );
      console.log( "diff_minutes:", diff_minutes );
      console.log( "diff_seconds:", diff_seconds );
      console.log( "diff_milliseconds:", diff_milliseconds );

      tempus.days         = diff_days.toString().replace( /^(.)$/, ["0",diff_days].join('') ).split('');
      tempus.hours        = diff_hours.toString().replace( /^(.)$/, ["0",diff_hours].join('') ).split('');
      tempus.minutes      = diff_minutes.toString().replace( /^(.)$/, ["0",diff_minutes].join('') ).split('');
      tempus.seconds      = diff_seconds.toString().replace( /^(.)$/, ["0",diff_seconds].join('') ).split('');
      tempus.milliseconds = diff_milliseconds.toString().replace( /^(.)$/, ["0",diff_milliseconds].join('') ).split('');

      console.log( "tempus:", tempus );
      console.log( "tempus.days:", tempus.days );
      console.log( "tempus.hours:", tempus.hours );
      console.log( "tempus.minutes:", tempus.minutes );
      console.log( "tempus.seconds:", tempus.seconds );
      console.log( "tempus.milliseconds:", tempus.milliseconds );

    }
    else
    {
      console.log( "Temporal Displacement Error!" );
    }

  </script>
--}}
@endsection
