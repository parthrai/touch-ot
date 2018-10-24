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
          <div class="panel-heading">Touch Screen Map Screens</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-map-screens.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Map Screen</a>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $screens->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'name', 'Name' )</th>
                  <th>@sortablelink( 'active', 'Active' )</th>
                  <th>@sortablelink( 'tab_label', 'Tab Label' )</th>
                  <th>@sortablelink( 'display_order', 'Order' )</th>
                  <th>@sortablelink( 'caption', 'Caption' )</th>
                  <th>@sortablelink( 'touchscreen_image_id', 'Image' )</th>
                  <th>@sortablelink( 'updated_at', 'Modified' )</th>
                  <th>Actions</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $screens as $screen )

                  <tr>

                    <td>{{ $screen->id }}</td>

                    <td>{{ $screen->name }}</td>

                    <td class="text-center">
                      @if( $screen->active == true )
                        <span class="text-success"><strong>ACTIVE</strong></span>
                      @else
                        <span class="text-danger"><strong>INACTIVE</strong></span>
                      @endif
                    </td>

                    <td><strong class="text-danger">{{ $screen->tab_label }}</strong></td>

                    <td class="text-center" style="white-space:nowrap;">
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-map-screens.bump-order-down', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >-</a>
                      &nbsp;
                      {{ $screen->display_order }}
                      &nbsp;
                      <a
                        class="btn btn-default"
                        href="{{ route( 'ts-map-screens.bump-order-up', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >+</a>
                    </td>

                    <td>{{ $screen->caption }}</td>

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
                              href="{{ route('ts-map-screens.deactivate', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                              class="btn btn-danger"
                            >Deactivate</a>
                          @else
                            <a
                              href="{{ route('ts-map-screens.activate', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                              class="btn btn-success"
                            >Activate</a>
                          @endif
                        </li>
                      </ul>
                    </td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-map-screens.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-map-screens.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $screen->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $screens->links() }}

            <!-- END: LIST ************************************************* -->
          
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
