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
          <div class="panel-heading">Final Countdown Settings</div>
          <div class="panel-body">
          
            <form
              class="form-inline"
              enctype="multipart/form-data"
              method="POST"
              action="{{ route( 'countdown.set-countdown', [ 'event_instance_name' => $event_instance_name, 'id' => $countdown->id ] ) }}"
            >

              {{ csrf_field() }}

              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Target Date</th>
                    <th>Target Time</th>
                    <th>Enabled</th>
                    <th>Actions</th>
                    <th>Toggle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>

                    <td>
                        <div class="form-group">
                          <input
                            class="form-control"
                            name="title"
                            type="text"
                            value="{{ $countdown->title }}"
                          >
                        </div>
                    </td>

                    <td>
                      <div class="form-group">
                        <input
                          class="form-control"
                          name="target_date"
                          type="date"
                          value="{{ $countdown->target_date }}"
                        >
                      </div>
                    </td>

                    <td>
                      <div class="form-group">
                        <input
                          class="form-control"
                          name="target_time"
                          type="time"
                          value="{{ $countdown->target_time }}"
                        >
                      </div>
                    </td>

                    <td>
                      @if( $countdown->enabled )
                        <span class="text-success"><strong>ENABLED</strong></span>
                      @else
                      <span class="text-danger"><strong>DISABLED</strong></span>
                      @endif
                    </td>

                    <td>
                      <input class="btn btn-primary" type="submit" value="Save Updates">
                    </td>

                    <td>
                      @if( $countdown->enabled )
                        <a
                          class="btn btn-danger"
                          href="{{ route( 'countdown.disable', [ 'event_instance_name' => $event_instance_name, 'id' => $countdown->id ] ) }}"
                        >Disable Countdown</a>
                      @else
                        <a
                          class="btn btn-success"
                          href="{{ route( 'countdown.enable', [ 'event_instance_name' => $event_instance_name, 'id' => $countdown->id ] ) }}"
                        >Enable Countdown</a>
                      @endif
                    </td>

                  </tr>

                </tbody>
              </table>

            </form>

          </div>
        </div>

        <!-- END: LIST ***************************************************** -->

      </div>
    </div>
  </div>
@endsection
