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
          <div class="panel-heading">Announcements</div>
          <div class="panel-body">

            <p><a class="btn btn-primary" href="{{ route( 'announcements.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Announcement</a></p>

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Active</th>
                  <th>Announcement</th>
                  <th>Created</th>
                  <th>Action</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $announcements as $announcement )

                  <tr>

                    <td>{{ $announcement->id }}</td>

                    <td class="text-center">
                      @if( $announcement->active == true )
                        <span class="text-success"><strong>ACTIVE</strong></span>
                      @else
                        <span class="text-danger"><strong>DEACTIVATED</strong></span>
                      @endif
                    </td>

                    <td>{{ $announcement->announcement }}</td>

                    <td>{{ $announcement->created_at }}</td>

                    <td class="text-center">
                      <ul class="list-unstyled list-inline">
                        <li>
                          @if( $announcement->active == true )
                            <a
                              href="{{ route('announcements.deactivate', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                              class="btn btn-danger"
                            >Deactivate</a>
                          @else
                            <a
                              href="{{ route('announcements.activate', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                              class="btn btn-success"
                            >Activate</a>
                          @endif
                        </li>
                      </ul>
                    </td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'announcements.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'announcements.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $announcement->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
