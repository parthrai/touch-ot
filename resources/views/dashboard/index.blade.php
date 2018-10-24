@extends('layouts.admin-event')

@section('content')
  <div class="container">

    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-12
          col-lg-12
        "
      >
        @include( 'includes.flash-messages' )
      </div>
    </div>

    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-6
          col-lg-6
        "
      >

        <!-- BEGIN: LEFT COLUMN ******************************************** -->

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Refresh Screens</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-danger" href="{{ route( 'code-fingerprint.poke', [ 'event_instance_name' => $event_instance_name, 'screen_type' => 'touch-screen' ] ) }}">Reload Touch Screens</a></li>
                <li><a class="btn btn-danger" href="{{ route( 'code-fingerprint.poke', [ 'event_instance_name' => $event_instance_name, 'screen_type' => 'social-wall' ] ) }}">Reload Social Wall Screens</a></li>
              </ul>
            </div>
          </div>
        @endif
          
        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Social Wall</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-success" href="{{ route( 'social-wall', [ 'event_instance_name' => $event_instance_name ] ) }}" target="_blank">Open Social Wall</a></li>
                <li><a class="btn btn-danger" href="{{ route( 'social-wall', [ 'event_instance_name' => $event_instance_name, 'debug' => true ] ) }}" target="_blank">Open Social Wall in Debug Mode</a></li>
              </ul>
            </div>
          </div>
        @endif

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Tablets</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-success" href="{{ route( 'tablet', [ 'event_instance_name' => $event_instance_name ] ) }}" target="_blank">Open Tablet Touch Screen</a></li>
                <li><a class="btn btn-danger" href="{{ route( 'tablet', [ 'event_instance_name' => $event_instance_name, 'debug' => true ] ) }}" target="_blank">Open Tablet Touch Screen in Debug Mode</a></li>
              </ul>
            </div>
          </div>
        @endif

        <!--
        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Touch Screens</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-success" href="{{ route( 'touch-screen', [ 'event_instance_name' => $event_instance_name ] ) }}" target="_blank">Open Touch Screen</a></li>
                <li><a class="btn btn-danger" href="{{ route( 'touch-screen', [ 'event_instance_name' => $event_instance_name, 'debug' => true ] ) }}" target="_blank">Open Touch Screen in Debug Mode</a></li>
              </ul>
            </div>
          </div>
        @endif
        -->

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-default" href="{{ route( 'appworks-posts.dashboard', [ 'event_instance_name' => $event_instance_name ] ) }}">Posts Dashboard</a></li>
                <li><a class="btn btn-warning" href="{{ route( 'tweets.dashboard', [ 'event_instance_name' => $event_instance_name ] ) }}">Tweets Dashboard</a></li>
              </ul>
            </div>
          </div>
        @endif

        <div class="panel panel-primary">
          <div class="panel-heading">Points</div>
          <div class="panel-body">
            <ul class="list-unstyled list-inline">
              @if( Auth::user()->is_admin )
                <a class="btn btn-default" href="{{ route( 'points', [ 'event_instance_name' => $event_instance_name ] ) }}">Points Dashboard</a></li>
              @endif
              <a class="btn btn-default" href="{{ route( 'points.award', [ 'event_instance_name' => $event_instance_name ] ) }}">Award Points</a></li>
            </ul>
          </div>
        </div>

        <!-- END: LEFT COLUMN ********************************************** -->
      
      </div>
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-6
          col-lg-6
        "
      >

        <!-- BEGIN: RIGHT COLUMN ******************************************* -->

        <div class="panel panel-primary">
          <div class="panel-heading">Screen Settings</div>
          <div class="panel-body">

            <ul class="list-unstyled list-inline">
              <li>
                <a
                  class="btn btn-success"
                  href="{{ route( 'screens.enable-all', [ 'event_instance_name' => $event_instance_name ] ) }}"
                >Enable all</a>
              </li>
              <li>
                <a
                  class="btn btn-danger"
                  href="{{ route( 'screens.disable-all', [ 'event_instance_name' => $event_instance_name ] ) }}"
                >Disable all</a>
              </li>
              <li class="pull-right">
                <a
                  class="btn btn-primary"
                  href="{{ route( 'screens', [ 'event_instance_name' => $event_instance_name ] ) }}"
                >Adjust Timings</a>
              </li>
            </ul>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Screen</th>
                  <th>Status</th>
                  <th>Toggle</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $settings as $setting )
                  <tr>
                    <td>{{ $setting->screen }}</td>

                    <td>
                      @if( $setting->screen == "test_card" )
                        <strong>SYSTEM</strong>
                      @else
                        @if( $setting->status )
                          <span class="text-success"><strong>ENABLED</strong></span>
                        @else
                        <span class="text-danger"><strong>DISABLED</strong></span>
                        @endif
                      @endif
                    </td>

                    <td>
                      @if( $setting->screen == "test_card" )
                        &nbsp;
                      @else
                        @if( $setting->status )
                          <a
                            class="btn btn-danger"
                            href="{{ route( 'screens.disable', [ 'event_instance_name' => $event_instance_name, 'id' => $setting->id ] ) }}"
                          >Disable screen</a>
                        @else
                          <a
                            class="btn btn-success"
                            href="{{ route( 'screens.enable', [ 'event_instance_name' => $event_instance_name, 'id' => $setting->id ] ) }}"
                          >Enable screen</a>
                        @endif
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>

        <!-- END: RIGHT COLUMN ********************************************* -->

      </div>
    </div>
  </div>
@endsection
