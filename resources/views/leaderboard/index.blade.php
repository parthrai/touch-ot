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

        <div class="panel panel-primary">
          <div class="panel-heading">Main Screen Leaderboards</div>
          <div class="panel-body">

            <p><a class="btn btn-primary" href="{{ route( 'leaderboard.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add Leaderboard</a></p>

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  @foreach( \App\Leaderboard::$image_size_codes as $image_size )
                    <th>Image: {{ strtoupper( $image_size ) }}</th>
                  @endforeach
                  <th>Created</th>
                  <th>Display Order</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $leaderboards as $leaderboard )
                  
                  <tr>
                    
                    <td>{{ $leaderboard->id }}</td>
                    
                    <td>{{ $leaderboard->name }}</td>
                    
                    @foreach( \App\Leaderboard::$image_sizes as $image_size )
                      <td>
                        <img
                          src="{{ Storage::url( $leaderboard[$image_size] ) }}"
                          style="width:100px;"
                        >
                      </td>
                    @endforeach
                    
                    <td>{{ $leaderboard->created_at }}</td>
                    
                    <td>
                      <a
                        class="btn btn-default"
                        href="{{ route( 'leaderboard.bump-order-down', [ 'event_instance_name' => $event_instance_name, 'id' => $leaderboard->id ] ) }}"
                      >-</a>
                      &nbsp;
                      {{ $leaderboard->display_order }}
                      &nbsp;
                      <a
                        class="btn btn-default"
                        href="{{ route( 'leaderboard.bump-order-up', [ 'event_instance_name' => $event_instance_name, 'id' => $leaderboard->id ] ) }}"
                      >+</a>
                    </td>
                    
                    <td>
                      <a
                        class="btn btn-primary"
                        href="{{ route( 'leaderboard.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $leaderboard->id ] ) }}"
                      >Edit</a>
                    </td>
                    
                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'leaderboard.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $leaderboard->id ] ) }}"
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
