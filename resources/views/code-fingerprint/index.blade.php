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
      </div>
    </div>

    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-12
          col-lg-12
        "
      >

        <!-- BEGIN: LIST *************************************************** -->

        <div class="panel panel-primary">
          <div class="panel-heading">Code Fingerprint Settings</div>
          <div class="panel-body">

            <p>Poking the code fingerprint will cause all screens to reload.</p>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Current Fingerprint</th>
                  <th>Screen Type</th>
                  <th>Last Modified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $fingerprints as $fingerprint )
                  <tr>
                    <td>{{ $fingerprint->id }}</td>
                    <td>{{ $fingerprint->screen_type }}</td>
                    <td>{{ $fingerprint->created_at }}</td>
                    <td>
                      <a
                        class="btn btn-danger"
                        href="{{ route( 'code-fingerprint.poke', [ 'event_instance_name' => $event_instance_name, 'screen_type' => $fingerprint->screen_type ] ) }}"
                      >Increment Fingerprint</a>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>

          </div>
        </div>

        <!-- END: LIST ***************************************************** -->

      </div>
    </div>
  </div>
@endsection
