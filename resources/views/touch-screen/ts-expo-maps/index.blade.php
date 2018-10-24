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
          <div class="panel-heading">Touch Screen Expo Maps</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-expo-maps.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Expo Map</a>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $expo_maps->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Touchscreen Image ID</th>
                  <th>Image</th>
                  <th>Default</th>
                  <th>Modified</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $expo_maps as $expo_map )

                  <tr>

                    <td>{{ $expo_map->id }}</td>

                    <td>{{ $expo_map->name }}</td>

                    <td>
                      @if( $expo_map->touchscreen_image_id != null )
                        <div>
                          ({{ $expo_map->touchscreen_image_id }})
                          <strong>{{ $expo_map->touchscreen_image->name }}</strong>
                        </div>
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>
                      @if( $expo_map->touchscreen_image_id != null )
                        <img src="/storage/{{ $expo_map->touchscreen_image->image_xs }}" width="50">
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>
                      @if( $expo_map->default == true )
                        DEFAULT
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>{{ $expo_map->updated_at }}</td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-expo-maps.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $expo_map->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-expo-maps.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $expo_map->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $expo_maps->links() }}

            <!-- END: LIST ************************************************* -->
          
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
