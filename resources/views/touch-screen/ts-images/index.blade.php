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
          <div class="panel-heading">Touch Screen Images</div>
          <div class="panel-body">

            <!-- BEGIN: CONTROLS ******************************************* -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'ts-images.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add New Image</a>
              </li>
            </ul>
            <!-- END: CONTROLS ********************************************* -->

            <!-- BEGIN: LIST *********************************************** -->

            {{ $images->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'name', 'Name' )</th>
                  @foreach( \App\TouchscreenImage::$image_size_codes as $image_size )
                    <th>@sortablelink( $image_size, 'Image: ' . strtoupper( $image_size ) )</th>
                  @endforeach
                  <th>@sortablelink( 'link', 'Link URL' )</th>
                  <th>@sortablelink( 'updated_at', 'Modified' )</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $images as $image )

                  <tr>

                    <td>{{ $image->id }}</td>

                    <td>{{ $image->name }}</td>

                    @foreach( \App\TouchscreenImage::$image_sizes as $image_size )
                      <td>
                        <img
                          src="{{ Storage::url( $image[$image_size] ) }}"
                          style="width:100px;"
                        >
                      </td>
                    @endforeach

                    <td>
                      @if( isset( $image->link ) )
                        <a
                          href="{{ $image->link }}"
                          target="_blank"
                        >{{ $image->link }}</a>
                      @else
                        &nbsp;
                      @endif
                    </td>

                    <td>{{ $image->updated_at }}</td>

                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'ts-images.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $image->id ] ) }}"
                      >Edit</a>
                    </td>

                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'ts-images.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $image->id ] ) }}"
                      >Delete</a>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

            {{ $images->links() }}

            <!-- END: LIST ************************************************* -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
