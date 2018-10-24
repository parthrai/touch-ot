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
          <div class="panel-heading">Points Dashboard</div>

          <div class="panel-body">

            <!-- BEGIN: SEARCH FORM **************************************** -->
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
            <br>
            <!-- END: SEARCH FORM ****************************************** -->

            {{ $points->links() }}

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>@sortablelink( 'id', 'ID' )</th>
                  <th>@sortablelink( 'team', 'Team' )</th>
                  <th>@sortablelink( 'points', 'Points' )</th>
                  <th>@sortablelink( 'audit', 'Audit' )</th>
                  <th>@sortablelink( 'source', 'Source' )</th>
                  <th>@sortablelink( 'created_at', 'Created' ) / @sortablelink( 'updated_at', 'Updated' )</th>
                  <th>Delete</td>
                </tr>
              </thead>
              <tbody>
                @foreach( $points as $point )
                  <tr class="{{ $point->deleted_at != NULL ? 'active' : '' }}">

                    <td>{{ $point->id }}</td>

                    <td class="text-center">
                      
                      @if( array_key_exists( strtolower( $point->team ), $teams ) )

                        <team-badge
                          canvas-class=""
                          team-name="{{ $point->team }}"
                          badge-label="{{ $teams[strtolower($point->team)] }}"
                          :badge-width="40"
                          :badge-height="40"
                          badge-background-color="{{ $teams_colors[strtolower($point->team)]['hex_background_color'] }}"
                          badge-text-color="{{ $teams_colors[strtolower($point->team)]['hex_text_color'] }}"
                        ></team-badge>

                      @else
                        {{ $point->team }}
                      @endif
                    </td>

                    <td>{{ $point->points }}</td>

                    <td>{{ $point->GetAuditUserName() }}</td>

                    <td>{{ $point->source }}</td>
                    
                    <td>
                      @if( $point->updated_at == NULL )
                        {{ $point->created_at }}
                      @else
                        {{ $point->updated_at }}
                      @endif
                    </td>
                    
                    <td>
                      @if( $point->deleted_at == NULL )
                        <a
                          class="btn btn-danger"
                          href="{{ route( 'points.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $point->id ] ) }}"
                        >Delete</a>
                      @else
                        <a
                          class="btn btn-primary"
                          href="{{ route( 'points.restore', [ 'event_instance_name' => $event_instance_name, 'id' => $point->id ] ) }}"
                        >Restore</a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
            
            {{ $points->links() }}

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
