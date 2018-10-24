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
          <div class="panel-heading">Touch Screen Agenda Announcements</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-agenda-announcements.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Agenda Announcement</a>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $announcements->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'announcement', 'Announcement' )</th>
                  <th>@sortablelink( 'updated_at', 'Modified' )</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $announcements as $announcement )

                  <tr>

                    <td>{{ $announcement->id }}</td>

                    <td>{{ $announcement->announcement }}</td>

                    <td>{{ $announcement->updated_at }}</td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-agenda-announcements.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-agenda-announcements.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $announcements->links() }}

            <!-- END: LIST ************************************************* -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
