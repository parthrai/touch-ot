@extends('layouts.admin-event')

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

        <div class="panel panel-primary">
          <div class="panel-heading">Touch Screen Agenda Breakout Sessions</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->

            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-agenda-breakout-sessions.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Agenda Breakout Session</a>
              </li>
              <li>
                <a class="btn btn-success" href="{{ route( 'ts-agenda-breakout-sessions.export-to-excel', [ 'event_instance_name' => $event_instance_name ] ) }}">Export to Excel</a>
              </li>
              <li class="pull-right">
                <a class="btn btn-default" href="{{ route( 'ts-agenda-breakout-sessions.download-excel-template', [ 'event_instance_name' => $event_instance_name ] ) }}">Download Excel Template</a>
              </li>
              <li class="pull-right">
                <modal-confirm-href-action
                  modal-id="import-from-excel-modal"
                  button-label="Import from Excel"
                  button-class="btn btn-danger pull-right"
                  action-href="{{ route( 'ts-agenda-breakout-sessions.import-from-excel-form', [ 'event_instance_name' => $event_instance_name ] ) }}"
                  message-html="{{ '<p class="text-danger"><strong>WARNING:</strong> Importing the breakout sessions from an Excel file may <strong>DELETE</strong> all of the current breakout sessions records in the system and replace them with the contents of the Excel file.</p><p class="text-danger">Are you sure that you want to do this?</p><p class="text-danger">This operation CANNOT be undone!</p>' }}"
                ></modal-confirm-href-action>
              </li>
            </ul>

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
            </form>

            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $breakouts->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'session_id', 'Session ID' )</th>
                  <th>@sortablelink( 'date', 'Date' )</th>
                  <th>@sortablelink( 'time_start', 'Start Time' )</th>
                  <th>@sortablelink( 'time_end', 'End Time' )</th>
                  <th>@sortablelink( 'display_order', 'Order' )</th>
                  <th>@sortablelink( 'icon', 'Icon' )</th>
                  <th>@sortablelink( 'title', 'Title' )</th>
                  <th>@sortablelink( 'title_override', 'Title Override' )</th>
                  <th>@sortablelink( 'location', 'Location' )</th>
                  <th>@sortablelink( 'location_override', 'Location Override' )</th>
                  <th>@sortablelink( 'updated_at', 'Modified' )</th>
                  <th>Edit</th>
                  <th>Hide/Show</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $breakouts as $breakout )

                  <tr class="{{ $breakout->hidden == true ? 'text-muted' : '' }}">

                    <td>{{ $breakout->id }}</td>

                    <td>{{ $breakout->session_id }}</td>

                    <td>{{ $breakout->date }}</td>

                    <td>{{ $breakout->time_start }}</td>

                    <td>{{ $breakout->time_end }}</td>

                    <td class="text-center" style="white-space:nowrap;">
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-agenda-breakout-sessions.bump-order-down', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                      >-</a>
                      &nbsp;
                      {{ $breakout->display_order }}
                      &nbsp;
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-agenda-breakout-sessions.bump-order-up', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                      >+</a>
                    </td>

                    <td>{{ $breakout->icon }}</td>

                    <td>{{ $breakout->title }}</td>

                    <td><strong class="text-primary">{{ $breakout->title_override }}</strong></td>

                    <td>{{ $breakout->location }}</td>

                    <td><strong class="text-primary">{{ $breakout->location_override }}</strong></td>

                    <td>{{ $breakout->updated_at }}</td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-agenda-breakout-sessions.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      @if(  $breakout->hidden )
                        <a
                          class="btn btn-default"
                          href="{{ route( 'ts-agenda-breakout-sessions.unhide', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                        >Show</a>
                      @else
                        <a
                          class="btn btn-warning"
                          href="{{ route( 'ts-agenda-breakout-sessions.hide', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                        >Hide</a>
                      @endif
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-agenda-breakout-sessions.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $breakout->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $breakouts->links() }}

            <!-- END: LIST ************************************************* -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
