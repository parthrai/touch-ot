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
          <div class="panel-heading">Configure Twitter Hashtags</div>
          <div class="panel-body">

            <!-- BEGIN: CREATE FORM **************************************** -->
            <div class="row">
              <div
                class="
                  col-xs-12
                  col-sm-12
                  col-md-12
                  col-lg-12
                "
              >
                @include( 'twitter-configs.form' )
              </div>
            </div>
            <br>
            <!-- END: CREATE FORM ****************************************** -->

            <!-- BEGIN: HASHTAG LISTING ************************************ -->
            <div class="row">
              <div
                class="
                  col-xs-12
                  col-sm-12
                  col-md-12
                  col-lg-12
                "
              >
                <table class="table table-condensed table-striped table-bordered">
                  <thead>
                    <tr>
                      <th class="text-right">ID</th>
                      <th>Hashtag</th>
                      <th>Status</th>
                      <th>Toggle</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach( $configs as $config )
                      <tr>

                        <td class="text-right">{{ $config->id }}</td>
                                               
                        <td>{{ $config->hashtag }}</td>

                        <td>
                          @if( $config->enabled )
                            <span class="text-success"><strong>ENABLED</strong></span>
                          @else
                            <span class="text-danger"><strong>DISABLED</strong></span>
                          @endif
                        </td>

                        <td>
                          @if( $config->enabled )
                            <a class="btn btn-danger" href="{{ route( 'twitter-hashtags.disable', [ 'event_instance_name' => $event_instance_name, 'id' => $config->id ] ) }}">Disable</a>
                          @else
                            <a class="btn btn-success" href="{{ route( 'twitter-hashtags.enable', [ 'event_instance_name' => $event_instance_name, 'id' => $config->id ] ) }}">Enable</a>
                          @endif
                        </td>

                        <td>
                          <modal-confirm-href-action
                            modal-id="twitter-hashtags-delete-modal-id-{{ $config->id }}"
                            button-label="Delete"
                            button-class="btn btn-danger"
                            action-href="{{ route( 'twitter-hashtags.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $config->id ] ) }}"
                            message-html="{{ '<p>Are you sure that you want to delete the <strong>' . $config->hashtag . '</strong>?</p><p class=\'text-danger\'>This operation CANNOT be undone!</p>' }}"
                          ></modal-confirm-href-action>
                        </td>
                      
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END: HASHTAG LISTING ************************************** -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
