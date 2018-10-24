@extends('layouts.admin-default')

@section('content')
  <div class="container-fluid">

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


        @if( Auth::user()->is_admin )

          <div class="panel panel-primary">
            <div class="panel-heading">Event Instances</div>
            <div class="panel-body">

              <!-- BEGIN: SEARCH FORM ************************************** -->
              <form
                class="form-inline"
                method="GET"
                action=""
              >
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="name" class="control-label">Search:&nbsp;</label>
                  <input
                    class="form-control"
                    name="q"
                    type="text"
                    value="{{ $request->input('q') ? $request->input('q') : '' }}"
                  >
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a class="btn btn-default" href="{{ route( 'home' ) }}">Show All</a>
              </form>
              <br>
              <!-- END: SEARCH FORM **************************************** -->

              <!-- BEGIN: LIST ********************************************* -->

              {{ $event_instances->links() }}

              <table class="table table-bordered table-striped">
                <thead>
                <th>@sortablelink( 'id', "ID" )</th>
                <th>@sortablelink( 'name', "Event Name" )</th>
                <th>@sortablelink( 'display_name', "Display Name" )</th>
                <th>@sortablelink( 'active', "Active" )</th>
                <th>@sortablelink( 'timezone', "Time Zone" )</th>
                <th>@sortablelink( 'date_start', "Date Start" )</th>
                <th>@sortablelink( 'date_end', "Date End" )</th>
                <th>@sortablelink( 'game_enabled', "Game Enabled" )</th>
                <th>@sortablelink( 'event_uuid', "AppWorks API Event UUID" )</th>
                <th>Administer Event</th>
                </thead>
                <tbody>

                  @foreach( $event_instances as $event_instance )
                    <tr>

                      <td>{{ $event_instance->id }}</td>

                      <td>
                        <a
                          href="{{ route( 'dashboard', [ 'event_instance_name' => $event_instance->name ] ) }}"
                        >{{ $event_instance->name }}</a>
                      </td>

                      <td><strong>{{ $event_instance->display_name }}</strong></td>
                      
                      <td>
                        @if( $event_instance->active == true )
                          <span class="text-success">ACTIVE</span>
                        @else
                        <span class="text-danger">INACTIVE</span>
                        @endif
                      </td>
                      
                      <td>{{ $event_instance->timezone }}</td>
                      
                      <td>{{ $event_instance->date_start }}</td>
                      
                      <td>{{ $event_instance->date_end }}</td>
                      
                      <td>
                        @if( $event_instance->game_enabled == true )
                          YES
                        @else
                          NO
                        @endif
                      </td>
                      
                      <td>{{ $event_instance->event_uuid }}</td>
                      
                      <td>
                        <a
                          class="btn btn-primary"
                          href="{{ route( 'dashboard', [ 'event_instance_name' => $event_instance->name ] ) }}"
                        >Administer</a>
                      </td>

                    </tr>
                  @endforeach

                </tbody>
              </table>

              {{ $event_instances->links() }}

              <!-- END: LIST *********************************************** -->

            </div>
          </div>

        @else
          <h2>AUTHORIZED PERSONNEL ONLY!</h2>
        @endif

      </div>
    </div>
  </div>
@endsection
