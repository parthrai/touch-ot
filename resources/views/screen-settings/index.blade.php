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
          col-md-12
          col-lg-12
        "
      >

        <!-- BEGIN: LIST *************************************************** -->

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
                <modal-confirm-href-action
                  modal-id="reset-screens-modal"
                  button-label="Reset to Defaults"
                  button-class="btn btn-danger"
                  action-href="{{ route( 'screens.reset-to-defaults', [ 'event_instance_name' => $event_instance_name ] ) }}"
                  message-html="{{ '<p>Are you sure that you want to reset the screen configurations to the default settings?</p><p class="text-danger">This operation CANNOT be undone!</p>' }}"
                ></modal-confirm-href-action>
              </li>
            </ul>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Screen</th>
                  <th>Status</th>
                  <th>Toggle</th>
                  <th>Duration</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $settings as $setting )
                  <tr>

                    <td>{{ $setting->id }}</td>

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

                    <td>
                      <form
                        class="form-inline"
                        enctype="multipart/form-data"
                        method="POST"
                        action="{{ route( 'screens.set-duration', [ 'event_instance_name' => $event_instance_name, 'id' => $setting->id ] ) }}"
                      >
                        {{ csrf_field() }}
                        <div class="form-group">
                          <select
                            class="form-control"
                            name="duration"
                          >
                            @for( $i = 3000 ; $i <= 60000 ; $i += 1000 )

                              @if( isset( $setting ) && ( $setting->duration == $i ) )
                                <option
                                  value="{{ $i }}"
                                  selected="selected"
                                >{{ intval( $i / 1000 ) }} seconds</option>
                              @else
                                <option
                                  value="{{ $i }}"
                                  >{{ intval( $i / 1000 ) }} seconds</option>
                              @endif
                            @endfor
                          </select>
                        </div>
                        &nbsp;
                        <input class="btn btn-primary" type="submit" value="Update">
                      </form>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>

        <!-- END: LIST ***************************************************** -->

      </div>
    </div>
  </div>
@endsection
