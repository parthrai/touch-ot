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
          <div class="panel-heading">AppWorks Posts Dashboard</div>
          <div class="panel-body">
            <div class="row">
              <div
                class="
                  col-xs-6
                  col-sm-6
                  col-md-6
                  col-lg-6
                "
              >
                <!-- BEGIN: SEARCH FORM ************************************ -->
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
                <!-- END: SEARCH FORM ************************************** -->
              </div>
              <div
                class="
                  col-xs-6
                  col-sm-6
                  col-md-6
                  col-lg-6
                "
              >
                <a href="{{ route( 'tweets.dashboard', [ 'event_instance_name' => $event_instance_name ] ) }}" class="btn btn-primary pull-right">Go to Tweets Dashboard</a>
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
                {{ $cards->links() }}
                <section class="admin-sns-container">
                  <table
                    id="appworks-posts"
                    class="
                      table
                      table-condensed
                      table-striped
                      table-bordered
                      table-admin-sns
                    "
                  >
                    <thead>
                      <tr>
                        <th class="text-right">ID</th>
                        <th>@sortablelink( 'post_id', "Post ID" )</th>
                        <th>@sortablelink( 'post_text', "Text" )</th>
                        <th>@sortablelink( 'first_name', "First Name" )</th>
                        <th>@sortablelink( 'last_name', "Last Name" )</th>
                        <th>@sortablelink( 'company', "Company" )</th>
                        <th>@sortablelink( 'image', "Image" )</th>
                        <th>@sortablelink( 'card_created_at', "Created" )</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Controls</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach( $cards as $card )
                        <tr>
                          
                          <td class="text-right">{{ $card->id }}</td>
                          
                          <td>{{ insert_zero_width_spaces_alphanumeric( $card->post_id ) }}</td>
                          
                          <td>{{ $card->post_text }}</td>
                          
                          <td>{{ $card->first_name }}</td>
                          
                          <td>{{ $card->last_name }}</td>
                          
                          <td>{{ $card->company }}</td>
                          
                          <td>
                            @if( isset( $card->image ) )
                              <a
                                href="{{ $card->image }}"
                                target="_blank"
                              >
                                <img
                                  src="{{ $card->image }}"
                                  style="width:8vw;"
                                >
                              </a>
                            @else
                              &nbsp;
                            @endif
                          </td>
                          
                          <td>{{ $card->card_created_at }}</td>
                          
                          <td class="text-center">
                            @if( $card->GetFeatured() )
                              <span class="text-success"><strong>FEATURED</strong></span>
                            @else
                              <span class="text-danger"><strong>UNFEATURED</strong></span>
                            @endif
                          </td>

                          <td class="text-center">
                            @if( $card->GetApproved() )
                              <span class="text-success"><strong>APPROVED</strong></span>
                            @else
                              <span class="text-danger"><strong>REJECTED</strong></span>
                            @endif
                          </td>
                          
                          <td class="text-center">
                            <div>
                              @if( $card->GetApproved() )
                                <a
                                  href="{{ route( 'appworks-posts.reject', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                  class="btn btn-danger"
                                >Reject</a>
                              @else
                                <a
                                  href="{{ route( 'appworks-posts.approve', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                  class="btn btn-success"
                                >Approve</a>
                              @endif
                            </div>
                            <br>
                            <div>
                              @if( $card->GetFeatured() )
                                <a
                                  href="{{ route( 'appworks-posts.unfeature', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                  class="btn btn-danger"
                                >Unfeature</a>
                              @else
                                <a
                                  href="{{ route( 'appworks-posts.feature', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                  class="btn btn-primary"
                                >Feature</a>
                              @endif
                            </div>
                          </td>

                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </section>
                {{ $cards->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
