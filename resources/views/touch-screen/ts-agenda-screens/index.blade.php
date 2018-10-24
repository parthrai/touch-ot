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
          <div class="panel-heading">Touch Screen Agenda Screens</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-agenda-screens.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Agenda Screen</a>
              </li>
              <li>
                <a class="btn btn-success" href="{{ route( 'ts-agenda-screens.export-to-excel', [ 'event_instance_name' => $event_instance_name ] ) }}">Export to Excel</a>
              </li>
              <li class="pull-right">
                <modal-confirm-href-action
                  modal-id="import-from-excel-modal"
                  button-label="Import from Excel"
                  button-class="btn btn-danger pull-right"
                  action-href="{{ route( 'ts-agenda-screens.import-from-excel-form', [ 'event_instance_name' => $event_instance_name ] ) }}"
                  message-html="{{ '<p class="text-danger"><strong>WARNING:</strong> Importing the agenda screens from an Excel file will <strong>DELETE</strong> all of the current agenda screens and replace them with the contents of the Excel file.</p><p class="text-danger">Are you sure that you want to do this?</p><p class="text-danger">This operation CANNOT be undone!</p>' }}"
                ></modal-confirm-href-action>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Active</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Tab Label</th>
                  <th>Order</th>
                  <th>Announcement</th>
                  <th>Image</th>
                  <th>Modified</th>
                  <th>Actions</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $screens as $screen )

                  <tr>

                    <td>{{ $screen->id }}</td>

                    <td class="text-center">
                      @if( $screen->active == true )
                        <span class="text-success"><strong>ACTIVE</strong></span>
                      @else
                        <span class="text-danger"><strong>INACTIVE</strong></span>
                      @endif
                    </td>

                    <td>{{ $screen->type }}</td>

                    <td>{{ $screen->date }}</td>

                    <td><strong class="text-danger">{{ $screen->tab_label }}</strong></td>

                    <td class="text-center" style="white-space:nowrap;">
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-agenda-screens.bump-order-down', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >-</a>
                      &nbsp;
                      {{ $screen->display_order }}
                      &nbsp;
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-agenda-screens.bump-order-up', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >+</a>
                    </td>

                    <td>
                      @if( $screen->agenda_announcement_id != null )
                        <div>
                          ({{ $screen->agenda_announcement_id }})
                          <strong>{{ $screen->agenda_announcement->announcement }}</strong>
                        </div>
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>
                      @if( $screen->touchscreen_image_id != null )
                        <div>
                          @if( $screen->touchscreen_image->link )
                            <div>
                              <a href="{{ $screen->touchscreen_image->link }}" target="_blank">
                                <img src="/storage/{{ $screen->touchscreen_image->image_xs }}" width="50">
                              </a>
                            </div>
                            <div>
                              <a href="{{ $screen->touchscreen_image->link }}" target="_blank">
                                {{ $screen->touchscreen_image->link }}
                              </a>
                            </div>
                          @else
                            <img src="/storage/{{ $screen->touchscreen_image->image_xs }}" width="50">
                          @endif
                        </div>
                        <div>{{ $screen->touchscreen_image_id }}</div>
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>{{ $screen->updated_at }}</td>

                    <td class="text-center">
                      <ul class="list-unstyled list-inline">
                        <li>
                          @if( $screen->active == true )
                            <a
                              href="{{ route('ts-agenda-screens.deactivate', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                              class="btn btn-danger"
                            >Deactivate</a>
                          @else
                            <a
                              href="{{ route('ts-agenda-screens.activate', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                              class="btn btn-success"
                            >Activate</a>
                          @endif
                        </li>
                      </ul>
                    </td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-agenda-screens.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-agenda-screens.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            <!-- END: LIST ************************************************* -->
          
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
