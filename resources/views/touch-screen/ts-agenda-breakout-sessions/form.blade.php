<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Date ********************************************************* -->
  <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
    <label for="date" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Date</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="date"
        name="date"
        value="{{ isset( $breakout->date ) ? $breakout->date : '' }}"
        required
      >
      @if( $errors->has( 'date' ) )
        <span class="help-block">
          <strong>{{ $errors->first('date') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Date *********************************************************** -->

  <!-- BEGIN: Time Start *************************************************** -->
  <div class="form-group{{ $errors->has('time_start') ? ' has-error' : '' }}">
    <label for="time_start" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Start Time</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="time"
        name="time_start"
        value="{{ isset( $breakout->time_start ) ? $breakout->time_start : '' }}"
        required
      >
      @if( $errors->has( 'time_start' ) )
        <span class="help-block">
          <strong>{{ $errors->first('time_start') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Time Start ***************************************************** -->

  <!-- BEGIN: Time End ***************************************************** -->
  <div class="form-group{{ $errors->has('time_end') ? ' has-error' : '' }}">
    <label for="time_end" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">End Time</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="time"
        name="time_end"
        value="{{ isset( $breakout->time_end ) ? $breakout->time_end : '' }}"
        required
      >
      @if( $errors->has( 'time_end' ) )
        <span class="help-block">
          <strong>{{ $errors->first('time_end') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Time End ******************************************************* -->

  <!-- BEGIN: Display Order ************************************************ -->
  <div class="form-group{{ $errors->has('display_order') ? ' has-error' : '' }}">
    <label for="display_order" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Display Order</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="display_order"
        required="required"
      >
        @if( isset( $breakout ) )
          @for( $i = 1 ; $i <= 150 ; $i++ )
            @if( $breakout->display_order == $i )
              <option
                value="{{ $i }}"
                selected="selected"
              >{{ $i }}</option>
            @else
              <option
                value="{{ $i }}"
              >{{ $i }}</option>
            @endif
          @endfor
        @else
          @for( $i = 1 ; $i <= 150 ; $i++ )
            <option
              value="{{ $i }}"
            >{{ $i }}</option>
          @endfor
        @endif
      </select>
      @if( $errors->has( 'display_order' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'display_order' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Display Order ************************************************** -->

  <!-- BEGIN: Icon ********************************************************* -->
  <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
    <label for="icon" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Icon</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="icon"
        required="required"
      >
        @php
          $icon_list = [ 'cloud' ];
        @endphp
        @if( isset( $breakout ) )
          @foreach( $icon_list as $icon )
            @if( $breakout->icon ==$icon )
              <option
                value="{{ $icon }}"
                selected="selected"
              >{{ $icon }}</option>
            @else
              <option
                value="{{ $icon }}"
              >{{ $icon }}</option>
            @endif
          @endforeach
        @else
          @foreach( $icon_list as $icon )
            <option
              value="{{ $icon }}"
            >{{ $icon }}</option>
          @endforeach
        @endif
      </select>
      @if( $errors->has( 'icon' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'icon' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Icon *********************************************************** -->

  <!-- BEGIN: Title ******************************************************** -->
  <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Title</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="title"
        value="{{ isset( $breakout->title ) ? $breakout->title : '' }}"
        disabled
      >
      @if( $errors->has( 'title' ) )
        <span class="help-block">
          <strong>{{ $errors->first('title') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Title ********************************************************** -->

  <!-- BEGIN: Title Override *********************************************** -->
  <div class="form-group{{ $errors->has('title_override') ? ' has-error' : '' }}">
    <label for="title_override" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Title Override</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="title_override"
        value="{{ isset( $breakout->title_override ) ? $breakout->title_override : '' }}"
        required
      >
      @if( $errors->has( 'title_override' ) )
        <span class="help-block">
          <strong>{{ $errors->first('title_override') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Title Override ************************************************* -->

  <!-- BEGIN: Location ***************************************************** -->
  <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
    <label for="location" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Location</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="location"
        value="{{ isset( $breakout->location ) ? $breakout->location : '' }}"
        disabled
      >
      @if( $errors->has( 'location' ) )
        <span class="help-block">
          <strong>{{ $errors->first('location') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Location ******************************************************* -->

  <!-- BEGIN: Location Override ******************************************** -->
  <div class="form-group{{ $errors->has('location_override') ? ' has-error' : '' }}">
    <label for="location_override" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Location Override</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="location_override"
        value="{{ isset( $breakout->location_override ) ? $breakout->location_override : '' }}"
        required
      >
      @if( $errors->has( 'location_override' ) )
        <span class="help-block">
          <strong>{{ $errors->first('location_override') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Location Override ********************************************** -->

  <!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
        col-xs-offset-4
        col-sm-offset-4
        col-md-offset-4
        col-lg-offset-4
      "
    >
      <button type="submit" class="btn btn-primary">
        Submit
      </button>
    </div>
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
      "
    >
      <a
        class="btn btn-danger"
        href="{{ route( 'ts-agenda-breakout-sessions', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
