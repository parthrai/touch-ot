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
          <div class="panel-heading">Tweets Dashboard</div>
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
                <a href="{{ route( 'appworks-posts.dashboard', [ 'event_instance_name' => $event_instance_name ] ) }}" class="btn btn-primary pull-right">Go to AppWorks Posts Dashboard</a>
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
                    id="tweets"
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
                        <th>@sortablelink( 'tweet_id', "Tweet ID" )</th>
                        <th>@sortablelink( 'tweet_text', "Text" )</th>
                        <th>@sortablelink( 'user_screen_name', "Screen Name" )</th>
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
                          <td>
                            <a
                              href="https://twitter.com/{{ $card->user_screen_name }}/status/{{ $card->tweet_id }}"
                              target="_blank"
                            >
                              {{ insert_zero_width_spaces_alphanumeric( $card->tweet_id ) }}
                            </a>
                          </td>
                          <td>{{ $card->tweet_text }}</td>
                          <td>
                            <a
                              href="https://twitter.com/{{ $card->user_screen_name }}"
                              target="_blank"
                            >
                              &commat;{{ $card->user_screen_name }}
                            </a>
                          </td>
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
                            <ul class="list-unstyled list-inline">
                              <li>
                                @if( $card->GetApproved() )
                                  <a
                                    href="{{ route( 'tweets.reject', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                    class="btn btn-danger"
                                  >Reject</a>
                                @else
                                  <a
                                    href="{{ route( 'tweets.approve', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                    class="btn btn-success"
                                  >Approve</a>
                                @endif
                              </li>
                              <li>
                                @if( $card->GetFeatured() )
                                  <a
                                    href="{{ route( 'tweets.unfeature', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                    class="btn btn-danger"
                                  >Unfeature</a>
                                @else
                                  <a
                                    href="{{ route( 'tweets.feature', [ 'event_instance_name' => $event_instance_name, 'id' => $card->id ] ) }}"
                                    class="btn btn-primary"
                                  >Feature</a>
                                @endif
                              </li>
                            </ul>
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
