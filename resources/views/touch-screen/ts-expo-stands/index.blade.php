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
          <div class="panel-heading">Touch Screen Expo Stands</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <!-- BEGIN: SEARCH FORM ************************************ -->
              <li>
                <form
                  class="form-inline"
                  method="GET"
                  action=""
                >
                  {{ csrf_field() }}
                  <span class="form-group">
                    <label for="name" class="control-label" style="margin-bottom:10px;">Search:&nbsp;</label>
                    <input
                      class="form-control"
                      name="q"
                      type="text"
                      value="{{ $request->input('q') ? $request->input('q') : '' }}"
                      style="margin-bottom:10px;"
                    >
                  </span>
                  <button type="submit" class="btn btn-primary">Search</button>
                </form>
              </li>
              <!-- END: SEARCH FORM ************************************** -->
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-expo-stands.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Expo Stand</a>
              </li>
              <li>
                <a class="btn btn-success" href="{{ route( 'ts-expo-stands.export-to-excel', [ 'event_instance_name' => $event_instance_name ] ) }}">Export to Excel</a>
              </li>
              <li class="pull-right">
                <a class="btn btn-default" href="{{ route( 'ts-expo-stands.download-excel-template', [ 'event_instance_name' => $event_instance_name ] ) }}">Download Excel Template</a>
              </li>
              <li class="pull-right">
                <modal-confirm-href-action
                  modal-id="import-from-excel-modal"
                  button-label="Import from Excel"
                  button-class="btn btn-danger pull-right"
                  action-href="{{ route( 'ts-expo-stands.import-from-excel-form', [ 'event_instance_name' => $event_instance_name ] ) }}"
                  message-html="{{ '<p class="text-danger"><strong>WARNING:</strong> Importing the Expo Stands from an Excel file may <strong>DELETE</strong> all of the current Expo Stand records in the system and replace them with the contents of the Excel file.</p><p class="text-danger">Are you sure that you want to do this?</p><p class="text-danger">This operation CANNOT be undone!</p>' }}"
                ></modal-confirm-href-action>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $expo_stands->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'expo_level_id', 'Exhibitor Level' )</th>
                  <th>@sortablelink( 'exhibitor', 'Exhibitor' )</th>
                  <th>@sortablelink( 'stand', 'Stand' )</th>
                  <th>@sortablelink( 'expo_map_id', 'Expo Map ID / Name' )</th>
                  <th>Map Image</th>
                  <th>@sortablelink( 'position_x', 'Position X' )</th>
                  <th>@sortablelink( 'position_y', 'Position Y' )</th>
                  <th>@sortablelink( 'hidden', 'Hidden' )</th>
                  <th>@sortablelink( 'updated_at', 'Modified' )</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $expo_stands as $expo_stand )

                  <tr>

                    <td>{{ $expo_stand->id }}</td>

                    <td>({{ $expo_stand->expo_level_id }}) {{ $expo_stand->expo_level->name }} </td>
                    
                    <td>{{ $expo_stand->exhibitor }}</td>

                    <td>{{ $expo_stand->stand }}</td>
                    
                    <td>
                      @if( $expo_stand->expo_map_id != null )
                        ({{ $expo_stand->expo_map_id }})
                        {{ isset( $expo_stand->expo_map->touchscreen_image ) ? $expo_stand->expo_map->touchscreen_image->name : 'N/A' }}
                      @else
                        <span class="text-danger">NO EXPO MAP SELECTED</span>
                      @endif
                    </td>

                    <td>
                      @if( $expo_stand->expo_map_id != null )
                        <img src="/storage/{{ $expo_stand->expo_map->touchscreen_image->image_xs }}" width="50">
                      @else
                      <span class="text-danger">NO EXPO MAP SELECTED</span>
                      @endif
                    </td>

                    <td>{{ $expo_stand->position_x }}%</td>
                    
                    <td>{{ $expo_stand->position_y }}%</td>

                    <td>
                      @if( $expo_stand->hidden == true )
                      <span class="text-danger">HIDDEN</span>
                      @else
                        VISIBLE
                      @endif
                    </td>

                    <td>{{ $expo_stand->updated_at }}</td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-expo-stands.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $expo_stand->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-expo-stands.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $expo_stand->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $expo_stands->links() }}

            <!-- END: LIST ************************************************* -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
