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
          <div class="panel-heading">Configure Teams</div>
          <div class="panel-body">

            <!-- BEGIN: OVERALL CONTROLS *********************************** -->
            <ul class="list-unstyled list-inline">
              <li>
                <a class="btn btn-primary" href="{{ route( 'configure-teams.create', [ 'event_instance_name' => $event_instance_name ] ) }}">Add Team</a>
              </li>
              <li class="pull-right">
                <modal-confirm-href-action
                  modal-id="reset-teams-modal"
                  button-label="Reset Teams"
                  button-class="btn btn-danger pull-right"
                  action-href="{{ route( 'configure-teams.reset-teams', [ 'event_instance_name' => $event_instance_name ] ) }}"
                  message-html="{{ '<p>Are you sure that you want to reset the team configuration to the default settings?</p><p class="text-danger">This operation CANNOT be undone!</p>' }}"
                ></modal-confirm-href-action>
              </li>
            </ul>
            <!-- END: OVERALL CONTROLS ************************************* -->

            <!-- BEGIN: TEAMS LISTING ************************************** -->
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
                      <th>Name</th>
                      <th>Display Name</th>
                      <th>Hashtag</th>
                      <th class="text-center">Badge</th>
                      <th>Background Colour</th>
                      <th>Text Colour</th>
                      <th>Invisible</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach( $teams as $team )
                      <tr>

                        <td class="text-right">{{ $team->id }}</td>
                        
                        <td>{{ $team->name }}</td>

                        <td>{{ $team->display_name }}</td>
                        
                        <td>{{ $team->hashtag }}</td>
                        
                        <td class="text-center">
                          <team-badge
                            canvas-class=""
                            team-name="{{ $team->name }}"
                            badge-label="{{ $team->hashtag }}"
                            :badge-width="50"
                            :badge-height="50"
                            badge-background-color="{{ $team->hex_background_color }}"
                            badge-text-color="{{ $team->hex_text_color }}"
                          ></team-badge>
                        </td>
                        
                        <td>{{ $team->hex_background_color }}</td>
                        
                        <td>{{ $team->hex_text_color }}</td>
                        
                        <td>
                          @if( $team->invisible )
                            <span class="text-danger"><strong>INVISIBLE</strong></span>
                          @else
                            <span class="text-success"><strong>VISIBLE</strong></span>
                          @endif
                        </td>

                        <td>
                          <a
                            class="btn btn-primary"
                            href="{{ route( 'configure-teams.edit', [ 'event_instance_name' => $event_instance_name, 'id' => $team->id ] ) }}"
                          >Edit</a>
                        </td>
                        
                        <td>
                          <modal-confirm-href-action
                            modal-id="config-teams-modal-id-{{ $team->id }}"
                            button-label="Delete"
                            button-class="btn btn-danger"
                            action-href="{{ route( 'configure-teams.delete', [ 'event_instance_name' => $event_instance_name, 'id' => $team->id ] ) }}"
                            message-html="{{ '<p>Are you sure that you want to delete the <strong>' . $team->name . '</strong> team?</p><p class=\'text-danger\'>This operation CANNOT be undone!</p>' }}"
                          ></modal-confirm-href-action>
                        </td>
                      
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END: TEAMS LISTING **************************************** -->

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
