<form
  class="form"
  enctype="multipart/form-data"
  method="POST"
  action="{{ route( 'social-cards-configs.set-configs', [ 'event_instance_name' => $event_instance_name ] ) }}"
>

  {{ csrf_field() }}

  <!-- BEGIN: Fetch Batchsize Tweets *************************************** -->
  <div class="form-group{{ $errors->has('num_fetch_batchsize_tweets') ? ' has-error' : '' }}">
    <label for="num_fetch_batchsize_tweets" class="control-label">Fetch Batch Size: Tweets</label>
    <select
      class="form-control"
      name="num_fetch_batchsize_tweets"
      required="required"
    >
      @for( $i = 10 ; $i <= 250 ; $i += 10 )
        @if( $config->fetch_batchsize_tweets == $i )
          <option
            value="{{ $i }}"
            selected="selected"
          >{{ $i }} tweets</option>
        @else
          <option
            value="{{ $i }}"
            >{{ $i }} tweets</option>
        @endif
      @endfor
    </select>
    @if( $errors->has( 'num_fetch_batchsize_tweets' ) )
      <span class="help-block">
        <strong>{{ $errors->first( 'num_fetch_batchsize_tweets' ) }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Fetch Batchsize Tweets ***************************************** -->

  <!-- BEGIN: Display Max Social Cards ************************************* -->
  <div class="form-group{{ $errors->has('num_display_max_items') ? ' has-error' : '' }}">
    <label for="num_display_max_items" class="control-label">Display Maximum Social Cards</label>
    <select
      class="form-control"
      name="num_display_max_items"
      required="required"
    >
      @for( $i = 10 ; $i <= 250 ; $i += 10 )
        @if( $config->display_max_items == $i )
          <option
            value="{{ $i }}"
            selected="selected"
          >{{ $i }} cards</option>
        @else
          <option
            value="{{ $i }}"
            >{{ $i }} cards</option>
        @endif
      @endfor
    </select>
    @if( $errors->has( 'num_display_max_items' ) )
      <span class="help-block">
        <strong>{{ $errors->first( 'num_display_max_items' ) }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Display Max Social Cards *************************************** -->

  <!-- BEGIN: Ratios ******************************************************* -->
  <div class="form-group{{ $errors->has('ratios') ? ' has-error' : '' }}">
    <label for="ratios" class="control-label">Ratios</label>
    <select
      class="form-control"
      name="ratios"
      required="required"
    >
      @for( $i = 0 ; $i <= 100 ; $i += 10 )
        @php
          $struct = json_encode(
            [
              'appworks_posts' => $i,
              'tweets'         => 100 - $i
            ]
          );
        @endphp
        @if( $config->appworks_posts_ratio == $i )
          <option
            value="{{ $struct }}"
            selected="selected"
          >
            AppWorks Posts {{ $i }}%
            /
            Tweets {{ 100 - $i }}%
          </option>
        @else
          <option
            value="{{ $struct }}"
          >
            AppWorks Posts {{ $i }}%
            /
            Tweets {{ 100 - $i }}%
          </option>
        @endif
      @endfor
    </select>
    @if( $errors->has( 'ratios' ) )
      <span class="help-block">
        <strong>{{ $errors->first( 'ratios' ) }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Ratios ********************************************************* -->

  <!-- BEGIN: Number of Featured AppWorks Posts **************************** -->
  <div class="form-group{{ $errors->has('num_featured_appworks_posts') ? ' has-error' : '' }}">
    <label for="num_featured_appworks_posts" class="control-label">No. of Featured AppWorks Posts</label>
    <select
      class="form-control"
      name="num_featured_appworks_posts"
      required="required"
    >
      @for( $i = 0 ; $i <= 4 ; $i++ )
        @if( $config->appworks_posts_featured == $i )
          <option value="{{ $i }}" selected="selected">{{ $i }}</option>
        @else
          <option value="{{ $i }}">{{ $i }}</option>
        @endif
      @endfor
    </select>
    @if( $errors->has( 'num_featured_appworks_posts' ) )
      <span class="help-block">
        <strong>{{ $errors->first( 'num_featured_appworks_posts' ) }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Number of Featured AppWorks Posts ****************************** -->

  <!-- BEGIN: Number of Featured Tweets ************************************ -->
  <div class="form-group{{ $errors->has('num_featured_tweets') ? ' has-error' : '' }}">
    <label for="num_featured_tweets" class="control-label">No. of Featured Tweets</label>
    <select
      class="form-control"
      name="num_featured_tweets"
      required="required"
    >
      @for( $i = 0 ; $i <= 4 ; $i++ )
        @if( $config->tweets_featured == $i )
          <option value="{{ $i }}" selected="selected">{{ $i }}</option>
        @else
          <option value="{{ $i }}">{{ $i }}</option>
        @endif
      @endfor
    </select>
    @if( $errors->has( 'num_featured_tweets' ) )
      <span class="help-block">
        <strong>{{ $errors->first( 'num_featured_tweets' ) }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Number of Featured Tweets ************************************** -->

  <!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Save Configuration">
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
