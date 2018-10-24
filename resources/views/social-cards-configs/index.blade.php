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
          <div class="panel-heading">Current Social Cards Settings</div>
          <div class="panel-body">

            <!-- BEGIN: CONFIGS LISTING ************************************ -->
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
                      <th>Fetch Batch Size: Tweets</th>
                      <th>Display Max Social Cards</th>
                      <th>AppWorks Posts Ratio</th>
                      <th>Tweets Posts Ratio</th>
                      <th>No. AppWorks Posts Featured</th>
                      <th>No. Tweets Featured</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-right">{{ $config->fetch_batchsize_tweets }}</td>
                      <td class="text-right">{{ $config->display_max_items }}</td>
                      <td class="text-right">{{ $config->appworks_posts_ratio }}%</td>
                      <td class="text-right">{{ $config->tweets_ratio }}%</td>
                      <td class="text-right">{{ $config->appworks_posts_featured }}</td>
                      <td class="text-right">{{ $config->tweets_featured }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END: CONFIGS LISTING ************************************** -->

          </div>
        </div>


        <div class="panel panel-primary">
          <div class="panel-heading">Configure Social Cards Settings</div>
          <div class="panel-body">

            <div class="row">
              <div
                class="
                  col-xs-12
                  col-sm-12
                  col-md-12
                  col-lg-12
                "
              >
                <a href="{{ route( 'social-cards-configs.reset-to-default', [ 'event_instance_name' => $event_instance_name ] ) }}" class="btn btn-danger pull-right">Reset to Defaults</a>
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
                @include( 'social-cards-configs.form' )
              </div>
            </div>

          </div>
        </div>


      </div>
    </div>
  </div>

@endsection
